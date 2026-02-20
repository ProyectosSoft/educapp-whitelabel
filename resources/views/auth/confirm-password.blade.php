<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Confirm') }}
                </x-button>
            </div>
            <div class="mx-auto mb-4 mt-4 flex items-center justify-center">
                <span class="text-white">Síguenos en:</span>
                <a href="https://www.youtube.com/@Educapp_Oficial" class="text-white mx-2 text-3xl"><i class="fab fa-youtube"></i></a>
                <a href="https://www.instagram.com/educapp_oficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white mx-2 text-3xl"><i class="fab fa-instagram"></i></a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
