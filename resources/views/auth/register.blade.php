@extends('layout')

@section('content')
<form method=post action="{{route('register')}}">
    @csrf

    <label>
        @lang('auth.name')
        <input name=name value="{{old('name')}}" required autofocus autocomplete=name>
        @error('name')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        @lang('auth.email')
        <input type=email name=email value="{{old('email')}}" required autocomplete=username >
        @error('email')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        @lang('auth.password')
        <input type=password name=password required autocomplete=new-password >
        @error('password')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        @lang('auth.password confirmation')
        <input type=password name=password_confirmation required autocomplete=new-password >
        @error('password_confirmation')
            <small>{{$message}}</small>
        @enderror
    </label>

    <button type=submit>@lang('auth.register')</button>
</form>

<article>
    {!! Str::markdown(trans('auth.registration description')) !!}
</article>
@endsection
