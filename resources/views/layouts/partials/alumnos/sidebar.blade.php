@php
    // $links = [
    //     [
    //         'icon' => 'fa-solid fa-gauge',
    //         'name' => 'Dashboard',
    //         'route' => route('alumnos.dashboard'),
    //         'active' => request()->routeIs('alumnos.dashboard'),
    //     ],
    //     [
    //         'header' => 'Financiero',
    //     ],
    //     [
    //         'icon' => 'fa-solid fa-chart-pie',
    //         'name' => 'Financiero',
    //         'active' => true,
    //         'submenu' => [
    //             [
    //                 'name' => 'Mis compras',
    //                 'icon' => 'fa-regular fa-circle',
    //                 'route' => '',
    //                 'active' => false,
    //             ],
    //             [
    //                 'name' => 'Mis Devoluciones',
    //                 'icon' => 'fa-regular fa-circle',
    //                 'route' => '',
    //                 'active' => false,
    //             ],
    //         ],
    //     ],
    // ];

    $links = [
        [
            'icon' => 'fa-solid fa-gauge',
            'name' => 'Dashboard',
            'route' => route('alumnos.dashboard'),
            'active' => request()->routeIs('alumnos.dashboard'),
        ],
        [
            'icon' => 'fa-solid fa-clipboard-check',
            'name' => 'Mis Evaluaciones',
            'route' => route('student.evaluations.index'),
            'active' => request()->routeIs('student.evaluations.index'),
        ],
        [
            'icon'=>'fa-solid fa-chart-pie',
            'name'=> 'Financiero',
            'route'=> route('alumnos.financiero') ,
            'active'=> request()->routeIs('alumnos.financiero')
        ],

        // [
        //     'icon' => 'fa-solid fa-chart-pie',
        //     'name' => 'Financiero',
        //     'route' => route('alumnos.finaciero'),
        //     'active' => request()->routeIs('alumnos.finaciero'),
        // ],
    ];
@endphp
<div id="drawer-navigation" class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white mt-20" tabindex="-1" aria-labelledby="drawer-navigation-label"
:class="{
   'translate-x-0 ease-out': sidebarOpen,
   '-translate-x-full ease-in': !sidebarOpen
}">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase">Menu</h5>
    <button x-on:click="sidebarOpen = !sidebarOpen" type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center" >
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span  class="sr-only">Close menu</span>
    </button>
  <div class="py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
       @foreach ($links as $link)
       <li>
           <a href="{{$link['route']}}"
               class="flex items-center p-2 text-gray-900 rounded-lg  hover:bg-gray-100 group {{$link['active'] ? 'bg-gray-100' : ''}}">
               <span class="inline-flex w-6 h-6 justify-center items-center">
                   <i class="fas {{$link['icon']}}"></i>
               </span>
               <span class="ml-3">{{$link['name']}}</span>
           </a>
       </li>
       @endforeach

    </ul>
</div>
</div>


