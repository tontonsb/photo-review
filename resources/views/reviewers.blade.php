@extends('layout')

@section('content')
<p>@lang('reviewers.current token'): <a href="{{route('reviewers.show', $currentToken)}}">{{$currentToken}}</a>

<table>
    <thead>
        <tr><th>@lang('reviewers.reviewer') <th>@lang('reviewers.reviews') <th>@lang('reviewers.with info') <th>@lang('reviewers.with feedback')
    <tbody>
        @foreach ($reviewers as $reviewer)
        <tr>
            <td><a href="{{route('reviewers.show', $reviewer)}}">
                    {{$reviewer->reviewer_id}}
                </a>
            <td>{{$reviewer->reviews_count}}
            <td>{{$reviewer->reviews_with_info_count}}
            <td>{{$reviewer->reviews_with_feedback_count}}
        @endforeach
</table>
@endsection
