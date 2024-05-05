@extends('layout')

@section('content')
<img src="{{$file->url}}">

<form method=post action="{{route('reviews.store')}}">
    @csrf
    <input type=hidden name=filepath value="{{$file->path}}">

    <label>
        Ko aizdomīgu redzi?
        <textarea name=review></textarea>
    </label>

    <details>
        <summary>Bilde ir nekvalitatīva vai cita problēma?</summary>
        <textarea name=problem></textarea>
    </details>

    <button type=submit>Iesniegt</button>
</form>
@endsection
