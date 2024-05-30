@extends('layout')

@section('content')
<h3>Pārskatītājs {{$reviewer->reviewer_id}}</h3>

@include('_reviews', ['reviews' => $reviewer->reviews])
@endsection
