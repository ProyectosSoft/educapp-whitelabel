<div>
    <div class=" py-4 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex">
            <button class="bg-greenLime_500  shadow h-12 px-4 rounded-3xl text-greenLime_50 mr-4" wire:click="resetFilters">
                <i class="fas fa-archway text-xs mr-2"></i>
                Todos los cursos
            </button>
            <!-- Dropdown Categoria -->
            <div class="relative mr-4" x-data="{ open: false }">
                <button class="px-4 text-greenLime_50 block h-12  rounded-3xl overflow-hidden focus:outline-none bg-greenLime_500 shadow" x-on:click="open=true">
                    <i class="fas fa-tags text-sm mr-2"></i>
                    Categoria
                    <i class="fas fa-angle-down text-sm ml-2"></i>
                </button>
                <!-- Dropdown Body -->
                <div class="absolute right-0 w-40 mt-2 py-2 bg-greenLime_500 border rounded-3xl shadow-xl"  x-show="open" x-on:click.away="open = false">
                    @foreach ($categorias as $categoria )
                        <a class="cursor-pointer transition-colors duration-200 block px-4 py-2 text-normal text-white rounded hover:bg-greenLime_400 hover:text-greenLime_50 hover:rounded-3xl" wire:click="$set('categoria_id',{{$categoria->id}})" x-on:click="open = false">{{$categoria->nombre}}</a>
                    @endforeach

                </div>
            <!-- // Dropdown Body -->
            </div>
            <!-- // Dropdown Categoria-->

             <!-- Dropdown Nivel -->
             <div class="relative mr-4" x-data="{ open: false }">
                <button class="px-4 text-greenLime_50 block h-12  rounded-3xl overflow-hidden focus:outline-none bg-greenLime_500 shadow" x-on:click="open=true">
                    <i class="fas fa-tags text-sm mr-2"></i>
                     Nivel
                    <i class="fas fa-angle-down text-sm ml-2"></i>
                </button>
                <!-- Dropdown Body -->
                <div class="absolute right-0 w-40 mt-2 py-2 bg-greenLime_500 border rounded-3xl shadow-xl"  x-show="open" x-on:click.away="open = false">
                    @foreach ($niveles as $nivel )
                        <a class="cursor-pointer transition-colors duration-200 block px-4 py-2 text-normal text-white rounded hover:bg-greenLime_400 hover:text-greenLime_50 hover:rounded-3xl"  wire:click="$set('nivel_id',{{$nivel->id}})" x-on:click="open = false">{{$nivel->nombre}}</a>
                    @endforeach
                </div>
            <!-- // Dropdown Body -->
            </div>
            <!-- // Dropdown Nivel-->
        </div>
    </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid sm:grid-cols-2  lg:grid-cols-3 gap-x-6 gap-y-8">
            @foreach ($courses as $course)
                <x-course-card :course="$course"/>
            @endforeach
        </div>

</div>
