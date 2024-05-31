@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviewables.directory')}}">
            Katalogs
        </a>
        <li><a href="{{route('reviewables.index')}}">
            Visi faili
        </a>
    </ul>
</nav>

<ul>
@foreach ($directories as $dir)
    <li><a href="{{route('reviewables.index', ['filter' => $dir])}}">{{$dir}}</a>
@endforeach
</ul>
@endsection
