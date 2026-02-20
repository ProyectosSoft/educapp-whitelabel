<x-admin-layout>
    <div class="container mx-auto px-6 py-8" x-data="{ openCreateModal: false, openEditModal: false, editAction: '', editName: '', editCategoryId: '', editPublic: false }">
        
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-tags text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                        <span class="tracking-tight">Mis Subcategorías</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10">Gestiona las subcategorías para: <span class="font-bold text-primary-600">{{ $empresa->nombre }}</span></p>
                </div>
                 <button @click="openCreateModal = true" type="button" class="px-5 py-2.5 bg-secondary text-primary-900 font-bold rounded-xl hover:bg-secondary-400 transition-all shadow-lg shadow-secondary/20 flex items-center transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i> Nueva Subcategoría
                </button>
            </div>

            {{-- Content --}}
            <div class="p-8 relative z-10">
                
                @if($subcategorias->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre</th>
                                <th scope="col" class="px-6 py-3">Categoría Padre</th>
                                <th scope="col" class="px-6 py-3">Visibilidad</th>
                                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategorias as $subcategoria)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $subcategoria->nombre }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($subcategoria->Categoria)
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                {{ $subcategoria->Categoria->nombre }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">Sin Categoría</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($subcategoria->es_publica)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Pública</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Privada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <button @click="openEditModal = true; 
                                                        editAction = '{{ route('admin.empresas.subcategorias.update', $subcategoria) }}'; 
                                                        editName = '{{ $subcategoria->nombre }}';
                                                        editCategoryId = '{{ $subcategoria->categoria_id }}';
                                                        editPublic = {{ $subcategoria->es_publica ? 'true' : 'false' }};" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.empresas.subcategorias.destroy', $subcategoria) }}" method="POST" class="inline-block delete-form" onsubmit="return confirm('¿Estás seguro?');">
                                            @csrf @method('delete')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                {{-- Placeholder / Content Area when empty --}}
                 <div class="flex flex-col items-center justify-center py-12 px-4 text-center rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-dashed border-gray-200 dark:border-gray-600">
                    <div class="bg-primary-50 dark:bg-primary-900/30 p-4 rounded-full mb-4">
                        <i class="fas fa-tags text-4xl text-primary-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No tienes subcategorías creadas</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-6">
                        Crea subcategorías para organizar mejor los temas dentro de tus categorías.
                    </p>
                    <button @click="openCreateModal = true" class="px-5 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary/30">
                        <i class="fas fa-plus mr-2"></i> Crear Subcategoría
                    </button>
                </div>
                @endif
            </div>

            {{-- Create Modal --}}
            <div x-show="openCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="openCreateModal" @click="openCreateModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div x-show="openCreateModal" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <form action="{{ route('admin.empresas.subcategorias.store') }}" method="POST">
                            @csrf
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Nueva Subcategoría</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                                        <input type="text" name="nombre" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Categoría Padre</label>
                                        <select name="categoria_id" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition">
                                            <option value="">Selecciona una categoría</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <input type="checkbox" name="es_publica" value="1" id="create_public" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <label for="create_public" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                            Hacer pública
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-600">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm shadow-lg shadow-primary/30">Guardar</button>
                                <button @click="openCreateModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Edit Modal --}}
             <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="openEditModal" @click="openEditModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div x-show="openEditModal" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                        <form :action="editAction" method="POST">
                            @csrf @method('PUT')
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Editar Subcategoría</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                                        <input type="text" name="nombre" x-model="editName" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition">
                                    </div>
                                     <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Categoría Padre</label>
                                        <select name="categoria_id" x-model="editCategoryId" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-200 transition">
                                            @foreach($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <input type="checkbox" name="es_publica" value="1" id="edit_public" x-model="editPublic" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <label for="edit_public" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                            Hacer pública
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100 dark:border-gray-600">
                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm shadow-lg shadow-primary/30">Actualizar</button>
                                <button @click="openEditModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
