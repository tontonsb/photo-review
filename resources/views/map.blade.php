@extends('base-layout')

@section('head')
@vite(['resources/css/map.css'])
@endsection

@section('body')
<div id=map style="width: 100%; height: 100%;"></div>

@vite(['resources/js/map.js'])
<script type=module>
showFeaturesOnMap(
    'map',
    '{{route('reviewables.geojson')}}',
    console.log,
)
</script>
@endsection
