@props(['message'])

<span {{ $attributes->merge(['class' => 'error invalid-feedback']) }}>
    <strong>{{ $message }}</strong>
</span>