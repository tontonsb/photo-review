@extends('layout')

@section('content')
<nav>
    <ul>
        <li><a href="{{route('reviewables.directory')}}">
            @lang('reviewables.dir')
        </a>
        <li><a href="{{route('reviewables.index')}}">
            @lang('reviewables.all')
        </a>
    </ul>
</nav>

<table>
    <thead>
        <tr><th>@lang('reviewables.folder') <th>@lang('reviewables.reviewables') <th>@lang('reviewables.reviewed') <th>@lang('reviewables.unreviewed')
    <tbody>
    @foreach ($directories as $dir)
        <tr>
            <td><a href="{{route('reviewables.index', ['filter' => $dir->dir])}}">{{$dir->dir}}</a>
            <td>{{$dir->files}}
            <td>{{$dir->reviewed_files}} ({{round(100 * $dir->reviewed_files / $dir->files)}}%)
            <td>{{$dir->files - $dir->reviewed_files}}
    @endforeach
</table>
@endsection
