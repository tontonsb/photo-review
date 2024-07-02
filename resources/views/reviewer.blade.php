@extends('layout')

@section('content')
<h3>@lang('reviewers.reviewer') {{$reviewer->reviewer_id}}</h3>

@if ($reviewedCount > 25)
<p>@lang('reviewers.fullstats', ['reviews' => $reviewCount, 'reviewed' => $reviewedCount, 'time' => $timeSpent])
@elseif ($reviewCount > 10)
<p>@lang('reviewers.shortstats', ['reviews' => $reviewCount])
@endif

@if(request()->routeIs('reviewers.me'))
    @if($reviewerToken->user_id === auth()->id())
        <p>{!! __('reviewers.linked to your acc', ['href' => route('me')]) !!}
    @elseif(!$reviewerToken->user_id)
        <p>@lang('reviewers.linking offer')
            @auth
                {!! __('reviewers.go to acc', ['href' => route('me')]) !!}
            @else
                {!! __('reviewers.create acc', ['href' => route('register')]) !!}
            @endauth
            @lang('reviewers.use code')
            <input
                type=text
                readonly
                value="{{$reviewerToken->transfer_token}}"
            >
    @endif
@endif

@include('_reviews', ['reviews' => $reviewer->reviews])
@endsection
