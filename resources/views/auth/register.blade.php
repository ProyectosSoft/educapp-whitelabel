<x-guest-layout>
    <div class="min-h-screen relative flex items-center justify-center p-4 bg-gray-50 overflow-hidden">
        {{-- Background Abstract Shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-primary-500/10 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>

        <div class="w-full max-w-6xl z-10">
            <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                
                {{-- Left Side: Visual & Brand --}}
                {{-- Left Side: Value Proposition --}}
                <div class="hidden md:flex md:w-5/12 bg-primary-900 relative items-center justify-center p-12 overflow-hidden">
                    {{-- Abstract Background Elements --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-secondary opacity-90"></div>
                    <div class="absolute -top-24 -left-24 w-64 h-64 bg-secondary/20 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary-700/30 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 text-center w-full max-w-sm">
                        <div class="mb-10 inline-flex items-center justify-center p-4 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl transform hover:scale-110 transition-transform duration-300">
                           <img src="{{ asset('img/Isotipo_Blanco.png') }}" onerror="this.src='{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}'" alt="Academia Effi" class="h-16 w-auto object-contain brightness-0 invert">
                        </div>
                        
                        <h2 class="text-3xl font-extrabold font-sans text-white mb-6 tracking-tight">
                            Impulsa tu <span class="text-accent">Carrera Profesional</span>
                        </h2>
                        
                        <div class="space-y-6 text-left">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/10 hover:bg-white/20 transition-colors duration-300 shadow-lg border border-white/10 backdrop-blur-sm">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-primary-700 flex items-center justify-center text-white shadow-inner">
                                    <i class="fas fa-chart-line text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">Desarrollo Profesional</h4>
                                    <p class="text-sm text-blue-100 leading-snug">Potencia tus habilidades y crece dentro de la empresa.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/10 hover:bg-white/20 transition-colors duration-300 shadow-lg border border-white/10 backdrop-blur-sm">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/30 flex items-center justify-center text-white shadow-inner">
                                    <i class="fas fa-users text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">Cultura Corporativa</h4>
                                    <p class="text-sm text-blue-100 leading-snug">Conecta con los valores y la visión de nuestra organización.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/10 hover:bg-white/20 transition-colors duration-300 shadow-lg border border-white/10 backdrop-blur-sm">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-accent shadow-inner">
                                    <i class="fas fa-book-reader text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white">Capacitación Continua</h4>
                                    <p class="text-sm text-blue-100 leading-snug">Accede a recursos exclusivos pensados para tu rol.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Register Form --}}
                <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-secondary to-primary-800 md:hidden"></div>

                    <div class="flex justify-center mb-8">
                        <div class="bg-gradient-to-r from-secondary via-primary-700 to-primary-900 rounded-2xl p-4 shadow-lg inline-block transform hover:scale-105 transition-transform duration-300">
                             <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi ERP" class="h-16 w-auto object-contain">
                        </div>
                    </div>

                    <div class="mb-8 text-center">
                        <h3 class="text-3xl font-bold text-gray-800 font-sans mb-2">Crear una Cuenta</h3>
                        <p class="text-gray-500">Completa tus datos para registrarte.</p>
                    </div>

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf
                        
                        {{-- Logic to detect invitation or legacy company param --}}
                        @php
                            $invitation = null;
                            if (session()->has('invitation_token')) {
                                $invitation = \App\Models\EmpresaInvitation::where('uuid', session('invitation_token'))->first();
                            }
                            $empresaSlug = request()->query('empresa');
                            $empresaLegacy = $empresaSlug ? \App\Models\Empresa::where('slug', $empresaSlug)->where('estado', 1)->first() : null;
                        @endphp

                        <div class="space-y-2">
                             <label for="name" class="text-sm font-bold text-gray-700 ml-1">Nombre Completo</label>
                             <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input id="name" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                    type="text" name="name" :value="old('name')" placeholder="Tu nombre completo" required autofocus autocomplete="name" />
                            </div>
                        </div>

                         <div class="space-y-2">
                             <label for="email" class="text-sm font-bold text-gray-700 ml-1">Correo Electrónico</label>
                             <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input id="email" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                    type="email" name="email" :value="old('email')" placeholder="usuario@empresa.com" required autocomplete="username" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-bold text-gray-700 ml-1">Contraseña</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input id="password" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                        type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-sm font-bold text-gray-700 ml-1">Confirmar</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <input id="password_confirmation" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                        type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                                </div>
                            </div>
                        </div>

                        {{-- Dynamic Logic --}}
                        @if($invitation)
                             <div class="bg-primary-50 p-4 rounded-xl border border-primary-100 text-center">
                                <p class="text-primary-800 text-xs font-bold uppercase tracking-wide mb-1">Invitación Especial para:</p>
                                <h3 class="text-secondary text-lg font-extrabold uppercase">{{ $invitation->empresa->nombre }}</h3>
                                <span class="inline-block bg-white text-secondary text-xs px-2 py-1 rounded shadow-sm border border-secondary/20 mt-2 font-bold">{{ $invitation->role_name }}</span>
                                
                                @if($invitation->departamento)
                                    <p class="text-gray-600 text-xs mt-2">Departamento: <strong>{{ $invitation->departamento->nombre }}</strong></p>
                                    <input type="hidden" name="departamento_id" value="{{ $invitation->departamento_id }}">
                                @else
                                    <div class="mt-3 text-left">
                                        <label class="block font-bold text-xs text-primary-800 mb-1" for="departamento_id">Departamento / Área</label>
                                        <select name="departamento_id" id="departamento_id" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 rounded-lg bg-white text-gray-900" required>
                                            <option value="" disabled selected>-- Selecciona --</option>
                                            @foreach($invitation->empresa->departamentos as $depto)
                                                <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <input type="hidden" name="role_id" value="{{ $invitation->role_name === 'Instructor' ? 2 : 3 }}">
                            </div>

                        @elseif($empresaLegacy)
                            <div class="bg-primary-50 p-4 rounded-xl border border-primary-100 text-center">
                                <p class="text-primary-800 text-xs font-bold uppercase tracking-wide mb-1">Registro Corporativo:</p>
                                <h3 class="text-secondary text-lg font-extrabold uppercase">{{ $empresaLegacy->nombre }}</h3>
                                <input type="hidden" name="empresa_id" value="{{ $empresaLegacy->id }}">
                                <input type="hidden" name="role_id" value="3"> 
                            </div>

                            <div class="space-y-2">
                                <label class="block font-bold text-sm text-gray-700 ml-1" for="departamento_id">Departamento / Área</label>
                                <div class="relative">
                                    <select name="departamento_id" id="departamento_id" class="block w-full pl-3 pr-10 py-3 text-base border-gray-200 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl bg-gray-50 text-gray-800" required>
                                        <option value="" disabled selected>-- Elige tu área --</option>
                                        @foreach($empresaLegacy->departamentos as $depto)
                                            <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                             <div class="space-y-2">
                                 <label for="documento_identidad" class="text-sm font-bold text-gray-700 ml-1">Documento de Identidad</label>
                                 <div class="relative group">
                                     <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <input id="documento_identidad" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                        type="text" name="documento_identidad" :value="old('documento_identidad')" placeholder="Tu identificación" required />
                                </div>
                            </div>
                        @else
                            {{-- Standard Role Selector --}}
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                                <label class="block text-gray-700 mb-3 font-bold text-sm">¿Cómo deseas usar la plataforma?</label>
                                <div class="flex gap-4 justify-center">
                                    <div class="flex items-center">
                                        <input id="role_alumno" type="radio" value="3" name="role_id" class="w-4 h-4 text-secondary bg-white border-gray-300 focus:ring-secondary focus:ring-2 cursor-pointer" checked>
                                        <label for="role_alumno" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer">Alumno</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="role_instructor" type="radio" value="2" name="role_id" class="w-4 h-4 text-secondary bg-white border-gray-300 focus:ring-secondary focus:ring-2 cursor-pointer">
                                        <label for="role_instructor" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer">Instructor</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required class="text-secondary focus:ring-secondary" />
                                <div class="ml-2 text-sm text-gray-600">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-gray-600 hover:text-secondary font-bold">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-gray-600 hover:text-secondary font-bold">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        @endif

                         <button type="submit" class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-secondary to-primary-800 text-white font-bold text-lg shadow-lg shadow-primary-900/20 hover:shadow-xl hover:shadow-primary-900/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center gap-2 group">
                            {{ __('Registrarse') }}
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        
                         <div class="flex items-center justify-center pt-2">
                            <span class="text-sm text-gray-500 mr-2">¿Ya tienes cuenta?</span>
                            <a class="text-sm font-bold text-secondary hover:text-primary-800 transition-colors hover:underline" href="{{ route('login') }}">
                                {{ __('Iniciar Sesión') }}
                            </a>
                        </div>
                    </form>

                     <div class="mt-8 flex items-center justify-center gap-6 border-t border-gray-100 pt-6">
                         <a href="https://www.youtube.com/@Educapp_Oficial" target="_blank" class="text-gray-400 hover:text-red-600 transition-colors transform hover:scale-110">
                            <i class="fab fa-youtube text-2xl"></i>
                        </a>
                        <a href="https://www.instagram.com/educapp_oficial" target="_blank" class="text-gray-400 hover:text-pink-600 transition-colors transform hover:scale-110">
                             <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
             <p class="text-center text-gray-400 text-xs mt-8">
                &copy; {{ date('Y') }} Academia Effi ERP. <a href="#" class="hover:text-primary-600">Privacidad</a> &bull; <a href="#" class="hover:text-primary-600">Términos</a>
            </p>
        </div>
    </div>
</x-guest-layout>
