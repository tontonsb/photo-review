@extends('layout')

@section('content')
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
        <tr><th>Mape <th>Bildes <th>Pārskatītas <th>Jāpārskata
    <tbody>
    @foreach ($directories as $dir)
        <tr>
            <td><a href="{{route('reviewables.index', ['filter' => $dir->dir])}}">{{$dir->dir}}</a>
            <td>{{$dir->files}}
            <td>{{$dir->reviewed_files}}
            <td>{{$dir->files - $dir->reviewed_files}}
    @endforeach
</table>
@endsection
