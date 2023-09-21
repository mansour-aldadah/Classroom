@php
    $name = str_replace('[', '.', $name);
    $name = str_replace(']', '', $name);
@endphp

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
