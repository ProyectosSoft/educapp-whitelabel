@php
    $links = [
        //         [
        //       'icon'=>'fa fa-leanpub',
        //       'name'=> 'Cursos',
        //       'route'=> route('afiliados.cursos') ,
        //       'active'=> request()->routeIs('afiliados.cursos')
        // ]
        // ,
        [
            'icon' => 'fa-solid fa-gauge',
            'name' => 'Dashboard',
            'route' => route('afiliados.dashboard'),
            'active' => request()->routeIs('afiliados.dashboard'),
        ],
        [
            'icon' => 'fa-solid fa-chart-pie',
            'name' => 'Financiero',
            'route' => route('afiliados.financiero'),
            'active' => request()->routeIs('afiliados.financiero'),
        ],
    ];
@endphp
{{-- <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'translate-x-0 ease-out': sidebarOpen,
            '-translate-x-full ease-in': !sidebarOpen
        }"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                @foreach ($links as $link)
                    <li>
                        <a href="{{$link['route']}}"
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-100' : ''}}">
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i class="fas {{$link['icon']}}"></i>
                            </span>
                            <span class="ml-3">{{$link['name']}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside> --}}
<!-- drawer component -->
<div id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800 mt-20"
    tabindex="-1" aria-labelledby="drawer-navigation-label"
    :class="{
        'translate-x-0 ease-out': sidebarOpen,
        '-translate-x-full ease-in': !sidebarOpen
    }">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
    <button x-on:click="sidebarOpen = !sidebarOpen" type="button" data-drawer-hide="drawer-navigation"
        aria-controls="drawer-navigation"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
            @endforeach
        </ul>
        
        <!-- Bottom Section -->
        <div class="mt-auto pt-6 px-2">
             <div class="flex flex-col items-center justify-center p-3 bg-gray-50/80 dark:bg-gray-700/50 rounded-2xl border border-gray-200 dark:border-gray-600 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-700 hover:shadow-md">
                 <div class="flex items-center space-x-2 text-primary-900 dark:text-gray-300 text-xs font-bold select-none mb-1.5">
                    <i class="fas fa-handshake text-secondary text-base"></i>
                    <span>Panel Afiliado</span>
                 </div>
                 <div class="text-[10px] text-gray-500 dark:text-gray-400 text-center uppercase tracking-wider font-extrabold">
                    &copy; {{ date('Y') }} Academia Effi
                 </div>
             </div>
        </div>
    </div>
</div>
