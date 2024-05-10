@extends('layout')

@section('content')
<table>
    <thead>
        <tr><th>Pārskatītājs <th>Pārskatījumi
    <tbody>
        @foreach ($reviewers as $reviewer)
        <tr>
            <td><a href="{{route('reviewers.show', $reviewer->reviewer_id)}}">
                    {{$reviewer->reviewer_id}}
                </a>
            <td>{{$reviewer->review_count}}
        @endforeach
</table>
@endsection
