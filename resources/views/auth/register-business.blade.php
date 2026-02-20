<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-greenLime_500 p-5 imagen_login">
        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-0 overflow-hidden rounded-3xl shadow-2xl backdrop-filter-login border border-white/20">
            
            {{-- Left Side: Marketing --}}
            <div class="hidden md:flex flex-col justify-center p-12 text-white relative overflow-hidden bg-primary-900/40">
                <div class="relative z-10">
                    <x-application-mark class="h-16 w-auto mb-8" />
                    
                    <h2 class="text-4xl font-extrabold mb-6 leading-tight text-white">
                        Transforma tu Empresa
                    </h2>
                    <ul class="space-y-4 text-lg font-medium text-gray-200">
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-secondary-400 text-xl"></i> Onboarding automatizado con links mágicos.
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-secondary-400 text-xl"></i> Certificados con validez oficial.
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-secondary-400 text-xl"></i> Dashboard de control y auditoría.
                        </li>
                         <li class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-secondary-400 text-xl"></i> Ahorra costos en capacitación.
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Right Side: Form --}}
            <div class="p-10 flex flex-col justify-center bg-white/10 backdrop-blur-md">
                <div class="text-center mb-8">
                     <h3 class="text-2xl font-bold text-white">Crear Cuenta Empresarial</h3>
                     <p class="text-gray-300 text-sm mt-2">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-secondary-400 font-bold hover:underline">Inicia Sesión</a></p>
                </div>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register-business') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="company_name" class="block font-bold text-sm text-gray-200 mb-2">{{ __('Nombre de la Empresa') }}</label>
                        <x-input id="company_name" class="block mt-1 w-full bg-greenLime_700 border-transparent focus:border-secondary-500 focus:ring-secondary-500 rounded-lg shadow-sm py-3 text-white placeholder-gray-300" type="text" name="company_name" :value="old('company_name')" required autofocus autocomplete="organization" placeholder="Ej: Tech Solutions S.A.S" />
                    </div>

                    <div>
                        <label for="name" class="block font-bold text-sm text-gray-200 mb-2">{{ __('Nombre del Administrador') }}</label>
                        <x-input id="name" class="block mt-1 w-full bg-greenLime_700 border-transparent focus:border-secondary-500 focus:ring-secondary-500 rounded-lg shadow-sm py-3 text-white placeholder-gray-300" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Tu nombre completo" />
                    </div>

                    <div>
                        <label for="email" class="block font-bold text-sm text-gray-200 mb-2">{{ __('Correo Corporativo') }}</label>
                        <x-input id="email" class="block mt-1 w-full bg-greenLime_700 border-transparent focus:border-secondary-500 focus:ring-secondary-500 rounded-lg shadow-sm py-3 text-white placeholder-gray-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="admin@empresa.com" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block font-bold text-sm text-gray-200 mb-2">{{ __('Contraseña') }}</label>
                            <div class="relative">
                                <x-input id="password" class="block mt-1 w-full bg-greenLime_700 border-transparent focus:border-secondary-500 focus:ring-secondary-500 rounded-lg shadow-sm py-3 text-white placeholder-gray-300" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-bold text-sm text-gray-200 mb-2">{{ __('Confirmar Contraseña') }}</label>
                            <x-input id="password_confirmation" class="block mt-1 w-full bg-greenLime_700 border-transparent focus:border-secondary-500 focus:ring-secondary-500 rounded-lg shadow-sm py-3 text-white placeholder-gray-300" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite la contraseña" />
                        </div>
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="mt-4">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ml-2 text-white">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-8">
                         <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-secondary text-primary-900 border border-transparent rounded-md font-bold text-sm uppercase tracking-widest hover:bg-secondary-400 active:bg-secondary-600 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg transform hover:scale-[1.02]">
                            {{ __('Crear Cuenta Empresarial') }} <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
