@extends('layout')

@section('content')
<h1>Pārskatītājs {{$reviewer->reviewer_id}}</h1>

<table>
    <thead>
        <tr><th>Iesniegts <th>Slēdziens <th>Info <th>Problēmas <th>Bilde <th>Ilgums
    <tbody>
        @foreach ($reviewer->reviews as $review)
        <tr>
            <td>{{$review->created_at}}
            <td>{{$review->conclusion?->lv()}}
            <td>{{$review->review}}
            <td>{{$review->problem}}
            <td><a href="{{route('reviewables.show', $review->file)}}">
                    {{$review->file}}
                </a>
            <td>{{number_format($review->reviewing_duration_ms / 1000, 1)}} s
        @endforeach
</table>
@endsection
