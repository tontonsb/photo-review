@extends('layout')

@section('content')
<a href="{{$file->url}}" target="_blank">
    <img src="{{$file->url}}">
</a>

<form method=post action="{{route('reviews.store')}}">
    @csrf
    <input type=hidden name=filepath value="{{$file->path}}">

    <label>
        <div>Ko aizdomīgu redzi?</div>
        <textarea name=review></textarea>
    </label>

    <details>
        <summary>Bilde ir nekvalitatīva vai cita problēma?</summary>
        <textarea name=problem></textarea>
    </details>

    <button type=submit>Iesniegt</button>
</form>
@endsection
