@extends('layout')

@section('content')
<h1>Pārskatītājs {{$reviewer->reviewer_id}}</h1>

<table>
    <thead>
        <tr><th>Iesniegts <th>Info <th>Problēmas <th>Bilde
    <tbody>
        @foreach ($reviewer->reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewables.show', $review->reviewable->path)}}">
                    {{$review->file}}
                </a>
        @endforeach
</table>
@endsection
