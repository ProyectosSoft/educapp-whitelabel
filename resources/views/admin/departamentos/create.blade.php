<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
        
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

        <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-plus text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                    <span class="tracking-tight">Crear Nuevo Departamento</span>
                </h2>
                <div class="flex items-center text-xs text-gray-500 mt-1 ml-10">
                    <a href="{{ route('home') }}" class="hover:text-primary-600 transition">Inicio</a>
                    <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                    <a href="{{ route('admin.departamentos.index') }}" class="hover:text-primary-600 transition">Departamentos</a>
                    <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                    <span>Crear</span>
                </div>
            </div>
            
            <a href="{{ route('admin.departamentos.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all shadow-md flex items-center transform hover:scale-105">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>

        <div class="p-8 relative z-10">
            {!! Form::open(['route' => 'admin.departamentos.store', 'enctype' => 'multipart/form-data', 'class' => 'space-y-6']) !!}
                
                {{-- Empresa --}}
                 <div>
                    {!! Form::label('empresa_id', 'Empresa', ['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2']) !!}
                    {!! Form::select('empresa_id', $empresas->pluck('nombre', 'id'), null, [
                        'class' => 'w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                        'placeholder' => 'Seleccione una empresa...'
                    ]) !!}
                    @error('empresa_id') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre Departamento --}}
                    <div>
                        {!! Form::label('nombre', 'Nombre del Departamento', ['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2']) !!}
                        <div class="relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-sitemap text-gray-400"></i>
                            </div>
                            {!! Form::text('nombre', null, [
                                'class' => 'pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                'placeholder' => 'Ej: Recursos Humanos'
                            ]) !!}
                        </div>
                        @error('nombre') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Jefe Nombre --}}
                    <div>
                        {!! Form::label('jefe_nombre', 'Nombre del Jefe Inmediato', ['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2']) !!}
                         <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user-tie text-gray-400"></i>
                            </div>
                            {!! Form::text('jefe_nombre', null, [
                                'class' => 'pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                'placeholder' => 'Quien firma como supervisor'
                            ]) !!}
                        </div>
                        @error('jefe_nombre') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Jefe Firma --}}
                 <div x-data="{ fileName: '' }">
                    {!! Form::label('jefe_firma', 'Firma del Jefe (Imagen PNG/JPG)', ['class' => 'block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2']) !!}
                    
                    <div class="flex items-center justify-center w-full">
                        <label for="jefe_firma" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-signature text-3xl text-gray-400 group-hover:text-primary-500 transition-colors mb-2"></i>
                                <p class="mb-2 text-sm text-gray-500" x-show="!fileName"><span class="font-semibold">Click para subir firma</span></p>
                                <p class="mb-2 text-sm text-primary-600 font-bold" x-show="fileName" x-text="fileName"></p>
                            </div>
                            {!! Form::file('jefe_firma', [
                                'id' => 'jefe_firma', 
                                'class' => 'hidden', 
                                'accept' => 'image/*', 
                                'onchange' => 'if(this.files.length > 0) { this.closest("[x-data]").__x.$data.fileName = this.files[0].name; }'
                            ]) !!}
                        </label>
                    </div>
                    @error('jefe_firma') <span class="text-red-500 text-sm font-bold">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="bg-primary hover:bg-primary-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary/30 transform hover:scale-105 transition-all duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i> Guardar Departamento
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>
