@extends('layout')

@section('content')
<table>
    <thead>
        <tr><th>Bilde <th>Apskatījumi
    <tbody>
        @foreach ($reviewables as $reviewable)
        <tr>
            <td><a href="{{$reviewable->url}}">
                    {{$reviewable->path}}
                </a>
            <td><a href="{{route('reviewables.show', $reviewable->path)}}">
                    {{$reviewCounts[$reviewable->path] ?? 0}}
                </a>
        @endforeach
</table>
@endsection
