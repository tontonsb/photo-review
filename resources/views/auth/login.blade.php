@extends('layout')

@section('content')
<form method=post action="{{route('login')}}">
    @csrf

    <label>
        @lang('auth.email')
        <input type=email name=email value="{{old('email')}}" required autofocus autocomplete=username >
        @error('email')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        @lang('auth.password')
        <input type=password name=password required autocomplete=current-password >
        @error('password')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        <input type=checkbox name=remember>
        @lang('auth.remember')
    </label>

    <button type=submit>@lang('auth.login')</button>

    @if (Route::has('password.request'))
        <a href="{{route('password.request')}}">
            @lang('auth.forgot')
        </a>
    @endif
</form>
@endsection
