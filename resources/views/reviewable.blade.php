@extends('layout')

@section('content')
<a href="{{route('reviewables.review', $reviewable->path)}}">
    Atvērt pārskatīšanai
</a>

<img src="{{$reviewable->url}}">

@include('_reviews')
@endsection
