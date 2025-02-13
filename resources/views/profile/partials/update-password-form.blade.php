<section>
    <header>
        <h2 class="btn-primary">
            {{ __('Nomainīt paroli') }}
        </h2>
    </header>

    <form class="form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="inputCont">
            <x-input-label for="update_password_current_password" :value="__('Parole')" />
            <input class="input" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="inputCont">
            <x-input-label for="update_password_password" :value="__('Jaunā parole')" />
            <input class="input" id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="inputCont">
            <x-input-label for="update_password_password_confirmation" :value="__('Apstiprināt jauno paroli')" />
            <input class="input" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button class="btn btn-primary">{{ __('Saglabāt') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
