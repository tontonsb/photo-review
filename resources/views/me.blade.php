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
    <header><h3>Tava statistika:</h3></header>
    <ul>
        <li>Apskatītas {{$reviewCount}} bildes
        <li>Pārskatītas (neizlaistas) {{$reviewedCount}} bildes
        <li>Veltītas {{$timeSpent}}
    </ul>
</article>
@endif

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

@if ($reviewerIdentities->count())
    <hr>

    <table>
        <caption>Tavi pārskatītāja žetoni:</caption>
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

    @include('_reviews')
@endif

@endsection
