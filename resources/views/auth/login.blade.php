<x-guest-layout>
    <div class="min-h-screen relative flex items-center justify-center p-4 bg-gray-50 overflow-hidden">
        {{-- Background Abstract Shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-primary-500/10 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>

        <div class="w-full max-w-5xl z-10">
            <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
                
                {{-- Left Side: Visual & Brand (Hidden on small mobile, visible on md+) --}}
                <div class="hidden md:flex md:w-1/2 bg-primary-900 relative items-center justify-center p-12 overflow-hidden group"
                     x-data="{
                        activeImage: 0,
                        images: [
                            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
                        ],
                        init() {
                            setInterval(() => {
                                this.activeImage = (this.activeImage + 1) % this.images.length;
                            }, 5000);
                        }
                     }">
                    {{-- Background Image with Overlay --}}
                    {{-- Background Image Slider with Alpine.js --}}
                    {{-- Background Image Slider with Alpine.js --}}
                    <div class="absolute inset-0 w-full h-full">
                        <template x-for="(image, index) in images" :key="index">
                            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                                 :style="`background-image: url('${image}')`"
                                 :class="{ 'opacity-50': activeImage === index, 'opacity-0': activeImage !== index }">
                            </div>
                        </template>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-900/80 via-primary-800/80 to-secondary/70 mix-blend-multiply"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-transparent to-transparent opacity-80"></div>
                    
                    {{-- Content --}}
                    <div class="relative z-10 text-white text-center">
                        <div class="mb-8 inline-flex items-center justify-center p-4 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl">
                            <img src="{{ asset('img/Isotipo_Blanco.png') }}" onerror="this.src='{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}'" alt="Academia Effi" class="h-16 w-auto object-contain brightness-0 invert">
                        </div>
                        <h2 class="text-4xl font-bold font-sans mb-4 tracking-tight">Universidad Corporativa</h2>
                        <p class="text-blue-100 text-lg font-light leading-relaxed max-w-xs mx-auto">
                            "Potencia tu talento y alcanza nuevas metas con nuestra plataforma de aprendizaje."
                        </p>
                        
                        {{-- Decorative dots --}}
                        {{-- Animated Indicators --}}
                        <div class="flex gap-2 justify-center mt-8 z-20 relative">
                            <template x-for="(image, index) in images" :key="index">
                                <button @click="activeImage = index" 
                                        class="h-2 rounded-full transition-all duration-500 focus:outline-none"
                                        :class="activeImage === index ? 'w-8 bg-white' : 'w-2 bg-white/50 hover:bg-white/80'">
                                </button>
                            </template>
                        </div>
                    </div>
                    
                    {{-- Abstract floating shapes --}}
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-secondary/30 rounded-full blur-2xl"></div>
                    <div class="absolute top-10 -left-10 w-20 h-20 bg-accent/20 rounded-full blur-xl animate-pulse"></div>
                </div>

                {{-- Right Side: Login Form --}}
                <div class="w-full md:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white relative">
                    
                    {{-- Decoration for mobile only layout --}}
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-secondary to-primary-800 md:hidden"></div>

                    <div class="flex justify-center mb-10">
                         {{-- Using the logo nicely sized with background for contrast --}}
                        <div class="bg-gradient-to-r from-secondary via-primary-700 to-primary-900 rounded-2xl p-6 shadow-lg inline-block transform hover:scale-105 transition-transform duration-300">
                             <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi ERP" class="h-24 w-auto object-contain">
                        </div>
                    </div>

                    <div class="mb-8 text-center md:text-left">
                        <h3 class="text-3xl font-bold text-gray-800 font-sans mb-2">¡Hola de nuevo!</h3>
                        <p class="text-gray-500">Ingresa a tu cuenta para continuar aprendiendo.</p>
                    </div>

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-6 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-xl border border-green-100 flex items-center gap-3">
                            <i class="fas fa-check-circle text-lg"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-bold text-gray-700 ml-1">Correo Electrónico</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input id="email" class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                    type="email" name="email" :value="old('email')" placeholder="usuario@empresa.com" required autofocus autocomplete="username" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="password" class="text-sm font-bold text-gray-700 ml-1">Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-secondary transition-colors">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input id="password" class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition-all duration-200 text-gray-800 placeholder-gray-400"
                                    type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-secondary cursor-pointer focus:outline-none transition-colors">
                                    <i id="toggleIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <label for="remember_me" class="flex items-center cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 transition-all cursor-pointer" name="remember">
                                </div>
                                <span class="ml-2 text-sm text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Recuérdame') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-bold text-primary-600 hover:text-primary-800 transition-colors hover:underline" href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-secondary to-primary-800 text-white font-bold text-lg shadow-lg shadow-primary-900/20 hover:shadow-xl hover:shadow-primary-900/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 flex items-center justify-center gap-2 group">
                            {{ __('Iniciar Sesión') }}
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>

                    <div class="mt-8 flex items-center justify-center gap-6">
                        <span class="text-xs font-bold text-gray-300 uppercase tracking-widest">Síguenos</span>
                        <div class="h-px w-10 bg-gray-100"></div>
                        <div class="flex gap-4">
                             <a href="https://www.youtube.com/@Educapp_Oficial" target="_blank" class="text-gray-400 hover:text-red-600 transition-colors transform hover:scale-110">
                                <i class="fab fa-youtube text-2xl"></i>
                            </a>
                            <a href="https://www.instagram.com/educapp_oficial" target="_blank" class="text-gray-400 hover:text-pink-600 transition-colors transform hover:scale-110">
                                <i class="fab fa-instagram text-2xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-center text-gray-400 text-xs mt-8">
                &copy; {{ date('Y') }} Academia Effi ERP. <a href="#" class="hover:text-primary-600">Privacidad</a> &bull; <a href="#" class="hover:text-primary-600">Términos</a>
            </p>
        </div>
    </div>
    
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggleIcon');
    
        togglePassword.addEventListener('click', function (e) {
            e.preventDefault();
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            toggleIcon.classList.toggle('fa-eye');
            toggleIcon.classList.toggle('fa-eye-slash');
        });
    </script>



</x-guest-layout>
