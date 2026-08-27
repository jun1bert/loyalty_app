<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SyncExternalServices extends Command
{
    protected $signature = 'services:sync-external
        {--dry-run : Preview services without writing to the loyalty database}
        {--inactive : Also import inactive services from the source database}';

    protected $description = 'Sync services from another configured database into the local loyalty services table.';

    public function handle(): int
    {
        $database = config('database.connections.external_services.database');

        if (!$database) {
            $this->error('SERVICES_DB_DATABASE is not configured.');
            $this->line('Add SERVICES_DB_* values to .env, then run php artisan optimize:clear.');

            return self::FAILURE;
        }

        $table = env('SERVICES_DB_TABLE', 'services');
        $nameColumn = env('SERVICES_DB_NAME_COLUMN', 'name');
        $priceColumn = env('SERVICES_DB_PRICE_COLUMN', 'price');
        $activeColumn = env('SERVICES_DB_ACTIVE_COLUMN', 'is_active');

        try {
            if (!Schema::connection('external_services')->hasTable($table)) {
                $this->error("Source table [{$table}] was not found on the external services database.");

                return self::FAILURE;
            }

            $query = DB::connection('external_services')
                ->table($table)
                ->select([
                    $nameColumn . ' as name',
                    $priceColumn . ' as price',
                    $activeColumn . ' as is_active',
                ])
                ->whereNotNull($nameColumn)
                ->where($nameColumn, '!=', '');

            if (!$this->option('inactive')) {
                $query->where($activeColumn, true);
            }

            $sourceServices = $query
                ->orderBy($nameColumn)
                ->get();
        } catch (Throwable $exception) {
            $this->error('Unable to read external services database.');
            $this->line($exception->getMessage());

            return self::FAILURE;
        }

        if ($sourceServices->isEmpty()) {
            $this->info('No source services found.');

            return self::SUCCESS;
        }

        $created = 0;
        $updated = 0;

        foreach ($sourceServices as $sourceService) {
            $name = trim((string) $sourceService->name);

            if ($name === '') {
                continue;
            }

            $service = Service::firstOrNew([
                'name' => $name,
            ]);

            $isNew = !$service->exists;

            $service->price = $sourceService->price;
            $service->is_active = (bool) $sourceService->is_active;

            if ($isNew) {
                $service->discount_eligible = true;
            }

            if ($this->option('dry-run')) {
                $this->line(($isNew ? 'Create' : 'Update') . ": {$name} - PHP " . number_format((float) $sourceService->price, 2));
                continue;
            }

            $service->save();

            $isNew ? $created++ : $updated++;
        }

        if ($this->option('dry-run')) {
            $this->info('Dry run complete. No services were changed.');

            return self::SUCCESS;
        }

        $this->info("Services sync complete. Created: {$created}. Updated: {$updated}.");

        return self::SUCCESS;
    }
}
