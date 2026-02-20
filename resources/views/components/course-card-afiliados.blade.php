@props(['course'])

<article class="bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col h-full overflow-hidden group">
    <div class="relative overflow-hidden h-52">
        @isset($course->image)
            <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" 
                 src="{{ Storage::url($course->image->url) }}" alt="{{ $course->nombre }}">
        @else
            <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" 
                 src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Curso por defecto">
        @endisset
        
        {{-- Category Badge --}}
        <div class="absolute top-4 left-4">
             <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-primary-900 text-xs font-bold rounded-full shadow-sm">
                 {{ $course->categoria->nombre ?? 'General' }}
             </span>
        </div>
    </div>

    <div class="p-6 flex-1 flex flex-col">
        <h3 class="text-xl font-bold text-primary-900 mb-2 line-clamp-2 leading-tight group-hover:text-secondary transition-colors">
            {{ $course->nombre }}
        </h3>
        
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                <i class="fas fa-user text-xs"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Instructor</p>
                <p class="text-sm font-bold text-gray-700">{{ Str::limit($course->teacher->name, 20) }}</p>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex text-yellow-400 text-xs gap-0.5">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $course->rating >= $i ? '' : 'text-gray-200' }}"></i>
                @endfor
                <span class="ml-1 text-gray-400 text-xs">({{ $course->rating }})</span>
            </div>
            
            <div class="flex items-center text-gray-400 text-xs font-medium">
                <i class="fas fa-users mr-1"></i>
                {{ $course->students_count }} Estudiantes
            </div>
        </div>

        <div class="mt-auto space-y-3">
            @if ($course->precio->valor == 0)
                <a href="{{ route('cursos.show', $course) }}" class="block w-full py-3 px-4 bg-gradient-to-r from-secondary to-primary-800 text-white font-bold text-center rounded-xl shadow-lg shadow-primary-900/10 hover:shadow-primary-900/20 hover:-translate-y-0.5 transition-all duration-200">
                    <span class="flex items-center justify-center gap-2">
                        <i class="fas fa-gift"></i> GRATIS
                    </span>
                </a>
            @else
                <a href="{{ route('payment.checkout', $course) }}" class="block w-full py-3 px-4 bg-gradient-to-r from-secondary to-primary-800 text-white font-bold text-center rounded-xl shadow-lg shadow-primary-900/10 hover:shadow-primary-900/20 hover:-translate-y-0.5 transition-all duration-200">
                    <span class="flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart"></i> $ {{ number_format($course->precio->valor, 0, ',', '.') }} COP
                    </span>
                </a>
            @endif
            
            <a href="{{ route('cursos.show', $course) }}" class="block w-full py-3 px-4 bg-white border border-gray-200 text-gray-700 font-bold text-center rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                Ver Detalles
            </a>
        </div>
    </div>
</article>
