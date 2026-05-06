@props(['value'])

<label class="input-label">
    {{ $value ?? $slot }}
</label>

<style>
    .input-label{
        font-size: 16px;
        color: var(--text-primary);
    }
</style>
