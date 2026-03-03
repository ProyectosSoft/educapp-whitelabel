<x-guest-layout>
    {{-- Main Background with subtle SaaS decorative blobs --}}
    <div class="min-h-screen bg-gray-50/50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        {{-- Decorative Background Orbs --}}
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary-900/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-secondary/10 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

        <div class="max-w-6xl w-full mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-5 rounded-[2.5rem] overflow-hidden border border-gray-100 bg-white shadow-2xl shadow-primary/10">
                
                {{-- Left Column: Branding & Value Props --}}
                <div class="relative lg:col-span-2 p-10 md:p-14 bg-gradient-to-br from-primary to-primary-700 text-white flex flex-col justify-between overflow-hidden">
                    {{-- Inner Card Decorative Orbs --}}
                    <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-[#ECBD2D]/20 blur-3xl"></div>

                    <div class="relative z-10">
                        <div class="mb-14 flex justify-center">
                            <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}"
                                 alt="Academia Effi"
                                 class="h-20 w-auto drop-shadow-2xl brightness-110 sm:h-24 hover:scale-[1.02] transition-transform duration-300">
                        </div>

                        <div class="space-y-6">
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-xs font-bold tracking-widest uppercase text-[#ECBD2D] shadow-sm">
                                <i class="fas fa-building mr-2"></i> Registro Empresarial
                            </div>
                            
                            <h2 class="text-3xl md:text-4xl font-extrabold leading-tight tracking-tight">
                                Impulsa la capacitación de tu cuenta
                            </h2>
                            
                            <p class="text-blue-100 text-sm md:text-base leading-relaxed font-medium">
                                Crea tu entorno corporativo y centraliza los cursos, evaluaciones y el progreso de los colaboradores en un solo lugar.
                            </p>
                        </div>
                    </div>

                    <div class="relative z-10 mt-12">
                        <ul class="space-y-5 text-sm font-medium text-blue-50">
                            <li class="flex items-start group">
                                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center mr-4 shrink-0 group-hover:bg-[#ECBD2D]/20 transition-colors">
                                    <i class="fas fa-check text-[#ECBD2D] text-xs"></i>
                                </div>
                                <span class="leading-relaxed">Onboarding automatizado para equipos y departamentos.</span>
                            </li>
                            <li class="flex items-start group">
                                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center mr-4 shrink-0 group-hover:bg-[#ECBD2D]/20 transition-colors">
                                    <i class="fas fa-check text-[#ECBD2D] text-xs"></i>
                                </div>
                                <span class="leading-relaxed">Seguimiento académico con métricas y reportes en tiempo real.</span>
                            </li>
                            <li class="flex items-start group">
                                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center mr-4 shrink-0 group-hover:bg-[#ECBD2D]/20 transition-colors">
                                    <i class="fas fa-check text-[#ECBD2D] text-xs"></i>
                                </div>
                                <span class="leading-relaxed">Certificados y evaluaciones integradas y segmentadas por rol.</span>
                            </li>
                            <li class="flex items-start group">
                                <div class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center mr-4 shrink-0 group-hover:bg-[#ECBD2D]/20 transition-colors">
                                    <i class="fas fa-check text-[#ECBD2D] text-xs"></i>
                                </div>
                                <span class="leading-relaxed">Entorno escalable para múltiples áreas y responsables.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Right Column: Form --}}
                <div class="lg:col-span-3 p-10 md:p-16 bg-white flex flex-col justify-center relative">
                    <div class="mb-10">
                        <h3 class="text-3xl font-extrabold text-primary tracking-tight">Crear Cuenta</h3>
                        <p class="text-gray-500 mt-2 text-sm font-medium">¿Ya tienes una cuenta registrada?
                            <a href="{{ route('login') }}" class="font-bold text-[#ECBD2D] hover:text-[#d4a827] transition-colors ml-1 hover:underline">Inicia sesión aquí</a>
                        </p>
                    </div>

                    <x-validation-errors class="mb-6 bg-red-50 p-4 rounded-xl border border-red-100" />

                    <form method="POST" action="{{ route('register-business') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nombre Empresa --}}
                            <div class="md:col-span-2">
                                <label for="company_name" class="block text-sm font-bold text-primary mb-2">{{ __('Nombre de la Empresa') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-building text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                    </div>
                                    <x-input id="company_name" class="block w-full pl-11 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-primary focus:ring focus:ring-primary/20 py-3.5 shadow-sm transition-all placeholder-gray-400" type="text" name="company_name" :value="old('company_name')" required autofocus placeholder="Ej: Tech Solutions S.A.S" />
                                </div>
                            </div>

                            {{-- Nombre Admi --}}
                            <div>
                                <label for="name" class="block text-sm font-bold text-primary mb-2">{{ __('Nombre del Administrador') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                    </div>
                                    <x-input id="name" class="block w-full pl-11 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-primary focus:ring focus:ring-primary/20 py-3.5 shadow-sm transition-all placeholder-gray-400" type="text" name="name" :value="old('name')" required placeholder="Tu nombre completo" />
                                </div>
                            </div>

                            {{-- Correo --}}
                            <div>
                                <label for="email" class="block text-sm font-bold text-primary mb-2">{{ __('Correo Corporativo') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                    </div>
                                    <x-input id="email" class="block w-full pl-11 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-primary focus:ring focus:ring-primary/20 py-3.5 shadow-sm transition-all placeholder-gray-400" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="admin@empresa.com" />
                                </div>
                            </div>

                            {{-- Contraseña --}}
                            <div>
                                <label for="password" class="block text-sm font-bold text-primary mb-2">{{ __('Contraseña') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                    </div>
                                    <x-input id="password" class="block w-full pl-11 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-primary focus:ring focus:ring-primary/20 py-3.5 shadow-sm transition-all placeholder-gray-400" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
                                </div>
                            </div>

                            {{-- Confirmar Contraseña --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-primary mb-2">{{ __('Confirmar Contraseña') }}</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-check-double text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                    </div>
                                    <x-input id="password_confirmation" class="block w-full pl-11 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-primary focus:ring focus:ring-primary/20 py-3.5 shadow-sm transition-all placeholder-gray-400" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite la contraseña" />
                                </div>
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                                <x-label for="terms">
                                    <div class="flex items-start">
                                        <x-checkbox name="terms" id="terms" required class="mt-0.5 rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" />
                                        <div class="ml-3 text-sm text-gray-600 font-medium">
                                            Acepto los <a target="_blank" href="{{ route('terms.show') }}" class="underline font-bold text-primary hover:text-[#ECBD2D] transition-colors">Términos de Servicio</a> y la <a target="_blank" href="{{ route('policy.show') }}" class="underline font-bold text-primary hover:text-[#ECBD2D] transition-colors">Política de Privacidad</a> de Academia Effi.
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif

                        <div class="pt-4">
                            <button type="submit" class="w-full relative overflow-hidden group inline-flex items-center justify-center px-6 py-4 rounded-xl bg-primary text-white font-extrabold tracking-wide hover:bg-primary-600 transition-all shadow-xl shadow-primary/20 transform hover:-translate-y-0.5">
                                <span class="relative z-10 flex items-center">
                                    Crear Cuenta Corporativa
                                    <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                                </span>
                                {{-- Hover Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent translate-x-[-100%] group-hover:animate-[shimmer_1.5s_infinite] pointer-events-none"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Shimmer Animation for the button --}}
    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</x-guest-layout>
