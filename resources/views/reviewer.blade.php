@extends('layout')

@section('content')
<h1>Pārskatītājs {{$reviewer->reviewer_id}}</h1>

@include('_reviews', ['reviews' => $reviewer->reviews])
@endsection
