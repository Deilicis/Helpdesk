@extends('layouts.adminLayout')
@section('title', 'Register')
@section('content')
<div class="content">
    <main class="registerHolder">
    <form method="POST" action="{{ route('register') }}" class="REG">
        @csrf
        <!-- Name -->
        <div class="inputCont">
            <x-input-label class="label" for="name" :value="__('Vārds')" />
            <input id="name" class="ievade" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="inputCont">
            <x-input-label class="label" for="email" :value="__('Epasts')" />
            <input id="email" class="ievade" type="email" name="email" required autocomplete="false"  />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="inputCont">
            <x-input-label class="label" for="password" :value="__('Parole')" />

            <input class="ievade" id="password" 
                            type="text"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="inputCont">
            <x-input-label class="label" for="password_confirmation" :value="__('Apstiprināt Paroli')" />

            <input class="ievade" id="password_confirmation"
                            type="text"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
            <button class="btn">
                {{ __('Reģistrēt') }}
            </button>

    </form>
</main>
</div>
@endsection