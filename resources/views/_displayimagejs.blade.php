@if ($file->isSonarImage() && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageOnMap(
        '{{$element}}',
        @json($exif['LOCATION']),
        '{{$file->url}}',
        {{$intercative ? 'true' : 'false'}},
    )
@elseif (($exif['EXTENT'] ?? false) && ($exif['LOCATION'] ?? false))
    const {map, userMarkers} = displayImageWithScale(
        '{{$element}}',
        [{{$exif['LOCATION']['lon'] ?? 0}}, {{$exif['LOCATION']['lat'] ?? 0}}],
        {{$exif['YAW'] ?? 0}},
        [{{$exif['EXTENT']['width'] ?? 0}}, {{$exif['EXTENT']['height'] ?? 0}}],
        '{{$file->url}}',
        {{$intercative ? 'true' : 'false'}},
    )
@else
    const {map, userMarkers} = displayImage(
        '{{$element}}',
        [{{$exif['COMPUTED']['Width'] ?? 0}}, {{$exif['COMPUTED']['Height'] ?? 0}}],
        '{{$file->url}}',
        {{$intercative ? 'true' : 'false'}},
    )
@endif
