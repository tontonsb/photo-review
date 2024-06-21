@use('Facades\App\Services\ReviewerService')

@extends('base-layout')


@section('head')
@vite(['resources/css/internal.css'])
@endsection

@section('body')
<header>
    <nav>
        <ul>
            <li><a href="{{ route('reviews.index') }}" class="{{ request()->routeIs('reviews.index') ? 'active' : '' }}">Visi pārskatījumi</a></li>
            <li><a href="{{ route('reviewables.index') }}" class="{{ request()->routeIs('reviewables.index') ? 'active' : '' }}">Bildes</a></li>
            <li><a href="{{ route('reviewers.index') }}" class="{{ request()->routeIs('reviewers.index') ? 'active' : '' }}">Pārskatītāji</a></li>
            <li><a href="{{ route('reviewers.me') }}" class="{{ request()->routeIs('reviewers.me') ? 'active' : '' }}">Tavi pārskatījumi</a></li>
            <li><a href="{{ route('reviewables.random') }}" class="{{ request()->routeIs('reviewables.random') ? 'active' : '' }}">Turpināt pārskatīšanu</a></li>
        </ul>

        @auth
            <form method=post action="{{route('logout')}}">
                @csrf
                <p>
                    <a href="{{route('me')}}">{{auth()->user()->name}}</a>
                    (<a
                        href="{{route('logout')}}"
                        onclick="event.preventDefault();this.closest('form').submit();"
                    >Atslēgties</a>)
                </p>
            </form>
        @else
            <a href="{{route('login')}}">Pieslēgties</a>
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
            Sazināties ar projekta turētāju — <a href="mailto:juris@glaive.pro">juris@glaive.pro</a>
        </p>
        <a href="https://github.com/tontonsb/photo-review/" target=_blank>Projekta izejas kods</a>
    </nav>
</footer>

@endsection
