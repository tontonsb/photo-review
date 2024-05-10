@extends('layout')

@section('content')
<img src="{{$reviewable->url}}">

<table>
    <thead>
        <tr><th>Iesniegts <th>Info <th>Problēmas <th>Pārskatītājs
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
@endsection
