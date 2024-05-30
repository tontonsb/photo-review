@extends('layout')

@section('content')
<form method=post action="{{route('register')}}">
    @csrf

    <label>
        Vārds
        <input name=name value="{{old('name')}}" required autofocus autocomplete=name>
        @error('name')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Epasts
        <input type=email name=email value="{{old('email')}}" required autocomplete=username >
        @error('email')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Parole
        <input type=password name=password required autocomplete=new-password >
        @error('password')
            <small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Parole vēlreiz
        <input type=password name=password_confirmation required autocomplete=new-password >
        @error('password_confirmation')
            <small>{{$message}}</small>
        @enderror
    </label>

    <button type=submit>Reģistrēties</button>
</form>
@endsection
