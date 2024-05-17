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
            <td>{{$review->created_at}}
            <td>{{$review->conclusion?->lv()}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td>{{number_format($review->reviewing_duration_ms / 1000, 1)}} s
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
@endsection
