<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-greenLime_500 p-5 imagen_login">
        <div class="w-full max-w-md mb-8 flex items-center justify-center">
            <img src="{{ asset('img/cursos/Logo_EducApp_2.png') }}" alt="Logo" class="h-24 object-contain">
        </div>
        
        <div class="w-full max-w-md bg-greenLime_700/90 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl text-center relative overflow-hidden">
             
             {{-- Background Decoration --}}
             <div class="absolute top-0 right-0 -mr-10 -mt-10 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>
             <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-32 h-32 rounded-full bg-white/10 blur-xl"></div>

             <div class="relative z-10">
                <div class="mb-6 inline-flex p-4 rounded-full bg-red-500/20 border-2 border-red-400">
                    <i class="fas fa-unlink text-5xl text-red-500"></i>
                </div>
                
                <h2 class="text-2xl font-bold text-white mb-2">¡Enlace No Disponible!</h2>
                
                <div class="bg-white/10 rounded-xl p-4 mb-8 border border-white/10">
                    <p class="text-white text-lg leading-relaxed font-medium">
                        {{ $message ?? 'Lo sentimos, este enlace de invitación ya no es válido.' }}
                    </p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="block w-full items-center px-4 py-3 bg-greenLime_50 border border-transparent rounded-full font-bold text-md text-greenLime_500 uppercase tracking-widest hover:bg-white focus:bg-white active:bg-greenLime_100 transition transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i> Ir al Inicio
                    </a>
                </div>
                
                <div class="mt-8 pt-6 border-t border-white/20">
                    <p class="text-white/80 text-sm mb-2">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center text-white font-bold hover:text-gray-200 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
        
        <div class="w-full max-w-md mt-8 flex items-center justify-center">
             <span class="text-white font-medium mr-3">Síguenos en:</span>
            <a href="https://www.youtube.com/@Educapp_Oficial" target="_blank" class="text-white mx-2 text-3xl hover:scale-110 transition"><i class="fab fa-youtube"></i></a>
            <a href="https://www.instagram.com/educapp_oficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="text-white mx-2 text-3xl hover:scale-110 transition"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</x-guest-layout>
