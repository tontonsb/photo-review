@extends('base-layout')

@section('body')
<main>
    <a href="{{$file->url}}" target="_blank">
        <img src="{{$file->url}}">
    </a>

    <form method=post action="{{route('reviews.store')}}">
        @csrf
        <input type=hidden name=filepath value="{{$file->path}}">
        <input type=hidden name=reviewing_duration_ms value=0>

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

<script>
const timeStarted = new Date()

const form = document.querySelector('form')
const timeInput = document.querySelector('[name=reviewing_duration_ms]')

form.addEventListener('submit', () => timeInput.value = (new Date()) - timeStarted)
</script>
@endsection
