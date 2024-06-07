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
            <button type=submit name=conclusion value=ok class=button--ok>Apskatīju, nav nekā ievērības cienīga</button>

            <details open>
                <summary>Redzi ko aizdomīgu?</summary>
                <textarea name=review placeholder="Apraksti šeit un atzīmē attēlā"></textarea>
            </details>

            <details>
                <summary>Ziņot par sliktu/nekvalitatīvu bildi</summary>
                <textarea name=problem></textarea>
            </details>

            <button type=submit name=conclusion value=suspect class=button--suspect>Iesniegt</button>

            <label>
                Turpināsim ar
                <select name=mode class=continue >
                    <option value=random @selected(Route::is('reviewables.random'))>nejaušu
                    <option value=next @selected(Route::is('reviewables.review'))>nākošo
                </select>
                bildi
            </label>

            <button type=submit name=conclusion value=skip class=button--skip>Izlaist šo bildi</button>
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
                            Attēla versija ar ģeometrijas korekciju
                        @else
                            Oriģinālo datu attēls (bez korekcijas)
                        @endif
                    </a>
                @endif
                <code>
                    @foreach ($exif as $key => $value)
                        @if (is_scalar($value) || is_null($value))
                            {{$key}}: {{$value}}
                        @elseif (is_array($value))
                            @foreach ($value as $subkey => $subvalue)
                                {{$key}} {{$subkey}}: {{is_string($subvalue) ? $subvalue : json_encode($subvalue)}}
                            @endforeach
                        @endif
                    @endforeach
                </code>
            </details>
        </div>

        <aside>
            <div class=progress data-label="{{$reviewed_percentage}}% pārskatīti" title="Kopā esam pārskatījuši {{$reviewed_percentage}}% no šobrīd ielādētajām vairāk nekā {{$reviewable_count}} bildēm!">
                <div class=value style="width:{{$reviewed_percentage}}%;"></div>
                <span class=min>0</span>
                <span class=max>{{$reviewable_count}}</span>
            </div>

            <div class=buttons>
                <button type=button class="js-show-infobox button--info">
                    Atvērt pamācību
                </button>
                <a class="button button--info" href="{{route('reviewers.me')}}">
                    Mani pārskatījumi
                </a>
            </div>
        </aside>
    </form>
</main>

@include('_infobox')

@vite(['resources/js/reviewer.js'])
<script type=module>
bootInfobox('.js-infobox', '.js-show-infobox', {{$seenInfobox ? 'false' : 'true'}})

@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageOnMap('image', @json($exif['LOCATION']), '{{$file->url}}', true)
@elseif (($exif['EXTENT'] ?? false) && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageWithScale(
        'image',
        [{{$exif['LOCATION']['lon'] ?? 0}}, {{$exif['LOCATION']['lat'] ?? 0}}],
        [{{$exif['EXTENT']['width'] ?? 0}}, {{$exif['EXTENT']['height'] ?? 0}}],
        '{{$file->url}}',
        true,
    )
@else
    const {map, userMarkers} = displayImage(
        'image',
        [{{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}],
        '{{$file->url}}',
        true,
    )
@endif

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

@if ($exif['LOCATION'] ?? false)
    @if ($file->isSonarImage())
        makeMapWith.box(
            'location-map',
            @json($exif['LOCATION']),
            '{{route('reviewables.geojson')}}',
            clickFeatures,
        )
    @else
        makeMapWith.pin(
            'location-map',
            @json($exif['LOCATION']),
            {{deg2rad($exif['YAW'] ?? 0)}},
            '{{asset('icons/drone_marker.svg')}}',
            '{{route('reviewables.geojson')}}',
            clickFeatures,
        )
    @endif
@endif
</script>
@endsection
