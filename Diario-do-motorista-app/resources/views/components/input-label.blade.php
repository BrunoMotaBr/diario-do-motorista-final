@props(['value', 'color' => '--text-primary'])

<label class="input-label" style="color: var({{$color}})" ;>
    {{ $value ?? $slot }}
</label>

<style>
    .input-label{
        font-size: 16px;
        font-weight: 700;
    }
</style>
