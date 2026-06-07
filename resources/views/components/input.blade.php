@props([
    'name' => '',
    'type' => 'text',
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'id' => null,
])

@php $id = $id ?? $name; @endphp

<div class="field">
    @if ($label)
        <label class="field__label" for="{{ $id }}">{{ $label }}</label>
    @endif
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'input']) }}
    >
</div>
