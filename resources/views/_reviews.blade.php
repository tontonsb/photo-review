<table>
    <thead>
        <tr><th>Iesniegts (UTC) <th colspan=2>Slēdziens <th>Saturs <th>Statuss <th>Bilde <th>Ilgums <th>Pārskatītājs
    <tbody>
        @foreach ($reviews as $review)
        <tr>
            <td>
                    {{$review->created_at}}
                </a>
            <td>{{$review->conclusion?->title()}}
            <td>
                <a href="{{route('reviews.show', $review)}}">
                    🔍 Apskatīt
                </a>
            <td>
                @if ($review->problem)
                    <span title="{{$review->problem}}">⚠️</span>
                @endif

                @if ($review->coordinates)
                    <span title="Ir pievienoti marķieri">📌</span>
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
