@use('App\Models\ReviewerToken')
@extends('layout')

@section('content')
<dl>
    <dt>Bilde
    <dd><a href="{{route('reviewables.show', $review->file)}}">
            {{$review->file}}
        </a>

    <dt>Pārskatītājs
    <dd><a href="{{route('reviewers.show', $review->reviewer_id)}}">
            {{$review->reviewer_id}}</a>

        @can('view-user-names')
            @if ($user = ReviewerToken::find($review->reviewer_id)?->user)
                ({{$user->name}})
            @endif
        @endcan

    <dt>Laiks
    <dd>{{$review->created_at}}

    <dt>Slēdziens
    <dd>{{$review->conclusion?->title()}}

    <dt>Info
    <dd>{{$review->review}}

    <dt>Problēmas
    <dd>{{$review->problem}}

    <dt>Pārskatīšanas ilgums
    <dd>{{$review->duration}}

    <dt>Statuss
    <dd>{{$review->status?->title() ?? '❔ Nepārskatīts'}}
</dl>

<h3>Komentāri</h3>
@forelse($review->comments as $comment)
<article>
    <header>
        <h4>
            @can('view-comment-authors')
                {{$comment->user->name}}
            @endcan
            {{$comment->status?->title()}}
        </h4>
    </header>

    {!! Str::markdown($comment->comment, [
        'html_input' => 'strip',
        'allow_unsafe_links' => false,
    ]) !!}

    <footer>
        <p>{{$comment->created_at}}
    </footer>
</article>
@empty
<p>Komentāru pagaidām nav
@endforelse

@can('comment')
<form method=post action="{{route('reviews.comment', $review)}}">
    @csrf
    <label>
        Jaunais statusss
        <select name=status required>
            <option>
            @foreach (App\Models\Status::cases() as $status)
            <option value="{{$status->value}}" @selected($status->value === old('status', $review->status?->value))>{{$status->title()}}
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

    <button type=submit>Uzstādīt statusu un pievienot komentāru</button>
</form>
@endcan

<p class=coords></p>
<div id=image style="width: 100%; height: 70lvh;"></div>

@vite(['resources/js/review.js'])
<script type=module>
{{-- won't extract this to _displayimagejs because of custom handling for legacy reviews that's only needed on this view --}}
@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageOnMap('image', @json($exif['LOCATION']), '{{$file->url}}', @json(trans('map')), false)
@elseif (($exif['EXTENT'] ?? false) && ($exif['LOCATION'] ?? false) && $review->created_at > '2024-06-02')
    const {map, userMarkers} = displayImageWithScale(
        'image',
        [{{$exif['LOCATION']['lon'] ?? 0}}, {{$exif['LOCATION']['lat'] ?? 0}}],
        {{$exif['YAW'] ?? 0}},
        [{{$exif['EXTENT']['width'] ?? 0}}, {{$exif['EXTENT']['height'] ?? 0}}],
        '{{$file->url}}',
        @json(trans('map')),
        false,
        @if($review->created_at < '2024-06-06 18:29:00') true, @endif
    )
@else
    const {map, userMarkers} = displayImage(
        'image',
        [{{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}],
        '{{$file->url}}',
        @json(trans('map')),
        false,
    )
@endif

const coords = document.querySelector('p.coords')
map.on('gotcoords', e => coords.innerHTML = e.payload)

@if ($review->coordinates)
userMarkers.addMarkers(@json($review->coordinates))
@endif
</script>
@endsection
