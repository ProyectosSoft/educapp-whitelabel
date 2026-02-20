<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-layer-group text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Crear Subcategoría</h2>
                    <p class="text-blue-100 text-sm font-medium">Nueva clasificación para organizar cursos</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.subcategorias.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                 <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Lista
             </a>
        </div>

        {{-- Form Content --}}
        <div class="p-8 relative z-10">
            {!! Form::open(['route' => 'admin.subcategorias.store', 'class' => 'space-y-8']) !!}
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Nombre --}}
                    <div>
                        {!! Form::label('nombre', 'Nombre de la Subcategoría', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                            </div>
                            {!! Form::text('nombre', null, [
                                'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                'placeholder' => 'Ej: Marketing de Contenidos'
                            ]) !!}
                        </div>
                        @error('nombre')
                            <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Categoría Padre --}}
                    <div>
                        {!! Form::label('categoria_id', 'Categoría Principal', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-folder text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                            </div>
                             {!! Form::select('categoria_id', $categorias, null, [
                                'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 appearance-none',
                                'placeholder' => 'Seleccione una categoría...'
                            ]) !!}
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('categoria_id')
                            <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Estado (Radio Buttons styled as cards) --}}
                <div>
                    {!! Form::label('estado', 'Estado de Publicación', ['class' => 'block font-bold text-sm text-[#335A92] mb-3']) !!}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            {!! Form::radio('estado', 1, true, ['class' => 'peer sr-only']) !!}
                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:ring-1 peer-checked:ring-green-500 transition-all hover:bg-white hover:shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 text-gray-400 peer-checked:text-green-600">
                                        <i class="fas fa-check-circle text-2xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-700 peer-checked:text-green-800">Activo</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">Visible para selección pública</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer">
                            {!! Form::radio('estado', 0, false, ['class' => 'peer sr-only']) !!}
                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50 peer-checked:bg-gray-100 peer-checked:border-gray-500 peer-checked:ring-1 peer-checked:ring-gray-500 transition-all hover:bg-white hover:shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 text-gray-400 peer-checked:text-gray-600">
                                        <i class="fas fa-ban text-2xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <span class="block text-sm font-bold text-gray-700 peer-checked:text-gray-900">Inactivo</span>
                                        <span class="block text-xs text-gray-500 mt-0.5">Oculto temporalmente</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('estado')
                         <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-[#335A92] hover:bg-[#284672] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center text-lg">
                        <i class="fas fa-save mr-2"></i> Crear Subcategoría
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>
