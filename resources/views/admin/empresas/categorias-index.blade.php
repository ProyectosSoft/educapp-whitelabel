<x-admin-layout>
    <div class="px-4 py-8 md:px-8 space-y-8" x-data="{ openCreateModal: false, openEditModal: false, editAction: '', editName: '', editPublic: false }">
        
        {{-- Corporate Header --}}
        <div class="bg-primary rounded-[2rem] shadow-xl shadow-primary/20 flex flex-col sm:flex-row justify-between items-center p-8 relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-secondary/30 rounded-full blur-2xl transform translate-y-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-5">
                <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-md shadow-inner text-[#ECBD2D]">
                    <i class="fas fa-layer-group text-3xl drop-shadow-md"></i>
                </div>
                <div>
                   <h2 class="text-3xl font-extrabold text-white tracking-tight mb-1">Mis Categorías</h2>
                   <p class="text-blue-100 font-medium text-sm">Gestiona y organiza las categorías de cursos exclusivas para: <span class="text-[#ECBD2D] font-bold">{{ $empresa->nombre }}</span></p>
                </div>
            </div>
            
            <button @click="openCreateModal = true" class="relative z-10 mt-6 sm:mt-0 px-6 py-3.5 bg-[#ECBD2D] hover:bg-[#d4a827] text-primary-900 font-bold rounded-xl transition-all shadow-lg hover:shadow-[#ECBD2D]/40 hover:-translate-y-0.5 flex items-center group">
                <i class="fas fa-plus mr-2 transform group-hover:rotate-90 transition-transform duration-300"></i> Nueva Categoría
            </button>
        </div>

        {{-- Main Content --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative z-10">
            
            @if($categorias->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nombre de la Categoría</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Slug</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider">Visibilidad</th>
                            <th class="px-8 py-5 text-xs font-extrabold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($categorias as $categoria)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-xl bg-gray-100 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                                            <i class="fas fa-tag"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-bold text-gray-900 text-sm">{{ $categoria->nombre }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-gray-500 font-medium font-mono">
                                    {{ $categoria->slug }}
                                </td>
                                <td class="px-8 py-5">
                                    @if($categoria->es_publica)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600 border border-green-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></span> Pública
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-2"></span> Privada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button @click="openEditModal = true; 
                                                        editAction = '{{ route('admin.empresas.categorias.update', $categoria) }}'; 
                                                        editName = '{{ $categoria->nombre }}';
                                                        editPublic = {{ $categoria->es_publica ? 'true' : 'false' }};" 
                                                class="w-9 h-9 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500 hover:bg-indigo-500 hover:text-white transition-all shadow-sm tooltip" data-tip="Editar">
                                            <i class="fas fa-pencil-alt text-sm"></i>
                                        </button>
                                        <form action="{{ route('admin.empresas.categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                            @csrf @method('delete')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm tooltip" data-tip="Eliminar">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-24 h-24 bg-primary-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-folder-open text-4xl text-primary-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No tienes categorías creadas</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-8 font-medium">
                    Mantén todo organizado. Crea categorías personalizadas para agrupar los cursos de <span class="font-bold text-gray-700">{{ $empresa->nombre }}</span>.
                </p>
                <button @click="openCreateModal = true" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-600 transition-all shadow-lg shadow-primary/20 flex items-center transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i> Crear Primera Categoría
                </button>
            </div>
            @endif
        </div>

        {{-- Modals Overlay & Styles --}}
        
        {{-- Create Modal --}}
        <div x-show="openCreateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-transition.opacity>
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openCreateModal = false"></div>
            
            {{-- Modal Content --}}
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform overflow-hidden" 
                 x-show="openCreateModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.stop>
                
                <form action="{{ route('admin.empresas.categorias.store') }}" method="POST">
                    @csrf
                    
                    {{-- Header Modal --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-extrabold text-primary flex items-center">
                            <i class="fas fa-plus-circle mr-3 text-secondary"></i>
                            Nueva Categoría
                        </h3>
                        <button type="button" @click="openCreateModal = false" class="text-gray-400 hover:text-gray-600 transition bg-white hover:bg-gray-100 p-2 rounded-lg shadow-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    {{-- Body Modal --}}
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre de la Categoría</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400 group-focus-within:text-primary transition-colors"></i>
                                </div>
                                <input type="text" name="nombre" required placeholder="Ej: Recursos Humanos" 
                                       class="pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-primary focus:ring focus:ring-primary/20 py-3 shadow-sm transition">
                            </div>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-start group hover:bg-white hover:shadow-sm transition-all cursor-pointer" @click="document.getElementById('create_public').click()">
                            <div class="flex items-center h-5">
                                <input id="create_public" type="checkbox" name="es_publica" value="1" class="w-5 h-5 text-primary bg-white border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer transition">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="create_public" class="font-bold text-gray-800 cursor-pointer group-hover:text-primary transition-colors">Visibilidad Pública</label>
                                <p class="text-gray-500 font-medium">Permitir que otras empresas vean y utilicen esta categoría.</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Footer Modal --}}
                    <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="openCreateModal = false" type="button" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:shadow-sm transition-all">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary/20 flex items-center transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-save mr-2"></i> Crear Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-transition.opacity>
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openEditModal = false"></div>
            
            {{-- Modal Content --}}
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform overflow-hidden" 
                 x-show="openEditModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 @click.stop>
                
                <form :action="editAction" method="POST">
                    @csrf @method('PUT')
                    
                    {{-- Header Modal --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-xl font-extrabold text-indigo-800 flex items-center">
                            <i class="fas fa-edit mr-3 text-indigo-500"></i>
                            Editar Categoría
                        </h3>
                        <button type="button" @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 transition bg-white hover:bg-gray-100 p-2 rounded-lg shadow-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    {{-- Body Modal --}}
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nombre de la Categoría</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                                </div>
                                <input type="text" name="nombre" x-model="editName" required 
                                       class="pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 py-3 shadow-sm transition">
                            </div>
                        </div>

                        <div class="p-4 rounded-xl border border-gray-100 bg-gray-50 flex items-start group hover:bg-white hover:shadow-sm transition-all cursor-pointer" @click="document.getElementById('edit_public').click()">
                            <div class="flex items-center h-5">
                                <input id="edit_public" type="checkbox" name="es_publica" value="1" x-model="editPublic" class="w-5 h-5 text-indigo-600 bg-white border-gray-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer transition">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="edit_public" class="font-bold text-gray-800 cursor-pointer group-hover:text-indigo-600 transition-colors">Visibilidad Pública</label>
                                <p class="text-gray-500 font-medium">Permitir que otras empresas vean y utilicen esta categoría.</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Footer Modal --}}
                    <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex justify-end gap-3">
                        <button @click="openEditModal = false" type="button" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:shadow-sm transition-all">
                            Cancelar
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 flex items-center transform hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-sync-alt mr-2"></i> Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
