@use('App\Models\ReviewerToken')
@extends('layout')

@section('content')
<dl>
    <dt>@lang('reviews.reviewable')
    <dd><a href="{{route('reviewables.show', $review->file)}}">
            {{$review->file}}
        </a>

    <dt>@lang('reviews.reviewer')
    <dd><a href="{{route('reviewers.show', $review->reviewer_id)}}">
            {{$review->reviewer_id}}</a>

        @can('view-user-names')
            @if ($user = ReviewerToken::find($review->reviewer_id)?->user)
                ({{$user->name}})
            @endif
        @endcan

    <dt>@lang('reviews.submitted')
    <dd>{{$review->created_at}}

    <dt>@lang('reviews.conclusion')
    <dd>{{$review->conclusion?->title()}}

    <dt>@lang('reviews.description')
    <dd>{{$review->review}}

    <dt>@lang('reviews.problems')
    <dd>{{$review->problem}}

    <dt>@lang('reviews.duration')
    <dd>{{$review->duration}}

    <dt>@lang('reviews.status')
    <dd>{{$review->status?->title() ?? '❔ '.__('reviews.unreviewed')}}
</dl>

<h3>@lang('reviews.comments')</h3>
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
<p>@lang('reviews.no comments')
@endforelse

@can('comment')
<form method=post action="{{route('reviews.comment', $review)}}">
    @csrf
    <label>
        @lang('reviews.new status')
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
        @lang('reviews.comment')
        <textarea name=comment>{{old('comment')}}</textarea>
        @error('comment')
            <small>{{$message}}</small>
        @enderror
    </label>

    <button type=submit>@lang('reviews.add comment')</button>
</form>
@endcan

<p class=coords></p>
<div id=image style="width: 100%; height: 70lvh;"></div>


@if($exif['LOCATION'] ?? false)
<h2>@lang('reviewables.location')</h2>
<div id=location-map style="width: 100%; height: 70lvh;"></div>
@endif

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

@if($exif['LOCATION'] ?? false)
@include('_minimap', ['exif' => $exif, 'element' => 'location-map', 'file' => $file])
@endif
</script>
@endsection
