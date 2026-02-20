<div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white shadow-lg overflow-hidden rounded-3xl imagen2">
            <h1 class="text-greenLime_500 text-3xl font-bold mb-4 flex justify-center mt-6">
                <div class="text-orange-400 mr-6">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                Seleccionar Perfil
                <div class="text-orange-400 ml-6">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </h1>
            <p class="text-lg m-4 text-greenLime_400 text-center">Seleccione el perfil con el cual desea ingresar a la
                aplicación.</p>
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 m-4">
                    @foreach ($roles as $role)
                        <div
                            class="relative flex flex-col items-center backdrop-filter text-gray-500 rounded-3xl p-4 shadow-lg   border-greenLime_400 border-2">
                            <div
                                class="w-24 h-24 rounded-full bg-white flex justify-center items-center mb-2 border-greenLime_400 border-2">
                                <!-- Aquí puedes colocar un icono o imagen para representar el rol -->
                                <i class="fas fa-user fa-3x"></i> <!-- Por ejemplo, un icono de usuario -->
                            </div>
                            <h2 class="text-lg text-greenLime_500 font-semibold mb-2">
                                {{ $role->name }}</h2>
                            {{-- <a href="#" class="px-3 py-1 bg-greenLime_500 rounded  text-white">
                                Seleccionar
                            </a> --}}
                            <button
                                class="font-bold py-2 px-4 rounded-full bg-greenLime_400 text-greenLime_50 hover:bg-greenLime_500 mt-4 block text-center"
                                wire:click="selectProfile({{ auth()->user()->id }},{{ $role->id }})">
                                Seleccionar
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            <br />
        </div>
    </div>
</div>
