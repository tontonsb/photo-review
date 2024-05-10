@extends('base-layout')

@section('head')
<link rel=stylesheet href=https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.css>
<style>
.zoomist-image img {
    height: 100%;
}

.zoomist-container {
    --zoomist-slider-bg-color: rgba(255, 255, 255, .3);
    --zoomist-slider-padding-x: 10px;
    --zoomist-slider-padding-y: 14px;
    --zoomist-slider-bar-size: 100px;

    --zoomist-zoomer-button-size: 40px;
    --zoomist-zoomer-button-color: rgba(255, 255, 255, .6);
    --zoomist-zoomer-button-color-hover: rgba(255, 255, 255, .9);
    --zoomist-zoomer-button-color-disabled: rgba(255, 255, 255, .3);
}
</style>
@endsection

@section('body')
<main>
    <div class=zoomist-container>
        <div class=zoomist-wrapper>
            <div class=zoomist-image>
                <img src="{{$file->url}}" {!! $exif['COMPUTED']['html'] ?? '' !!} >
            </div>
        </div>
    </div>

    <form method=post action="{{route('reviews.store')}}">
        @csrf
        <input type=hidden name=filepath value="{{$file->path}}">
        <input type=hidden name=reviewing_duration_ms value=0>

        <details class="file">
            <summary>
                {{$file->path}}
            </summary>
            <a href="{{$file->url}}" target=_blank>{{$file->path}}</a>
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

        <button type=submit name=conclusion value=ok class=button--ok>Apskatīju, nav nekā ievērības cienīga</button>

        <div>
            <details open>
                <summary>Redzi ko aizdomīgu?</summary>
                <textarea name=review></textarea>
            </details>

            <details>
                <summary>Bilde ir nekvalitatīva vai cita problēma?</summary>
                <textarea name=problem></textarea>
            </details>

            <button type=submit name=conclusion value=suspect class=button--suspect>Iesniegt</button>
        </div>

        <div class=footer>
            @if ($reviewedByCurrentUser > 5)
                <span class=review-stats title="Pārskatītas jau {{$reviewedByCurrentUser}} no {{$reviewableCount}} bildēm">
                    {{$reviewedByCurrentUser}}/{{$reviewableCount}}
                </span>
            @endif

            <button type=submit name=conclusion value=skip class=button--skip>Izlaist šo bildi</button>
        </div>
    </form>
</main>

<script type=module>
import Zoomist from 'https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.js'

const zoomistOverlay = document.querySelector('.zoomist-wrapper')
const zoomist = new Zoomist('.zoomist-container', {
    zoomer: true,
    slider: true,
    zoomRatio: 0.28,
    on: {
        zoom(zoomist, scale) {
            if (1 == scale)
                zoomistOverlay.style.cursor = 'unset'
            else
                zoomistOverlay.style.cursor = 'grab'
        },
    },
})

zoomistOverlay.addEventListener('mousedown', () => {
    if (zoomist.transform.scale == 1)
        return

    zoomistOverlay.style.cursor = 'grabbing'
})

zoomistOverlay.addEventListener('mouseup', () => {
    if (zoomist.transform.scale == 1)
        return

    zoomistOverlay.style.cursor = 'grab'
})

const timeStarted = new Date()
const form = document.querySelector('form')
const timeInput = document.querySelector('[name=reviewing_duration_ms]')
form.addEventListener('submit', () => timeInput.value = (new Date()) - timeStarted)
</script>
@endsection
