@extends('layout')

@section('content')
<h1>Pārskatītājs {{$reviewerId}}</h1>

<table>
    <thead>
        <tr><th>Iesniegts <th>Info <th>Problēmas <th>Bilde
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{$review->reviewable->url}}">
                    {{$review->file}}
                </a>
        @endforeach
</table>
@endsection
