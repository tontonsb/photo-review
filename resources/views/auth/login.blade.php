@extends('layout')

@section('content')
<form method=post action="{{route('login')}}">
    @csrf

    <label>
        Epasts
        <input type=email name=email value="{{old('email')}}" required autofocus autocomplete=username >
        @error('email')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Parole
        <input type=password name=password required autocomplete=current-password >
        @error('password')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        <input type=checkbox name=remember>
        Atcerēties mani
    </label>

    <button type=submit>Pieslēgties</button>

    @if (Route::has('password.request'))
        <a href="{{route('password.request')}}">
            Aizmirsi paroli?
        </a>
    @endif
</form>
@endsection
