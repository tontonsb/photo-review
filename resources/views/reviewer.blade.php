@extends('layout')

@section('content')
<h3>Pārskatītājs {{$reviewer->reviewer_id}}</h3>

@if ($reviewedCount > 25)
<p>Apskatījis {{$reviewCount}} bildes un pārskatījis (neizlaidis) {{$reviewedCount}} bildes, tam kopā veltot {{$timeSpent}}
@elseif ($reviewCount > 10)
<p>Apskatījis {{$reviewCount}} bildes.
@endif

@include('_reviews', ['reviews' => $reviewer->reviews])
@endsection
