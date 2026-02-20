<x-admin-layout>
    {{-- Main Container --}}
    <div class="space-y-8">
        
        {{-- Welcome Header --}}
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8 relative overflow-hidden">
            {{-- Abstract Decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#335A92]/5 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="flex-shrink-0">
                    <div class="bg-[#335A92] p-6 rounded-3xl shadow-lg shadow-blue-900/20 border-4 border-white ring-1 ring-gray-100 transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi Logo" class="h-20 w-auto">
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-[#335A92] mb-3 tracking-tight">
                        Bienvenido al Panel Administrativo
                    </h1>
                    <p class="text-lg text-gray-500 max-w-2xl font-medium">
                        Desde aquí puedes gestionar usuarios, cursos, empresas y toda la configuración de la plataforma <span class="text-[#335A92] font-bold">Academia Effi</span>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Quick Actions Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Card 1: Usuarios --}}
            <a href="{{ route('admin.users.index') }}" class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#335A92] rounded-xl flex items-center justify-center text-white mb-4 shadow-md group-hover:bg-[#284672] transition-colors">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">Gestión de Usuarios</h3>
                    <p class="text-sm text-gray-400 mt-2 font-medium">Administra roles y permisos</p>
                </div>
            </a>

            {{-- Card 2: Cursos --}}
            <a href="{{ route('admin.cursos.index') }}" class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#ECBD2D] rounded-xl flex items-center justify-center text-[#335A92] mb-4 shadow-md group-hover:bg-[#d4aa27] transition-colors">
                        <i class="fas fa-laptop-code text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">Revisión de Cursos</h3>
                    <p class="text-sm text-gray-400 mt-2 font-medium">Aprueba o rechaza contenidos</p>
                </div>
            </a>

            {{-- Card 3: Empresas --}}
            <a href="{{ route('admin.empresas.index') }}" class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#335A92] rounded-xl flex items-center justify-center text-white mb-4 shadow-md group-hover:bg-[#284672] transition-colors">
                        <i class="fas fa-building text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">Empresas Aliadas</h3>
                    <p class="text-sm text-gray-400 mt-2 font-medium">Gestiona corporativos</p>
                </div>
            </a>

            {{-- Card 4: Seguridad --}}
            <a href="{{ route('admin.audits.index') }}" class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-[#335A92] rounded-xl flex items-center justify-center text-white mb-4 shadow-md group-hover:bg-[#284672] transition-colors">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">Log de Auditoría</h3>
                    <p class="text-sm text-gray-400 mt-2 font-medium">Supervisa la actividad</p>
                </div>
            </a>

        </div>

        {{-- Secondary Section --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-[#335A92] rounded-[2rem] shadow-xl p-8 relative overflow-hidden text-white flex flex-col justify-between">
                <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-2">Categorías y Subcategorías</h3>
                    <p class="text-blue-100 mb-6">Organiza el catálogo de cursos para facilitar la búsqueda a los estudiantes.</p>
                    
                    <div class="flex gap-4">
                        <a href="{{ route('admin.categorias.index') }}" class="px-5 py-2.5 bg-white text-[#335A92] font-bold rounded-xl shadow-lg hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-tags mr-2"></i> Categorías
                        </a>
                        <a href="{{ route('admin.subcategorias.index') }}" class="px-5 py-2.5 bg-[#477EB1] text-white font-bold rounded-xl shadow-lg hover:bg-[#3a6ba0] transition flex items-center border border-white/20">
                            <i class="fas fa-layer-group mr-2"></i> Subcategorías
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 flex flex-col justify-center items-center text-center">
                 <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4 text-[#335A92]">
                    <i class="fas fa-chart-pie text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Panel Financiero</h3>
                <p class="text-gray-500 mb-6 max-w-xs">Consulta las ventas, comisiones y movimientos financieros de la plataforma.</p>
                <a href="{{ route('admin.financiero') }}" class="w-full max-w-xs px-6 py-3 bg-[#ECBD2D] text-[#335A92] font-bold rounded-xl hover:bg-[#d4aa27] transition shadow-lg shadow-yellow-500/20">
                    <i class="fas fa-coins mr-2"></i> Ir a Finanzas
                </a>
            </div>
        </div>

    </div>
</x-admin-layout>
