@extends('layouts.adminLayout')
@section('title', 'Lietotaji')
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="div-profile-section">
                <div class="formHolder">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="div-profile-section">
                <div class="formHolder">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection
