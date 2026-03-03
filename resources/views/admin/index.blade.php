<x-admin-layout>
    {{-- Main Container --}}
    <div class="space-y-10">
        
        {{-- Welcome Header --}}
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/40 border border-gray-100 p-8 md:p-12 relative overflow-hidden group">
            {{-- Abstract Decoration --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-100/50 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-50/50 rounded-full blur-3xl transform -translate-x-1/3 translate-y-1/3 pointer-events-none transition-transform duration-700 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10 text-center md:text-left">
                <div class="flex-shrink-0">
                    <div class="bg-gradient-to-br from-primary-600 to-primary-900 p-8 rounded-[2rem] shadow-2xl shadow-primary-900/30 border-4 border-white ring-1 ring-gray-100 transform hover:scale-105 hover:rotate-2 transition-all duration-300">
                        <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi Logo" class="h-20 md:h-24 w-auto drop-shadow-md">
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary-900 to-primary-600 mb-4 tracking-tight">
                        Bienvenido al Panel Administrativo
                    </h1>
                    <p class="text-xl text-gray-500 max-w-2xl font-medium leading-relaxed">
                        Desde aquí puedes gestionar usuarios, cursos, empresas y toda la configuración de la plataforma <span class="text-primary-800 font-bold bg-primary-50 px-2 py-0.5 rounded-md">Academia Effi</span>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Quick Actions Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Usuarios --}}
            <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-3xl p-7 shadow-lg shadow-gray-200/40 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-primary-50 rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-125"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-primary-900/20 group-hover:from-primary-700 group-hover:to-primary-900 transition-all transform group-hover:-rotate-3 group-hover:scale-110">
                        <i class="fas fa-users text-2xl drop-shadow-md"></i>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-primary-800 transition-colors">Gestión de Usuarios</h3>
                        <p class="text-sm text-gray-400 mt-2 font-medium">Administra roles y permisos</p>
                    </div>
                </div>
            </a>

            {{-- Card 2: Cursos --}}
            <a href="{{ route('admin.cursos.index') }}" class="group bg-white rounded-3xl p-7 shadow-lg shadow-gray-200/40 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-accent-50 rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-125"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-400 to-accent-500 rounded-2xl flex items-center justify-center text-primary-900 mb-6 shadow-lg shadow-accent-500/20 group-hover:from-accent-500 group-hover:to-accent-600 transition-all transform group-hover:rotate-3 group-hover:scale-110">
                        <i class="fas fa-laptop-code text-2xl drop-shadow-sm"></i>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-primary-800 transition-colors">Revisión de Cursos</h3>
                        <p class="text-sm text-gray-400 mt-2 font-medium">Aprueba o rechaza contenidos</p>
                    </div>
                </div>
            </a>

            {{-- Card 3: Empresas --}}
            <a href="{{ route('admin.empresas.index') }}" class="group bg-white rounded-3xl p-7 shadow-lg shadow-gray-200/40 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-secondary-50 rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-125"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 bg-gradient-to-br from-secondary-500 to-secondary-700 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-secondary-500/20 group-hover:from-secondary-600 group-hover:to-secondary-800 transition-all transform group-hover:-rotate-3 group-hover:scale-110">
                        <i class="fas fa-building text-2xl drop-shadow-md"></i>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-primary-800 transition-colors">Empresas Aliadas</h3>
                        <p class="text-sm text-gray-400 mt-2 font-medium">Gestiona corporativos</p>
                    </div>
                </div>
            </a>

            {{-- Card 4: Seguridad --}}
            <a href="{{ route('admin.audits.index') }}" class="group bg-white rounded-3xl p-7 shadow-lg shadow-gray-200/40 border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform duration-500 group-hover:scale-125"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/20 group-hover:from-emerald-600 group-hover:to-emerald-800 transition-all transform group-hover:rotate-3 group-hover:scale-110">
                        <i class="fas fa-shield-alt text-2xl drop-shadow-md"></i>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-primary-800 transition-colors">Log de Auditoría</h3>
                        <p class="text-sm text-gray-400 mt-2 font-medium">Supervisa la actividad</p>
                    </div>
                </div>
            </a>

        </div>

        {{-- Secondary Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-primary-800 to-primary-950 rounded-[2.5rem] shadow-2xl shadow-primary-900/30 p-8 md:p-12 relative overflow-hidden text-white flex flex-col justify-between group transform transition-all hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 group-hover:bg-white/10 transition-colors duration-700"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-secondary-400/20 rounded-full blur-2xl transform -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/10 text-white mb-8 backdrop-blur-md border border-white/20 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-layer-group text-2xl drop-shadow-md"></i>
                    </div>
                    <h3 class="text-3xl font-extrabold mb-4 tracking-tight">Categorías y Subcategorías</h3>
                    <p class="text-primary-100/90 mb-10 text-lg md:text-xl font-medium max-w-md leading-relaxed">
                        Organiza el catálogo de cursos para facilitar la búsqueda a los estudiantes en un entorno jerárquico.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.categorias.index') }}" class="px-7 py-3.5 bg-white text-primary-900 font-bold rounded-xl shadow-lg hover:shadow-white/30 hover:-translate-y-1 transition-all flex items-center btn-animate">
                            <i class="fas fa-tags mr-3"></i> Categorías
                        </a>
                        <a href="{{ route('admin.subcategorias.index') }}" class="px-7 py-3.5 bg-white/10 backdrop-blur-md text-white font-bold rounded-xl shadow-lg hover:bg-white/20 hover:-translate-y-1 transition-all flex items-center border border-white/20 hover:border-white/50 btn-animate">
                            <i class="fas fa-project-diagram mr-3"></i> Subcategorías
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8 md:p-12 flex flex-col justify-center items-center text-center relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute -top-32 -right-32 w-80 h-80 bg-accent-50/80 rounded-full blur-3xl opacity-60 pointer-events-none group-hover:bg-accent-100/60 transition-colors duration-700"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                
                <div class="w-24 h-24 bg-gradient-to-br from-accent-100 to-accent-200 rounded-3xl flex items-center justify-center mb-8 text-accent-600 shadow-inner relative group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 ring-4 ring-white">
                    <i class="fas fa-chart-pie text-5xl drop-shadow-sm relative z-10"></i>
                </div>
                
                <h3 class="text-3xl font-extrabold text-gray-800 mb-4 tracking-tight group-hover:text-primary-900 transition-colors">Panel Financiero</h3>
                <p class="text-gray-500 mb-10 max-w-sm text-lg font-medium leading-relaxed">
                    Consulta las ventas, comisiones y movimientos financieros detallados de toda la plataforma a un clic.
                </p>
                <a href="{{ route('admin.financiero') }}" class="w-full max-w-sm px-8 py-4 bg-gradient-to-r from-accent-400 to-accent-500 text-primary-950 font-extrabold text-lg rounded-2xl hover:from-accent-400 hover:to-accent-600 hover:shadow-xl hover:shadow-accent-500/40 transition-all flex justify-center items-center transform hover:-translate-y-1 tracking-wide">
                    <i class="fas fa-coins mr-3 text-xl drop-shadow-sm"></i> Ir al Flujo Financiero
                </a>
            </div>
        </div>

    </div>
</x-admin-layout>
