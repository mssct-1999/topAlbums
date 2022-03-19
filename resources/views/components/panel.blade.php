<div class="card custom-panel shadow {{ isset($attributes['class']) ? $attributes['class'] : null }}">
    @isset($attributes['title'])
        <div class="card-header d-align-center">
            @isset($attributes['icon']) <i class="{{ $attributes['icon'] }}"></i> @endisset    
            <div>
                <h1 class="text-15 mg-b-0 mg-l-10">{!! $attributes['title'] !!}</h1>
                @isset($attributes['subtitle']) <span class="text-12 italic">{{ $attributes['subtitle'] }}</span> @endisset
            </div>
        </div>
    @endisset
    <div class="card-body">
        <div class="card-text">
            {{ $slot }}
        </div>
    </div>
</div>