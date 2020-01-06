<nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background:url({{ asset('img/nav-bg.png')}})">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'NK Carcassonne') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        @if(App\Round::isRoundPlayed() == true)
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ranglijst.index') }}">{{ __('Ranglijst') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tafel.index') }}">{{ __('Tafel') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spelers.index') }}">{{ __('Spelers') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('gallerij.index') }}">{{ __('Gallerij') }}</a>
                                </li>

                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ranglijst.index') }}">{{ __('Ranglijst') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tafel.index') }}">{{ __('Tafel') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('spelers.index') }}">{{ __('Spelers') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('gallerij.index') }}">{{ __('Gallerij') }}</a>
                                </li>
                            @endguest
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Inloggen') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Inschrijven') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item-nav dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->f_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item nav" href="{{ route('dashboard') }}">{{ __('Beheer pagina') }}</a>

                                    <a class="dropdown-item nav" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Uitloggen') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
