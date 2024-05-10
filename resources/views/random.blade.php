@extends('base-layout')

@section('head')
<link rel=stylesheet href=https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.css>
<style>
.zoomist-image img {
    height: 100%;
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
            <summary>{{$file->path}}</summary>
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

        <button type=submit name=conclusion value=skip class=button--skip>Izlaist šo bildi</button>
    </form>
</main>

<script type=module>
import Zoomist from 'https://cdn.jsdelivr.net/npm/zoomist@2/zoomist.js'

const zoomist = new Zoomist('.zoomist-container', {
    zoomer: true,
    slider: true,
})

const timeStarted = new Date()
const form = document.querySelector('form')
const timeInput = document.querySelector('[name=reviewing_duration_ms]')
form.addEventListener('submit', () => timeInput.value = (new Date()) - timeStarted)
</script>
@endsection
