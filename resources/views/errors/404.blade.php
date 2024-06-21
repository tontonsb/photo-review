@extends('layout')

@section('content')
<h3>404</h3>

{{$exception->getMessage()}}
@endsection
