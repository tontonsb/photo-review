@extends('layout')

@section('content')
<a href="{{route('reviewables.review', $reviewable->path)}}">
    Atvērt pārskatīšanai
</a>

<img src="{{$reviewable->url}}">

<table>
    <thead>
        <tr><th>Iesniegts <th>Slēdziens <th>Info <th>Problēmas <th>Ilgums <th>Pārskatītājs
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td><a href="{{route('reviews.show', $review)}}">
                    {{$review->created_at}}
                </a>
            <td>{{$review->conclusion?->lv()}}
            <td>
                {{$review->coordinates ? '📌' : ''}}
                {{$review->review}}
            <td>{{$review->problem}}
            <td>{{$review->duration}}
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
@endsection
