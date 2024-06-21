@extends('layout')

@section('head')
<style>
article ul {
    padding-inline-start: var(--space-lg);
}
</style>

@section('content')
@if ($reviewerIdentities->count())
<article>
    <h3>Tava statistika</h3>
    <ul>
        <li>Apskatītas {{$reviewCount}} bildes
        <li>Pārskatītas (neizlaistas) {{$reviewedCount}} bildes
        <li>Veltītas {{$timeSpent}}
    </ul>
</article>
@endif

<article>
    <form method=post action="{{route('bind-reviewer')}}" >
        @csrf
        <h3>Piesaistīt lietotāja kontam pārskatīšanas progresu</h3>

        @session('status')
        <article>
            <p>{{$value}}
        </article>
        @endsession

        <label>
            Piesaistīšanas kods
            <input required type=text name=code>
        </label>

        <button>Saglabāt</button>
    </form>
</article>

@if ($reviewerIdentities->count())
    <h3>Tavi pārskatītāja žetoni</h3>

    <table>
        <thead>
            <tr><th>Pārskatītājs <th>Pārskatījumi <th>Pārskatījumi ar info <th>Pārskatījumi ar atsauksmi
        <tbody>
            @foreach ($reviewerIdentities as $identity)
            <tr>
                <td><a href="{{route('reviewers.show', $identity)}}">
                        {{$identity->reviewer_id}}
                    </a>
                <td>{{$identity->reviews_count}}
                <td>{{$identity->reviews_with_info_count}}
                <td>{{$identity->reviews_with_feedback_count}}
            @endforeach
    </table>

    <hr>

    <h3>Tavi pārskatījumi</h3>
    @include('_reviews')
@endif

@endsection
