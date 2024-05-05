@extends('layout')

@section('content')
<img src="{{$reviewable->url}}">

<table>
    <thead>
        <tr><th>Iesniegts <th>Info <th>Problēmas
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
        @endforeach
</table>
@endsection
