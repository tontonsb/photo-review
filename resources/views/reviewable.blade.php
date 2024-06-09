@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviewables.review', $reviewable->path)}}">
            Atvērt pārskatīšanas skatā
        </a>
        <li><a href="{{$reviewable->url}}">
            Atvērt tikai attēlu
        </a>
    </ul>
</nav>

<img src="{{$reviewable->url}}">

<h2>Pārskatījumi</h2>
@include('_reviews')

<h2>Metadati</h2>
@include('_exif', ['exif' => $reviewable->getData()])
@endsection
