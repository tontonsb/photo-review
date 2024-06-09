@if ($exif['LOCATION'] ?? false)
    @if ($file->isSonarImage())
        makeMapWith.box(
            '{{$element}}',
            @json($exif['LOCATION']),
            '{{route('reviewables.geojson')}}',
            {{$listener}},
        )
    @else
        makeMapWith.pin(
            '{{$element}}',
            @json($exif['LOCATION']),
            {{deg2rad($exif['YAW'] ?? 0)}},
            '{{asset('icons/drone_marker.svg')}}',
            '{{route('reviewables.geojson')}}',
            {{$listener}},
        )
    @endif
@endif
