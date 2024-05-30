@extends('layout')

@section('content')
<input class=js-quick-filter autofocus placeholder="Filtrēt...">

<table>
    <thead>
        <tr><th>Bilde <th>Apskatījumi
    <tbody class=js-filterable>
        @foreach ($reviewables as $reviewable)
        <tr>
            <td><a href="{{route('reviewables.show', $reviewable->path)}}">
                    {{$reviewable->path}}
                </a>
            <td>{{$reviewCounts[$reviewable->path] ?? 0}}
        @endforeach
</table>

<script>
const rows = document.querySelectorAll('.js-filterable tr')
const filter = document.querySelector('.js-quick-filter')

filter.addEventListener('input', _ => {
    const text = filter.value

    rows.forEach(
        row => row.style.display = row.textContent.includes(text) ? 'table-row' : 'none'
    )
})
</script>
@endsection
