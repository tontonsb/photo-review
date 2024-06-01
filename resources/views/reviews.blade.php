@extends('layout')

@section('content')
<style>
    form {
        display: grid;
        grid-template-columns: max-content max-content max-content;
        width: auto;
        gap: var(--space-base);
        align-items: center;
    }

    select[multiple] {
        height: 8rem;
    }
</style>

<form>
    <label>
        Filtrs
        <select name=filter>
            <option value="" @selected(!request()->filter)>Visas
            <option value=info @selected('info' == request()->filter)>Aizdomīgas vai ar saturu
            <option value=suspect @selected('suspect' == request()->filter)>Aizdomīgas UN ar saturu
            <option value=reviews @selected('reviews' == request()->filter)>Ar aprakstiem
            <option value=problems @selected('problems' == request()->filter)>Ar problēmām
            <option value=pins @selected('pins' == request()->filter)>Ar marķieriem
        </select>
    </label>

    <div>
        Statuss
            <label>
                <input type=checkbox name=statuses[] value="no_status" @checked(in_array(null, request()->statuses ?? []))>
                bez statusa
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
        </select>
    </div>

    <button type=submit>
        Atlasīt
    </button>
</form>

@include('_reviews')
{{$reviews->links()}}
@endsection
