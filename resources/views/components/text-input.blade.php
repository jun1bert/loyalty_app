@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border border-[var(--desert-rock)]/25 bg-[var(--feather-white)]/80 px-4 py-2.5 text-sm text-[var(--ink)] shadow-sm outline-none transition placeholder:text-[var(--muted)]/70 focus:border-[var(--desert-rock)] focus:ring-2 focus:ring-[var(--desert-rock)]/25 disabled:cursor-not-allowed disabled:opacity-60']) }}>
