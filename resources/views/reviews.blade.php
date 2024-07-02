@extends('layout')

@section('content')
<style>
    form {
        display: grid;
        grid-template-columns: max-content max-content max-content max-content;
        width: auto;
        gap: var(--space-base);
        align-items: start;
    }

    select[multiple] {
        height: 8rem;
    }
</style>

<form>
    <label>
        <h5>@lang('reviews.filter.title')</h5>
        <select name=filter>
            <option value="" @selected(!request()->filter)>@lang('reviews.filter.all')
            <option value=reviews @selected('reviews' == request()->filter)>@lang('reviews.filter.reviews')
            <option value=problems @selected('problems' == request()->filter)>@lang('reviews.filter.problems')
            <option value=pins @selected('pins' == request()->filter)>@lang('reviews.filter.pins')
            <option value=any @selected('any' == request()->filter)>@lang('reviews.filter.any')
            <option value=info @selected('info' == request()->filter)>@lang('reviews.filter.info')
        </select>
    </label>

    <div>
        <h5>@lang('reviews.conclusion')</h5>
        @foreach (App\Models\Conclusion::cases() as $conclusion)
        <label>
            <input
                type=checkbox
                name=conclusions[]
                value={{$conclusion->value}}
                @checked(in_array($conclusion->value, request()->conclusions ?? []))
                >{{$conclusion->title()}}
        </label>
        @endforeach
    </div>

    <div>
        <h5>@lang('reviews.status')</h5>
        <label>
            <input
                type=checkbox
                name=statuses[]
                value=no_status
                @checked(in_array('no_status', request()->statuses ?? []))
                >@lang('reviews.no status')
        </label>
        @foreach (App\Models\Status::cases() as $status)
        <label>
            <input
                type=checkbox
                name=statuses[]
                value={{$status->value}}
                @checked(in_array($status->value, request()->statuses ?? []))
                >{{$status->title()}}
        </label>
        @endforeach
    </div>

    <button type=submit>
        @lang('reviews.select')
    </button>
</form>

@include('_reviews')
{{$reviews->links()}}
<p>@lang('reviews.matches', ['count' => $count])
<a href="{{route('reviews.map').'?'.request()->getQueryString()}}">@lang('reviews.map')</a>
@endsection
