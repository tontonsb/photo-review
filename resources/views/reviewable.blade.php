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

<h2>Pārskatījumi</h2>
@include('_reviews')

<div id=image style="width: 100%; height: 70lvh;"></div>

<h2>Metadati</h2>
@include('_exif', ['exif' => $reviewable->getData()])

@vite(['resources/js/review.js'])
<script type=module>
@include('_displayimagejs', ['exif' => $reviewable->getData(), 'element' => 'image', 'file' => $reviewable, 'intercative' => false])
</script>
@endsection
