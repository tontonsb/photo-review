@extends('layout')

@section('content')
<dl>
    <dt>Bilde
    <dd><a href="{{route('reviewables.show', $review->file)}}">
            {{$review->file}}
        </a>

    <dt>Pārskatītājs
    <dd><a href="{{route('reviewers.show', $review->reviewer_id)}}">
            {{$review->reviewer_id}}
        </a>

    <dt>Laiks
    <dd>{{$review->created_at}}

    <dt>Slēdziens
    <dd>{{$review->conclusion?->lv()}}

    <dt>Info
    <dd>{{$review->review}}

    <dt>Problēmas
    <dd>{{$review->problem}}

    <dt>Pārskatīšanas ilgums
    <dd>{{$review->duration}}
</dl>

<div id=image style="width: 100%; height: 70lvh;"></div>
@vite(['resources/js/review.js'])
<script type=module>
@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageOnMap('image', @json($exif['LOCATION']), '{{$file->url}}')
@else
    const {map, userMarkers} = displayImage('image', {{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}, '{{$file->url}}')
@endif

@if ($review->coordinates)
userMarkers.addMarkers(@json($review->coordinates))
@endif
</script>
@endsection
