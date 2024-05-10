@extends('layout')

@section('content')
<a href="{{route('reviews.index')}}">Visas</a>
<a href="{{route('reviews.index', 'reviews')}}">Ar aprakstiem</a>
<a href="{{route('reviews.index', 'problems')}}">Ar problēmām</a>

<table>
    <thead>
        <tr><th>Iesniegts <th>Info <th>Problēmas <th>Bilde <th>Pārskatītājs
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewables.show', $review->reviewable->path)}}">
                    {{$review->file}}
                </a>
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
{{$reviews->links()}}
@endsection
