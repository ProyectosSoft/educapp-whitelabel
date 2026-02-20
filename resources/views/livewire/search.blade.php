    <div class="flex-1 relative" x-data>
        <form action="{{route('search')}}" autocomplete="off">
            <input name="name" wire:model="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-3xl text-sm focus:outline-none"
            type="search" name="search" placeholder="¿Estás buscando algún curso?">
            <button class="absolute top-0 right-0 w-12 h-full flex items-center justify-center rounded-r-3xl">
                <x-search size="35" color='secondary'/>
            </button>
        </form>
        @if ($search)
            <ul class="absolute z-50 left-0 w-full bg-white mt-1 rounded-lg overflow-hidden px-4 py-3 space-y-1" :class="{'hidden' : !$wire.open}"  @click.away="$wire.open=false">
                @forelse ( $this->results as $result)
                    <a  href="{{route('cursos.show',$result)}}" class="flex">
                        <img class="h-20 w-20 object-cover rounded-lg" src= "{{"data:image/image;base64," . base64_encode(Storage::get($result->image->url));}}" alt="">
                        <div class="ml-4 text-gray-700">
                            <p class="text-lg font-semibold leading-5"> {{$result->nombre}} </p>
                            <p>Categoria: {{$result->categoria->nombre}} </p>
                            <p>Nivel: {{$result->nivel->nombre}} </p>
                        </div>
                    </a>
                @empty
                    <li class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                        No existe ningún curso con los parametros de búsqueda ingresados
                    </li>
                @endforelse
            </ul>
        @endif
    </div>

