@use('Facades\App\Services\ReviewerService')

@extends('base-layout')


@section('head')
@vite(['resources/css/internal.css'])
@endsection

@section('body')
<nav>
    <ul>
        <li><a href="{{route('reviews.index')}}">Pārskatījumi</a>
        <li><a href="{{route('reviewables.index')}}">Bildes</a>
        <li><a href="{{route('reviewers.index')}}">Pārskatītāji</a>
        <li><a href="{{route('reviewers.show', ReviewerService::getCurrentToken())}}">Tavi pārskatījumi</a>
        <li><a href="{{route('reviewables.random')}}">Turpināt pārskatīšanu</a>
    </ul>
</nav>

@yield('content')

@endsection
