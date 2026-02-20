<x-guest-layout>
    <div class="min-h-screen relative flex items-center justify-center p-4 bg-gray-50 overflow-hidden">
        {{-- Background Abstract Shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-primary-500/10 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>

        <div class="w-full max-w-5xl z-10">
            <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[500px]">
                
                {{-- Left Side: Visual & Brand (Security Context) --}}
                <div class="hidden md:flex md:w-5/12 bg-primary-900 relative items-center justify-center p-12 overflow-hidden">
                    {{-- Abstract Background Elements --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-secondary opacity-90"></div>
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary-700/30 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 text-center w-full max-w-sm">
                        <div class="mb-8 inline-flex items-center justify-center p-5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl animate-pulse">
                           <i class="fas fa-lock text-5xl text-accent"></i>
                        </div>
                        
                        <h2 class="text-3xl font-extrabold font-sans text-white mb-4 tracking-tight">
                            Restablecer Acceso
                        </h2>
                        
                        <p class="text-blue-100 text-lg font-light leading-relaxed">
                            "Crea una nueva contraseña segura para proteger tu cuenta y tus datos personales."
                        </p>

                        <div class="mt-8 opacity-60">
                             <img src="{{ asset('img/Isotipo_Blanco.png') }}" onerror="this.src='{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}'" alt="Academia Effi" class="h-12 w-auto object-contain mx-auto brightness-0 invert">
                        </div>
                    </div>
                </div>

                {{-- Right Side: Reset Password Form --}}
                <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-secondary to-primary-800 md:hidden"></div>

                    <div class="flex justify-center mb-8">
                        <div class="bg-gradient-to-r from-secondary via-primary-700 to-primary-900 rounded-2xl p-4 shadow-lg inline-block transform hover:scale-105 transition-transform duration-300">
                             <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi ERP" class="h-12 w-auto object-contain">
                        </div>
                    </div>

                    <div class="mb-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-800 font-sans mb-2">Nueva Contraseña</h3>
                        <p class="text-gray-500 text-sm leading-relaxed max-w-md mx-auto">
                            Ingresa y confirma tu nueva contraseña a continuación.
                        </p>
                    </div>

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        {{-- Email Field (Readonly usually, but editable here if needed, consistent styling) --}}
                        <div class="space-y-2">
                             <label for="email" class="text-sm font-bold text-gray-700 ml-1">Correo Electrónico</label>
                             <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input id="email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                    type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                            </div>
                        </div>

                        {{-- Password Field --}}
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-bold text-gray-700 ml-1">Nueva Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                   <i class="fas fa-lock"></i>
                                </div>
                                <input id="password" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400" 
                                       type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            </div>
                        </div>

                        {{-- Confirm Password Field --}}
                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-sm font-bold text-gray-700 ml-1">Confirmar Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                   <i class="fas fa-lock-open"></i>
                                </div>
                                <input id="password_confirmation" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400" 
                                       type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                            </div>
                        </div>

                        <button type="submit" class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-secondary to-primary-800 text-white font-bold text-lg shadow-lg shadow-primary-900/20 hover:shadow-xl hover:shadow-primary-900/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center gap-2 group mt-2">
                            {{ __('Restablecer Contraseña') }}
                            <i class="fas fa-check-circle group-hover:scale-110 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
             <p class="text-center text-gray-400 text-xs mt-8">
                &copy; {{ date('Y') }} Academia Effi ERP. <a href="#" class="hover:text-primary-600">Privacidad</a>
            </p>
        </div>
    </div>
</x-guest-layout>
