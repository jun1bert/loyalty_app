@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold uppercase tracking-[0.14em] text-[var(--ink)]']) }}>
    {{ $value ?? $slot }}
</label>
