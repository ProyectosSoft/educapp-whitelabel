<div class="fixed inset-0 bg-slate-900 bg-opacity-30 z-40 lg:hidden lg:z-auto transition-opacity duration-200" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

<!-- Sidebar -->
<div id="sidebar"
    class="flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-screen overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white border-r border-[#335A92] p-4 transition-all duration-200 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
    @keydown.escape.window="sidebarOpen = false" x-cloak="lg">

    <!-- Sidebar header -->
    <div class="flex justify-between mb-10 pr-3 sm:px-2">
        <!-- Close button -->
        <button class="lg:hidden text-slate-500 hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen" aria-controls="sidebar" :aria-expanded="sidebarOpen">
            <span class="sr-only">Cerrar menú lateral</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 10.6z" />
            </svg>
        </button>
        <!-- Logo -->
        <a class="block mx-auto mt-4" href="{{ route('home') }}">
            <img class="h-12 w-auto" src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Academia Effi">
        </a>
    </div>

    <!-- Links -->
    <div class="space-y-8">
        <!-- Pages group -->
        <div>
            <h3 class="text-xs uppercase text-gray-500 font-bold pl-3 mb-4">
                <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6" aria-hidden="true">•••</span>
                <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Gestión</span>
            </h3>
            <ul class="space-y-2">
                
                <!-- Cursos -->
                <li class="relative px-3 py-3 rounded-xl mb-1 cursor-pointer transition-all duration-200 group {{ request()->routeIs('author.cursos.index') ? 'bg-[#335A92] text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-[#335A92]' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-[#ECBD2D] rounded-r-full transition-all duration-300 {{ request()->routeIs('author.cursos.index') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></div>
                    <a class="block truncate w-full h-full relative z-10" href="{{ route('author.cursos.index') }}">
                        <div class="flex items-center pl-3">
                             <i class="fas fa-layer-group text-lg w-6 text-center transition-colors {{ request()->routeIs('author.cursos.index') ? 'text-[#ECBD2D]' : 'text-slate-400 group-hover:text-[#ECBD2D]' }}"></i>
                            <span class="text-sm font-bold ml-3 flex-1">Mis Cursos</span>
                        </div>
                    </a>
                </li>
                
                <!-- Exámenes -->
                <li class="relative px-3 py-3 rounded-xl mb-1 cursor-pointer transition-all duration-200 group {{ request()->routeIs('author.exams.*') ? 'bg-[#335A92] text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-[#335A92]' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-[#ECBD2D] rounded-r-full transition-all duration-300 {{ request()->routeIs('author.exams.*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></div>
                    <a class="block truncate w-full h-full relative z-10" href="{{ route('author.exams.manager') }}">
                        <div class="flex items-center pl-3">
                             <i class="fas fa-clipboard-list text-lg w-6 text-center transition-colors {{ request()->routeIs('author.exams.*') ? 'text-[#ECBD2D]' : 'text-slate-400 group-hover:text-[#ECBD2D]' }}"></i>
                            <span class="text-sm font-bold ml-3 flex-1">Exámenes</span>
                        </div>
                    </a>
                </li>

                <!-- Calificaciones -->
                 <li class="relative px-3 py-3 rounded-xl mb-1 cursor-pointer transition-all duration-200 group {{ request()->routeIs('author.exams.grader') ? 'bg-[#335A92] text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-[#335A92]' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-[#ECBD2D] rounded-r-full transition-all duration-300 {{ request()->routeIs('author.exams.grader') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></div>
                    <a class="block truncate w-full h-full relative z-10" href="{{ route('author.exams.grader') }}">
                        <div class="flex items-center pl-3">
                            <i class="fas fa-check-double text-lg w-6 text-center transition-colors {{ request()->routeIs('author.exams.grader') ? 'text-[#ECBD2D]' : 'text-slate-400 group-hover:text-[#ECBD2D]' }}"></i>
                            <span class="text-sm font-bold ml-3 flex-1">Calificaciones</span>
                        </div>
                    </a>
                </li>

                 <!-- Financiero -->
                <li class="relative px-3 py-3 rounded-xl mb-1 cursor-pointer transition-all duration-200 group {{ request()->routeIs('author.financiero') ? 'bg-[#335A92] text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-[#335A92]' }}">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-[#ECBD2D] rounded-r-full transition-all duration-300 {{ request()->routeIs('author.financiero') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></div>
                    <a class="block truncate w-full h-full relative z-10" href="{{ route('author.financiero') }}">
                        <div class="flex items-center pl-3">
                             <i class="fas fa-chart-pie text-lg w-6 text-center transition-colors {{ request()->routeIs('author.financiero') ? 'text-[#ECBD2D]' : 'text-slate-400 group-hover:text-[#ECBD2D]' }}"></i>
                            <span class="text-sm font-bold ml-3 flex-1">Finanzas</span>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
