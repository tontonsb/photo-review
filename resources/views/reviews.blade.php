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
        <h5>Satura filtrs</h5>
        <select name=filter>
            <option value="" @selected(!request()->filter)>Visas
            <option value=reviews @selected('reviews' == request()->filter)>Ar aprakstiem
            <option value=problems @selected('problems' == request()->filter)>Ar problēmām
            <option value=pins @selected('pins' == request()->filter)>Ar marķieriem
            <option value=any @selected('any' == request()->filter)>Jebkāds saturs
            <option value=info @selected('info' == request()->filter)>Jebkāds saturs + visas aizdomīgās
        </select>
    </label>

    <div>
        <h5>Slēdziens</h5>
        @foreach (App\Models\Conclusion::cases() as $conclusion)
        <label>
            <input
                type=checkbox
                name=conclusions[]
                value={{$conclusion->value}}
                @checked(in_array($conclusion->value, request()->conclusions ?? []))
                >{{$conclusion->lv()}}
        </label>
        @endforeach
    </div>

    <div>
        <h5>Statuss</h5>
        <label>
            <input
                type=checkbox
                name=statuses[]
                value=no_status
                @checked(in_array('no_status', request()->statuses ?? []))
                >bez statusa
        </label>
        @foreach (App\Models\Status::cases() as $status)
        <label>
            <input
                type=checkbox
                name=statuses[]
                value={{$status->value}}
                @checked(in_array($status->value, request()->statuses ?? []))
                >{{$status->lv()}}
        </label>
        @endforeach
    </div>

    <button type=submit>
        Atlasīt
    </button>
</form>

@include('_reviews')
{{$reviews->links()}}
<p>Izvēlētajam filtram pavisam atbilst {{$count}} ieraksti.
<a href="{{route('reviews.map').'?'.request()->getQueryString()}}">Atvērt visus kartē.</a>
@endsection
