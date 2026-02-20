<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="text-gray-500 text-3xl font-bold">Detalle del pedido</h1>
        <div class="bg-white shadow-lg rounded overflow-hidden text-gray-600">
            <div class="px-6 py-4">
                <article class="flex items-center">
                    <img class="h-12 w-12 object-cover" src="{{"data:image/image;base64," . base64_encode(Storage::get($course->image->url));}}" alt="">
                    <h1 class="text-lg ml-2">{{$course->nombre}}</h1>
                    <p class="text-xl font-bold ml-auto">$ {{number_format($course->precio->valor,0,",",".")}} COP</p>
                </article>

                <div class="flex justify-end mt-2 mb-4">
                    <a href="" class="font-bold py-2 px-4 rounded bg-blue-700 text-white">Comprar este curso</a>
                </div>
                <hr>
                <p class="text-sm mt-4"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aut repudiandae blanditiis repellendus ut illo, asperiores labore, quod explicabo dolor quidem temporibus assumenda molestias, dicta maiores cupiditate reiciendis vitae. Praesentium, sint!<a class="text-red-500 font-bold" href=""> Terminos y condiciones </p>
            </div>

        </div>
    </div>
</x-app-layout>
