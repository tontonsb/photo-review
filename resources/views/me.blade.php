@extends('layout')

@section('head')
<style>
article ul {
    padding-inline-start: var(--space-lg);
}
</style>

@section('content')
@if ($reviewerIdentities->count())
<article>
    <h3>@lang('account.stats.title')</h3>
    <ul>
        <li>@lang('account.stats.viewed', ['count' => $reviewCount])
        <li>@lang('account.stats.reviewed', ['count' => $reviewedCount])
        <li>@lang('account.stats.time', ['time' => $timeSpent])
    </ul>
</article>
@endif

<article>
    <form method=post action="{{route('bind-reviewer')}}" >
        @csrf
        <h3>@lang('account.link.title')</h3>

        @session('status')
        <article>
            <p>{{$value}}
        </article>
        @endsession

        <label>
            @lang('account.link.code')
            <input required type=text name=code>
        </label>

        <button>@lang('account.link.store')</button>
    </form>
</article>

@if ($reviewerIdentities->count())
    <h3>@lang('account.tokens')</h3>

    <table>
        <thead>
            <tr><th>@lang('reviewers.reviewer') <th>@lang('reviewers.reviews') <th>@lang('reviewers.with info') <th>@lang('reviewers.with feedback')
        <tbody>
            @foreach ($reviewerIdentities as $identity)
            <tr>
                <td><a href="{{route('reviewers.show', $identity)}}">
                        {{$identity->reviewer_id}}
                    </a>
                <td>{{$identity->reviews_count}}
                <td>{{$identity->reviews_with_info_count}}
                <td>{{$identity->reviews_with_feedback_count}}
            @endforeach
    </table>

    <hr>

    <h3>@lang('account.reviews')</h3>
    @include('_reviews')
@endif

@endsection
