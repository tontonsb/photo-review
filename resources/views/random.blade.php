@extends('base-layout')

@section('head')
@vite(['resources/css/reviewer.css'])
@endsection

@section('body')
<main>
    <div id=image></div>

    <form method=post action="{{route('reviews.store')}}">
        @csrf
        <input type=hidden name=filepath value="{{$file->path}}">
        <input type=hidden name=reviewing_duration_ms value=0>
        <input type=hidden name=coordinates>

        <div class=actions>
            <button type=submit name=conclusion value=ok class=button--ok>@lang('reviewing.ok')</button>

            <details open>
                <summary>@lang('reviewing.suspicious')</summary>
                <textarea name=review placeholder="@lang('reviewing.describe')"></textarea>
            </details>

            <details>
                <summary>@lang('reviewing.bad img')</summary>
                <textarea name=problem></textarea>
            </details>

            <button type=submit name=conclusion value=suspect class=button--suspect>@lang('reviewing.submit')</button>

            <label>
                @lang('reviewing.continue.with')
                <select name=mode class=continue >
                    <option value=random @selected(Route::is('reviewables.random'))>@lang('reviewing.continue.random')
                    <option value=next @selected(Route::is('reviewables.review'))>@lang('reviewing.continue.sequential')
                </select>
                @lang('reviewing.continue.img')
            </label>

            <button type=submit name=conclusion value=skip class=button--skip>@lang('reviewing.skip')</button>
        </div>

        <div class=file>
            <div id=location-map style="width: 100%; height: 100px;"></div>
            <ul class=js-clicked-features></ul>
            <details>
                <summary>
                    {{$file->path}}
                </summary>
                <a href="{{$file->url}}" target=_blank>{{$file->path}}</a>
                @if ($linkedFile)
                    <br><a href="{{$linkedFile->url}}" target=_blank>
                        @if ($linkedFile->isSrc())
                            @lang('reviewing.versions.SRC')
                        @else
                            @lang('reviewing.versions.original')
                        @endif
                    </a>
                @endif
                @include('_exif')
            </details>
        </div>

        <aside>
            <div
                class=progress
                data-label="@lang('reviewing.progress.label', ['percentage' => $reviewedPercentage])"
                title="@lang('reviewing.progress.description', ['percentage' => $reviewedPercentage, 'total' => $reviewableCount])">
                <div class=value style="width:{{$reviewedPercentage}}%;"></div>
                <span class=min>0</span>
                <span class=max>{{$reviewableCount}}</span>
            </div>

            <div class=buttons>
                <button type=button class="js-show-infobox button--info">
                    @lang('menu.open infobox')
                </button>
                <a class="button button--info" href="{{route('reviewers.me')}}">
                    @lang('menu.reviewed images')
                </a>
            </div>
        </aside>
    </form>
</main>

@include('_infobox')

@vite(['resources/js/reviewer.js'])
<script type=module>
bootInfobox('.js-infobox', '.js-show-infobox', {{$seenInfobox ? 'false' : 'true'}})

@include('_displayimagejs', ['exif' => $exif, 'element' => 'image', 'file' => $file, 'intercative' => true])

const form = document.querySelector('form')
const coordinateInput = form.querySelector('[name=coordinates]')
form.addEventListener('submit', _ => coordinateInput.value = JSON.stringify(userMarkers.getMarkers()))

const featureContainer = document.querySelector('.js-clicked-features')
const clickFeatures = features => {
    featureContainer.replaceChildren()

    features.forEach(feature => {
        if (!feature.url || !feature.path)
            return

        const link = document.createElement('a')
        link.target = '_blank'
        link.href = feature.url
        link.innerText = feature.path

        const item = document.createElement('li')
        item.append(link)

        featureContainer.append(item)
    })
}

@include('_minimap', ['exif' => $exif, 'element' => 'location-map', 'file' => $file, 'listener' => 'clickFeatures'])
</script>
@endsection
