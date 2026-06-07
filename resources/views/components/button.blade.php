@props([
    'href' => null,
    'variant' => 'primary',   /* primary | outline | light | ghost */
    'size' => 'md',           /* sm | md | lg */
    'type' => 'button',
    'block' => false,
])

@php
    $classes = collect([
        'btn',
        'btn--'.$variant,
        $size !== 'md' ? 'btn--'.$size : null,
        $block ? 'btn--block' : null,
    ])->filter()->implode(' ');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
