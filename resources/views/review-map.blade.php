@extends('base-layout')

@section('head')
@vite(['resources/css/map.css'])
<style>
#tooltip {
    position: absolute;
    display: inline-block;
    height: auto;
    width: auto;
    z-index: 100;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 4px;
    padding: 5px;
    left: 50%;
    transform: translateX(3%);
    visibility: hidden;
    pointer-events: none;
}
</style>
@endsection

@section('body')
<div id=map style="width: 100%; height: 100%;">
    <div id=tooltip></div>
</div>

@vite(['resources/js/review-map.js'])
<script type=module>
    showReviewMap(
        'map',
        '{!! $reviews !!}',
    )
</script>
@endsection
