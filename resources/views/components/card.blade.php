@props([
    'image' => null,
    'imageAlt' => '',
    'title' => null,
    'href' => null,
    'badge' => null,
])

<article {{ $attributes->merge(['class' => 'card']) }}>
    @if ($image)
        <a class="card__media" href="{{ $href ?? '#' }}">
            <img src="{{ $image }}" alt="{{ $imageAlt ?: $title }}" loading="lazy">
            @if ($badge)<span class="card__badge">{{ $badge }}</span>@endif
        </a>
    @endif

    <div class="card__body">
        @if ($title)
            <h3 class="card__title">
                @if ($href)<a href="{{ $href }}">{{ $title }}</a>@else{{ $title }}@endif
            </h3>
        @endif
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card__footer">{{ $footer }}</div>
    @endisset
</article>
