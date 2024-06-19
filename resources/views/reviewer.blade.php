@extends('layout')

@section('content')
<h3>Pārskatītājs {{$reviewer->reviewer_id}}</h3>

@if ($reviewedCount > 25)
<p>Apskatījis {{$reviewCount}} bildes un pārskatījis (neizlaidis) {{$reviewedCount}} bildes, tam kopā veltot {{$timeSpent}}
@elseif ($reviewCount > 10)
<p>Apskatījis {{$reviewCount}} bildes.
@endif

@if(request()->routeIs('reviewers.me'))
<p>Vai pārskati bildes vairākās ierīcēs? Ja vēlies apvienot pārlūkotos datus vai vienkārši baidies pazaudēt savu progresu,
    @auth
        dodies uz <a href="{{route('me')}}">savu kontu</a>
    @else
        <a href="{{route('register')}}">izveido kontu</a>
    @endauth
    un piesaisti kontam savu pārskatīšanas progresu, izmantojot kodu
    <input
        type=text
        readonly
        value="{{App\Models\ReviewerToken::getOrRegister($reviewerService->getCurrentToken())->transfer_token}}"
    >
@endif

@include('_reviews', ['reviews' => $reviewer->reviews])
@endsection
