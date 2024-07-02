<table>
    <thead>
        <tr><th>@lang('reviews.submitted') <th colspan=2>@lang('reviews.conclusion') <th>@lang('reviews.contents') <th>@lang('reviews.status') <th>@lang('reviews.reviewable') <th>@lang('reviews.duration') <th>@lang('reviews.reviewer')
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>
                    {{$review->created_at}}
                </a>
            <td>{{$review->conclusion?->title()}}
            <td>
                <a href="{{route('reviews.show', $review)}}">
                    🔍 @lang('reviews.view')
                </a>
            <td>
                @if ($review->problem)
                    <span title="{{$review->problem}}">⚠️</span>
                @endif

                @if ($review->coordinates)
                    <span title="@lang('reviews.with markers')">📌</span>
                @endif

                @if ($review->review)
                    <span title="{{$review->review}}">💬 {{Str::limit($review->review, 20)}}</span>
                @endif

            <td>{{$review->status?->title()}}

            <td><a href="{{route('reviewables.show', $review->file)}}">
                    {{$review->file}}
                </a>
            <td>{{$review->duration}}
            <td><a href="{{route('reviewers.show', $review->reviewer_id)}}">
                    {{$review->reviewer_id}}
                </a>
        @endforeach
</table>
