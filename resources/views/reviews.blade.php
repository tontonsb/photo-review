@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviews.index')}}">Visas</a>
        <li><a href="{{route('reviews.index', 'reviews')}}">Ar aprakstiem</a>
        <li><a href="{{route('reviews.index', 'problems')}}">Ar problēmām</a>
    </ul>
</nav>

<table>
    <thead>
        <tr><th>Iesniegts <th>Slēdziens <th>Info <th>Problēmas <th>Bilde <th>Ilgums <th>Pārskatītājs
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->conclusion?->lv()}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewables.show', $review->reviewable->path)}}">
                    {{$review->file}}
                </a>
            <td>{{number_format($review->reviewing_duration_ms / 1000, 1)}} s
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
{{$reviews->links()}}
@endsection
