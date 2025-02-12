@extends('layouts.guestLayout')
@section('title', 'Login')
@section('content')
<div class="content">
    <main class="main">
    <h1>Ielogoties</h1>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="inputCont">
            <x-input-label class="label" for="email" :value="__('Epasts')" />
            <input class="input" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="inputCont">
            <x-input-label class="label" for="password" :value="__('Parole')" />
            

            <input class="input" id="password"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class=inputCont>
            <label class="label" for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="remember">{{ __('Neaizmirst mani') }}</span>
            </label>
        </div>

        <div>
            {{-- @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">
                    {{ __('Parole aizmirsta?') }}
                </a>
            @endif --}}

            <button class="btn-primary">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</main>
</div>
    @yield('footer')


@endsection