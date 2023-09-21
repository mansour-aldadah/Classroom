@props([
    'name'
])

@php
    $class = $name == 'error' ? 'danger' : 'success';
@endphp


@if (session()->has($name))
    <div {{ $attributes->class(['alert']) }}>
        {{ session($name) }}
    </div>
@endif
