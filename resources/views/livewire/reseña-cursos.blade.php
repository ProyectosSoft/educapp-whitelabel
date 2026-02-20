<section class="mt-4 mb-10">
    <h1 class="font-bold text-3xl mb-2 text-greenLime_400">Valoración</h1>
    @can('matriculado', $course)
        <article class="mb-2">
            @can('valued', $course)
                <textarea wire:model="comment" class="form-input w-full rounded-3xl text-greenLime_400" rows="3"
                    placeholder="Ingrese una reseña del curso"></textarea>
                @error('comment')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <div class="flex">
                    <button class="font-bold py-2 px-4 rounded-full bg-greenLime_500 text-greenLime_50 mr-2"
                        wire:click="store">Guardar</button>
                    <ul class="flex items-center">
                        <li class="mr-1 cursor-pointer" wire:click="$set('rating',1)">
                            <i class="fas fa-star text-{{ $rating >= 1 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                        <li class="mr-1 cursor-pointer" wire:click="$set('rating',2)">
                            <i class="fas fa-star text-{{ $rating >= 2 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                        <li class="mr-1 cursor-pointer" wire:click="$set('rating',3)">
                            <i class="fas fa-star text-{{ $rating >= 3 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                        <li class="mr-1 cursor-pointer" wire:click="$set('rating',4)">
                            <i class="fas fa-star text-{{ $rating >= 4 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                        <li class="mr-1 cursor-pointer" wire:click="$set('rating',5)">
                            <i class="fas fa-star text-{{ $rating == 5 ? 'orange' : 'gray' }}_50"></i>
                        </li>
                    </ul>
                </div>
            @else
                <div class="px-4 py-3 leading-normal text-red-100 bg-blue-700 rounded-lg" role="alert">
                    <p>Ustes ya ha valorado este curso</p>
                </div>
            @endcan
        </article>
    @endcan

    <div class="bg-white shadow-lg rounded-3xl overflow-hidden mt-6">
        <div class="px-6 py-4">
            <p class="text-greenLime_400 text-xl mb-4"> {{ $course->Resena_curso->count() }} Valoraciones </p>
            @foreach ($course->Resena_curso as $resena)
                <article class="flex mb-4">
                    <figure class="flex-shrink-0 mr-4 text-gray-800">
                        <img class="h-12 w-12 rounded-full object-cover shadow-lg"
                            src="{{ $resena->user->profile_photo_url }}" alt="">
                    </figure>
                    <div class="text-greenLime_400 flex-1">
                        <div class="px-6 py-4 bg-gray-100 rounded-3xl">
                            <p><b>{{ $resena->user->name }}</b><i
                                    class="fas fa-star text-orange_50 ml-2 mr-2"></i>({{ $resena->calificacion }})</p>
                            {{ $resena->comentarios }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
