@extends('layout')

@section('content')
<p>Tavs pārskatītāja žetons: <a href="{{route('reviewers.show', $currentToken)}}">{{$currentToken}}</a>

<table>
    <thead>
        <tr><th>Pārskatītājs <th>Pārskatījumi <th>Pārskatījumi ar info <th>Pārskatījumi ar atsauksmi
    <tbody>
        @foreach ($reviewers as $reviewer)
        <tr>
            <td><a href="{{route('reviewers.show', $reviewer)}}">
                    {{$reviewer->reviewer_id}}
                </a>
            <td>{{$reviewer->reviews_count}}
            <td>{{$reviewer->reviews_with_info_count}}
            <td>{{$reviewer->reviews_with_comments_count}}
        @endforeach
</table>
@endsection
