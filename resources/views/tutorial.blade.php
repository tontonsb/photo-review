@extends('base-layout')

@section('head')
@vite(['resources/css/tutorial.css'])
@endsection

@section('body')
<main>
    <div id=image></div>

    <form>
        <div class=tutorial-info>
            {{$reviewable->tutorial_info}}
        </div>

        <div class=actions>
            @if ($prev)
            <a class=button href="{{route('tutorial.show', $prev)}}">
                @lang('tutorial.prev')
            </a>
            @endif

            @if ($next)
            <a class=button href="{{route('tutorial.show', $next)}}">
                @lang('tutorial.next')
            </a>
            @else
            <a class="button button--ok" href="{{route('reviewables.random')}}">
                @lang('tutorial.finish')
            </a>
            @endif
        </div>

        <div class=file>
            <div id=location-map style="width: 100%; height: 100px;"></div>
            <details>
                <summary>
                    {{$file->path}}
                </summary>
                <a href="{{$file->url}}" target=_blank>{{$file->path}}</a>
                @include('_exif')
            </details>
        </div>

        <aside>
            <div class=buttons>
                <button type=button class="js-show-infobox button--info">
                    @lang('menu.open infobox')
                </button>
                <a class="button button--info" href="{{route('reviewers.me')}}">
                    @lang('menu.reviewed images')
                </a>
            </div>
        </aside>
    </form>
</main>

@include('_infobox')

@vite(['resources/js/reviewer.js'])
<script type=module>
bootInfobox('.js-infobox', '.js-show-infobox', false)

@include('_displayimagejs', ['exif' => $exif, 'element' => 'image', 'file' => $file, 'intercative' => true])

@include('_minimap', ['exif' => $exif, 'element' => 'location-map', 'file' => $file])
</script>
@endsection
