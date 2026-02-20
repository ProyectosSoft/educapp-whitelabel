@props(['categoria'])
<div class="grid grid-cols-4 p-4">
    <div>
        <p class="text-lg font-bold text-center text-greenLime_50 mb-3"> Subcategorías </p>
        <ul>
            @foreach ($categoria->subcategorias as $subcategoria )
                <li>
                    <a href="" class="text-greenLime_50 font-semibold py-1 px-4  inline-block hover:text-white">
                        {{$subcategoria->nombre}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="col-span-3">
            @if($categoria->image && Storage::exists($categoria->image))
                <img src="{{ 'data:image/image;base64,' . base64_encode(Storage::get($categoria->image)) }}" alt="{{ $categoria->nombre }}" class="h-64 h-full object-cover object-center w-full rounded-3xl">
            @else
                <div class="h-64 w-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center rounded-3xl">
                    <i class="fas fa-layer-group text-6xl text-white/20"></i>
                </div>
            @endif
    </div>
</div>
