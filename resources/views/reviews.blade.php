@extends('layout')

@section('content')
<a href="{{route('reviews.index')}}">Visas</a>
<a href="{{route('reviews.index', 'reviews')}}">Ar aprakstiem</a>
<a href="{{route('reviews.index', 'problems')}}">Ar problēmām</a>

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
{{$reviews->links()}}
@endsection
