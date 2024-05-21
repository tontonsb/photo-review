@extends('layout')

@section('content')
<h1>Pārskatītājs {{$reviewer->reviewer_id}}</h1>

<table>
    <thead>
        <tr><th>Iesniegts <th>Slēdziens <th>Info <th>Problēmas <th>Bilde <th>Ilgums
    <tbody>
        @foreach ($reviewer->reviews as $review)
        <tr>
            <td><a href="{{route('reviews.show', $review)}}">
                    {{$review->created_at}}
                </a>
            <td>{{$review->conclusion?->lv()}}
            <td>
                {{$review->coordinates ? '📌' : ''}}
                {{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewables.show', $review->file)}}">
                    {{$review->file}}
                </a>
            <td>{{$review->duration}}
        @endforeach
</table>
@endsection
