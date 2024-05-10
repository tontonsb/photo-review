@extends('layout')

@section('content')
Tavs pārskatītāja žetons: {{$currentToken}}

<table>
    <thead>
        <tr><th>Pārskatītājs <th>Pārskatījumi
    <tbody>
        @foreach ($reviewers as $reviewer)
        <tr>
            <td><a href="{{route('reviewers.show', $reviewer)}}">
                    {{$reviewer->reviewer_id}}
                </a>
            <td>{{$reviewer->review_count}}
        @endforeach
</table>
@endsection
