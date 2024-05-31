@extends('layout')

@section('content')
<input class=js-quick-filter autofocus placeholder="Filtrēt..." value="{{request()->filter}}">

<nav>
    <ul>
        <li><a href="{{route('reviewables.directory')}}">
            Katalogs
        </a>
        <li><a href="{{route('reviewables.index')}}">
            Visi faili
        </a>
    </ul>
</nav>

<table>
    <thead>
        <tr><th>Bilde <th>Apskatījumi <th>Rezultāti
    <tbody class=js-filterable>
        @foreach ($reviewables as $reviewable)
        <tr>
            <td><a href="{{route('reviewables.show', $reviewable->path)}}">
                    {{$reviewable->path}}
                </a>
            <td>{{$reviewCounts[$reviewable->path]->review_count ?? 0}}
            <td>{{$reviewCounts[$reviewable->path]->reviews ?? ''}}
        @endforeach
</table>

<script>
const rows = document.querySelectorAll('.js-filterable tr')
const input = document.querySelector('.js-quick-filter')

const filter = _ => {
    const text = input.value

    rows.forEach(
        row => row.style.display = row.textContent.includes(text) ? 'table-row' : 'none'
    )
}

input.addEventListener('input', filter)

filter()
</script>
@endsection
