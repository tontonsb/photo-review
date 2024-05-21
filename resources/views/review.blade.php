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
@endsection
