<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="form-principal-guest">
        @csrf
        <h1 class="principal-text">{{ config('app.name', 'Laravel') }}</h1>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Seu nome" />
        </div>
        <x-input-error :messages="$errors->get('name')" style="padding: 0 15px" />

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input placeholder="seu@email.com" id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>
        <x-input-error :messages="$errors->get('email')" style="padding: 0 15px" />

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password"
                            placeholder="********"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" style="padding: 0 15px"/>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="padding: 0 15px" />

        <div class="flex items-center justify-end mt-4">
            <a class="link-text" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
