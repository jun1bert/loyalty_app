<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

if (filter_var(env('SERVICES_AUTO_SYNC_ENABLED', true), FILTER_VALIDATE_BOOLEAN)) {
    Schedule::command('services:sync-external')
        ->cron(env('SERVICES_AUTO_SYNC_CRON', '*/15 * * * *'))
        ->withoutOverlapping()
        ->runInBackground();
}
