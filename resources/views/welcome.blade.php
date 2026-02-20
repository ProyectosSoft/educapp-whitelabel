<x-app-layout>
    {{-- Hero Section (Modern & Clean) --}}
    <section class="relative bg-white overflow-hidden">
        {{-- Background Abstract Shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-secondary/10 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[600px] h-[600px] bg-accent/10 rounded-full blur-[80px] opacity-40 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-40 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Text Content --}}
                <div class="space-y-8 animate-fade-in-up">
                    {{-- Logo Academia Effi --}}
                    <div class="mb-8 bg-gradient-to-r from-secondary via-primary-700 to-primary-900 rounded-3xl p-8 shadow-xl inline-block transform hover:scale-105 transition-transform duration-300">
                         <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" class="h-32 w-auto object-contain" alt="Academia Effi ERP">
                    </div>

                    <div class="inline-flex items-center space-x-2 bg-primary-50 border border-primary-100 rounded-full px-4 py-1.5">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                        </span>
                        <span class="text-xs font-bold text-primary-800 tracking-wide uppercase">Universidad Corporativa v2.0</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-bold tracking-tight text-primary-900 leading-[1.1]">
                        Potencia tu <br/>
                        <span class="relative inline-block">
                            <span class="relative z-10">Talento</span>
                            <div class="absolute bottom-2 left-0 w-full h-3 bg-accent/40 -rotate-2 -z-0 rounded-sm"></div>
                        </span>
                        y Habilidades
                    </h1>
                    
                    <p class="text-xl text-gray-500 max-w-lg leading-relaxed font-medium">
                        Accede a las capacitaciones de tus procesos internos, normativas y actividades clave para tu rol en la empresa.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('cursos.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-primary-900 text-white font-bold rounded-full hover:bg-primary-800 transition-all shadow-xl shadow-primary-900/20 hover:scale-105 active:scale-95">
                            Ver Plan de Carrera <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        @guest
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary-900 border-2 border-primary-50 font-bold rounded-full hover:bg-primary-50 transition-all hover:scale-105">
                            Ingresar al Portal
                        </a>
                        @endguest
                    </div>

                    <div class="border-t border-gray-100 pt-8 mt-8">
                        <p class="text-sm text-gray-400 font-semibold mb-4 uppercase tracking-wider">Pilares de nuestra cultura</p>
                        <div class="flex flex-wrap gap-8 opacity-70 grayscale-0 transition-all duration-500">
                             <div class="flex items-center space-x-2 group cursor-default">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600"><i class="fas fa-lightbulb"></i></div>
                                <span class="font-bold text-gray-400 group-hover:text-primary-800 transition-colors">Innovación</span>
                             </div>
                             <div class="flex items-center space-x-2 group cursor-default">
                                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600"><i class="fas fa-hand-holding-heart"></i></div>
                                <span class="font-bold text-gray-400 group-hover:text-primary-800 transition-colors">Integridad</span>
                             </div>
                             <div class="flex items-center space-x-2 group cursor-default">
                                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600"><i class="fas fa-rocket"></i></div>
                                <span class="font-bold text-gray-400 group-hover:text-primary-800 transition-colors">Excelencia</span>
                             </div>
                        </div>
                    </div>
                </div>

                {{-- Image/Visual Content --}}
                {{-- Image/Visual Content (Dynamic Slider) --}}
                <div class="relative lg:h-[650px] flex items-center justify-center"
                     x-data="{
                        active: 0,
                        slides: [
                            {
                                img: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                                badge: { icon: 'fas fa-certificate', color: 'text-yellow-600', bg: 'bg-accent/20', label: 'Validación', text: 'Competencia Aprobada' },
                                card: { label: 'Estado', title: 'Inducción Completada', icon: 'fas fa-check-circle', iconBg: 'bg-green-100', iconColor: 'text-green-600', progress: 100, barColor: 'bg-green-500' }
                            },
                            {
                                img: 'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                                badge: { icon: 'fas fa-star', color: 'text-blue-600', bg: 'bg-blue-100', label: 'Nivel', text: 'Liderazgo Avanzado' },
                                card: { label: 'En Progreso', title: 'Gestión de Equipos', icon: 'fas fa-chart-line', iconBg: 'bg-blue-100', iconColor: 'text-blue-600', progress: 75, barColor: 'bg-blue-500' }
                            },
                            {
                                img: 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                                badge: { icon: 'fas fa-award', color: 'text-purple-600', bg: 'bg-purple-100', label: 'Logro', text: 'Curso Certificado' },
                                card: { label: 'Reciente', title: 'Seguridad Industrial', icon: 'fas fa-shield-alt', iconBg: 'bg-purple-100', iconColor: 'text-purple-600', progress: 100, barColor: 'bg-purple-500' }
                            }
                        ],
                        init() { setInterval(() => { this.active = (this.active + 1) % this.slides.length; }, 5000); }
                     }">
                    {{-- Abstract Backdrop Blob --}}
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 w-full h-full text-secondary/5 -z-10 animate-blob">
                        <path fill="currentColor" d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,79.6,-46.3C87.4,-33.5,90.1,-17.9,89.4,-2.4C88.7,13,84.7,28.4,76.4,42.5C68.1,56.6,55.4,69.5,41,76.5C26.6,83.5,10.6,84.6,-3.6,80.9C-17.8,77.3,-30.2,68.9,-41.8,59.3C-53.4,49.7,-64.3,38.9,-71.4,26.1C-78.5,13.3,-81.9,-1.5,-79,-15.5C-76,-29.5,-66.8,-42.7,-55.1,-51.7C-43.4,-60.7,-29.2,-65.5,-15.6,-70.7C-2, -75.9, 11.6, -81.5, 25.2, -83.6L30.5,-83.6L44.7,-76.4Z" transform="translate(100 100)" />
                    </svg>

                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="active === index"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-1000"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute inset-0 flex items-center justify-center w-full h-full">
                            
                            {{-- Main Image Container --}}
                            <div class="relative w-full max-w-md lg:max-w-full aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl shadow-primary-900/10 border-[8px] border-white transition-transform duration-1000 ease-out origin-center"
                                 :class="[index === 0 ? '-rotate-3' : (index === 1 ? 'rotate-3' : '-rotate-2')]">
                                 <img :src="slide.img" class="object-cover w-full h-full hover:scale-105 transition duration-1000" alt="Slider Image">
                                 
                                 {{-- Floating UI Element 1 (Card) --}}
                                 <div class="absolute bottom-8 left-8 right-8 bg-white/95 backdrop-blur-md p-6 rounded-2xl shadow-lg border border-white/50">
                                     <div class="flex items-center justify-between mb-4">
                                         <div>
                                             <p class="text-xs text-gray-500 font-bold uppercase tracking-wider" x-text="slide.card.label"></p>
                                             <h3 class="text-xl md:text-2xl font-bold text-primary-900" x-text="slide.card.title"></h3>
                                         </div>
                                         <div class="h-10 w-10 rounded-full flex items-center justify-center shadow-inner" :class="[slide.card.iconBg, slide.card.iconColor]">
                                             <i :class="slide.card.icon"></i>
                                         </div>
                                     </div>
                                     <div class="w-full bg-gray-100 rounded-full h-2">
                                         <div class="h-2 rounded-full w-full transition-all duration-1000 ease-out" :class="slide.card.barColor" :style="`max-width: ${slide.card.progress}%`"></div>
                                     </div>
                                 </div>
                            </div>
        
                            {{-- Floating Badge (Badge) --}}
                            <div class="absolute top-10 -right-4 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce-slow border border-gray-50 z-20">
                                <div class="p-3 rounded-xl shadow-inner" :class="slide.badge.bg">
                                    <i class="text-xl" :class="[slide.badge.icon, slide.badge.color]"></i>
                                 </div>
                                 <div>
                                     <p class="text-xs text-gray-400 font-bold" x-text="slide.badge.label"></p>
                                     <p class="font-bold text-primary-900" x-text="slide.badge.text"></p>
                                 </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats/Trust Section (Modern Floating Bar) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 z-20 relative">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-8 grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-50 border border-gray-100">
            <div class="flex flex-col items-center justify-center text-center p-2">
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-secondary mb-3">
                    <i class="fas fa-clipboard-check text-2xl"></i>
                </div>
                <span class="text-lg font-bold text-primary-900 mb-1">Procesos</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Estandarizados</span>
            </div>
            <div class="flex flex-col items-center justify-center text-center p-2">
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-secondary mb-3">
                    <i class="fas fa-users-cog text-2xl"></i>
                </div>
                <span class="text-lg font-bold text-primary-900 mb-1">Evaluación</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">De Roles</span>
            </div>
            <div class="flex flex-col items-center justify-center text-center p-2">
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-secondary mb-3">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <span class="text-lg font-bold text-primary-900 mb-1">Formación</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Continua</span>
            </div>
            <div class="flex flex-col items-center justify-center text-center p-2">
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-secondary mb-3">
                    <i class="fas fa-people-arrows text-2xl"></i>
                </div>
                <span class="text-lg font-bold text-primary-900 mb-1">Cultura</span>
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Corporativa</span>
            </div>
        </div>
    </section>

    {{-- Categories Section (Clean & Minimal) --}}
    <section class="py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-16 px-4">
                <div class="text-left">
                    <span class="text-secondary font-bold text-sm uppercase tracking-widest">Navegación</span>
                    <h2 class="text-4xl font-bold text-primary-900 mt-2">Áreas de Conocimiento</h2>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('cursos.index') }}" class="text-primary-600 font-bold hover:text-primary-900 transition flex items-center group">
                        Ver todas las áreas <i class="fas fa-arrow-right ml-2 bg-primary-100 p-2 rounded-full group-hover:bg-primary-200 transition"></i>
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($categorias as $item)
                    <a href="{{ route('cursos.index') . '?category=' . $item->id }}" class="group relative bg-white rounded-[2rem] p-8 hover:shadow-2xl hover:shadow-secondary/10 transition-all duration-500 ease-out border border-gray-100 hover:-translate-y-2 overflow-hidden">
                        {{-- Background Decoration --}}
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10 flex flex-col h-full items-start">
                            <div class="w-16 h-16 rounded-2xl bg-primary-50 flex items-center justify-center text-secondary text-2xl mb-6 group-hover:bg-secondary group-hover:text-white transition-colors duration-300 shadow-sm">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            
                            <h3 class="text-xl font-bold text-primary-900 mb-2 group-hover:text-secondary transition-colors">{{ $item->nombre }}</h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed">Explora los módulos y recursos disponibles en esta área especializada.</p>
                            
                            <span class="mt-auto text-sm font-bold text-primary-400 group-hover:text-primary-800 transition flex items-center">
                                Explorar <i class="fas fa-chevron-right ml-1 text-xs transition-transform group-hover:translate-x-1"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Key Training Section (Content Focused) --}}
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="absolute left-0 top-1/4 w-full h-1/2 bg-gradient-to-r from-gray-50 to-transparent -skew-y-3 -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="inline-block py-1 px-3 rounded-full bg-accent/10 text-accent-600 text-xs font-bold uppercase tracking-widest mb-4">Obligatorio</span>
                <h2 class="text-4xl md:text-5xl font-bold text-primary-900 mb-6">Formación Prioritaria</h2>
                <p class="text-xl text-gray-500 leading-relaxed">Estos cursos han sido seleccionados como esenciales para tu rol y desarrollo dentro de la compañía.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach ($courses as $course)
                    <div class="group bg-white rounded-[2.5rem] p-4 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-primary-900/5 transition-all duration-500 hover:-translate-y-2 border border-gray-100 flex flex-col items-start cursor-pointer">
                        {{-- Image Wrapper --}}
                        <div class="w-full h-56 rounded-[2rem] overflow-hidden relative mb-6">
                            <img src="{{ Storage::url($course->image->url) }}" alt="{{ $course->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                             <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition duration-500"></div>
                             
                             <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary-900 shadow-sm border border-white/50">
                                 {{ $course->categoria->name ?? 'General' }}
                             </div>
                        </div>

                        <div class="px-2 w-full flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">Interno</span>
                                <div class="flex text-yellow-400 text-xs">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>

                            <a href="{{ route('cursos.show', $course) }}" class="block">
                                <h3 class="text-2xl font-bold text-primary-900 mb-3 leading-tight group-hover:text-secondary transition-colors">{{ Str::limit($course->title, 40) }}</h3>
                            </a>
                            
                            {{-- Instructor Row --}}
                            <div class="flex items-center gap-3 mt-auto pt-6 border-t border-gray-50 w-full">
                                <img src="{{ $course->teacher->profile_photo_url }}" alt="" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                                <div>
                                    <p class="text-sm font-bold text-primary-900">{{ $course->teacher->name }}</p>
                                    <p class="text-xs text-gray-400">Instructor Senior</p>
                                </div>
                                <a href="{{ route('cursos.show', $course) }}" class="ml-auto w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-primary-900 group-hover:bg-primary-900 group-hover:text-white transition-colors shadow-sm">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Modern CTA Section --}}
    <section class="py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-primary-900 rounded-[3rem] p-12 md:p-24 relative overflow-hidden text-center shadow-2xl shadow-primary-900/30">
                {{-- Abstract shapes within container --}}
                <div class="absolute top-0 right-0 w-96 h-96 bg-secondary opacity-20 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent opacity-20 rounded-full blur-[80px] translate-y-1/2 -translate-x-1/2"></div>
                
                {{-- Pattern --}}
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>

                <div class="relative z-10 max-w-3xl mx-auto">
                    <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight">Tu Crecimiento <br/> no tiene límites.</h2>
                    <p class="text-xl text-primary-100 mb-12 font-medium">Accede a una biblioteca en constante expansión diseñada para potenciar tu carrera profesional.</p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="{{ route('login') }}" class="px-10 py-5 bg-accent text-primary-900 font-bold text-lg rounded-full hover:bg-white hover:text-primary-900 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                            Acceder al Portal
                        </a>
                        <a href="#" class="px-10 py-5 bg-white/10 text-white border border-white/20 font-bold text-lg rounded-full hover:bg-white/20 transition-all backdrop-blur-sm">
                            Soporte Técnico
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>

@push('script')
    <script>
        // Scripts placeholder
    </script>
@endpush
