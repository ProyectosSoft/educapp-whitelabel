<x-app-layout>
    <div class="max-w-7xl mx-auto  px-4 sm:px-6 lg:px-8 py-8">
        <ul>
            @forelse ($courses as $course )
               <x-curso-list :course="$course" />
            @empty
                <li class="bg-white rounded-lg shadow-2xl">
                    <div class="p-4">
                        <p class="text-gray-700 text-base"> No existe ningún curso con los parametros de búsqueda ingresados</p>
                    </div>
                </li>
            @endforelse
       </ul>
       <div class="mt-4">
           {{$courses->links()}}
    </div>

</x-app-layout>
