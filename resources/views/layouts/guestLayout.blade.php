<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Fonts and Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'], 'defer')          
    @endif
</head>
<body>
    <header class="header">
        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="option">Dashboard</a>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="option">
                                    <div>{{ Auth::user()->name }}</div>
                                </button>
                            </x-slot>
    
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profils') }}
                                </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                               {{ __('Reģistrēt') }}
                            </x-dropdown-link>
                            
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
        
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="option">Log in</a>
                @endauth
                {{-- <a href="{{ route('form') }}" class="option">Form</a> --}}
                
            </nav>
        @endif
    </header>
       @yield('content')
       <footer>
       <p>Footer</p>
    </footer>
    </body>
</html>