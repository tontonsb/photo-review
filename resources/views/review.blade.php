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

    <dt>Statuss
    <dd>{{$review->status->lv() ?? '❔ Nepārskatīts'}}
</dl>

<h3>Komentāri</h3>
@foreach($review->comments as $comment)
<article>
    <header>
        <h4>
            @can('view-comment-authors')
                {{$comment->user->name}}
            @endcan
            {{$comment->status?->lv()}}
        </h4>
    </header>
    <p>{{$comment->comment}}
    <footer>
        <p>{{$comment->created_at}}
    </footer>
</article>
@endforeach

@can('comment')
<form method=post action="{{route('reviews.comment', $review)}}">
    @csrf
    <label>
        Statuss
        <select name=status required>
            <option>
            @foreach (App\Models\Status::cases() as $status)
            <option value="{{$status->value}}" @selected($status->value === old('status', $review->status?->value))>{{$status->lv()}}
            @endforeach
        </select>
        @error('status')
            <p><small>{{$message}}</small>
        @enderror
    </label>

    <label>
        Komentārs
        <textarea name=comment>{{old('comment')}}</textarea>
        @error('comment')
            <small>{{$message}}</small>
        @enderror
    </label>

    <button type=submit>Pievienot</button>
</form>
@endcan

<div id=image style="width: 100%; height: 70lvh;"></div>

@vite(['resources/js/review.js'])
<script type=module>
@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageOnMap('image', @json($exif['LOCATION']), '{{$file->url}}', false)
@else
    const {map, userMarkers} = displayImage('image', {{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}, '{{$file->url}}', false)
@endif

@if ($review->coordinates)
userMarkers.addMarkers(@json($review->coordinates))
@endif
</script>
@endsection
