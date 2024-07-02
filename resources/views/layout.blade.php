@use('Facades\App\Services\ReviewerService')

@extends('base-layout')


@section('head')
@vite(['resources/css/internal.css'])
@endsection

@section('body')
<header>
    <nav>
        <ul>
            <li><a
                href="{{ route('reviews.index') }}"
                class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}"
                >@lang('menu.reviews')</a></li>
            <li><a
                href="{{ route('reviewables.index') }}"
                class="{{ request()->routeIs('reviewables.index') ? 'active' : '' }}"
                >@lang('menu.reviewables')</a></li>
            <li><a
                href="{{ route('reviewers.index') }}"
                class="{{ request()->routeIs('reviewers.index') ? 'active' : '' }}"
                >@lang('menu.reviewers')</a></li>
            <li><a
                href="{{ route('reviewers.me') }}"
                class="{{ request()->routeIs('reviewers.me') ? 'active' : '' }}"
                >@lang('menu.your reviews')</a></li>
            <li><a
                href="{{ route('reviewables.random') }}"
                class="{{ request()->routeIs('reviewables.random') ? 'active' : '' }}"
                >@lang('menu.continue')</a></li>
        </ul>

        @auth
            <form method=post action="{{route('logout')}}">
                @csrf
                <p>
                    <a href="{{route('me')}}">{{auth()->user()->name}}</a>
                    (<a
                        href="{{route('logout')}}"
                        onclick="event.preventDefault();this.closest('form').submit();"
                    >@lang('auth.logout')</a>)
                </p>
            </form>
        @else
            <a href="{{route('login')}}">@lang('auth.login')</a>
        @endauth
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    <hr>
    <nav>
        <p>
            @lang('menu.contact') — <a href="mailto:juris@glaive.pro">juris@glaive.pro</a>
        </p>
        <a href="https://github.com/tontonsb/photo-review/" target=_blank>@lang('menu.sources')</a>
    </nav>
</footer>

@endsection
