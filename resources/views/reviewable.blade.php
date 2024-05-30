@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviewables.review', $reviewable->path)}}">
            Atvērt pārskatīšanai
        </a>
        <li><a href="{{$reviewable->url}}">
            Atvērt attēlu
        </a>
    </ul>
</nav>

<img src="{{$reviewable->url}}">

@include('_reviews')
@endsection
