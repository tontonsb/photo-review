@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviews.index')}}">Visas</a>
        <li><a href="{{route('reviews.index', ['filter' => 'info'])}}">Aizdomīgi vai ar informāciju</a>
    </ul>
</nav>

@include('_reviews')
{{$reviews->links()}}
@endsection
