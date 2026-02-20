<div class="space-y-8">
    
    {{-- Sección 1: Información Básica --}}
    <div class="bg-gray-50/50 p-8 rounded-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
            <i class="fas fa-info-circle mr-2"></i> Información Básica
        </h3>
        
        <div class="grid grid-cols-1 gap-6">
            <!-- Title -->
            <div>
                {!! form::label('nombre', 'Título del curso', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                <div class="relative">
                    {!! form::text('nombre', null, [
                        'class' => 'pl-4 w-full bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block p-3 shadow-sm placeholder:text-gray-300 transition-all font-medium',
                        'placeholder' => 'Ej: Curso Profesional de Desarrollo Web'
                    ]) !!}
                </div>
                @error('nombre') <p class="mt-1 text-xs text-red-500 font-bold"><i class="fas fa-times-circle mr-1"></i> {{ $message }}</p> @enderror
            </div>
    
            <!-- Slug -->
            <div>
                {!! form::label('slug', 'URL Amigable (Slug)', ['class' => 'block mb-2 text-xs font-bold text-gray-500 uppercase']) !!}
                {!! form::text('slug', null, [
                    'readonly' => 'readonly',
                    'class' => 'w-full bg-gray-100 border border-gray-200 text-gray-500 text-xs rounded-xl block p-2.5 cursor-not-allowed font-mono',
                ]) !!}
                @error('slug') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>
    
            <!-- Subtitle -->
            <div>
                {!! form::label('subtitulo', 'Subtítulo Corto', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! form::text('subtitulo', null, [
                    'class' => 'w-full bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block p-3 shadow-sm placeholder:text-gray-300 transition-all',
                    'placeholder' => 'Ej: Aprende desde cero hasta experto.'
                ]) !!}
                @error('subtitulo') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>
    
            <!-- Description -->
            <div>
                {!! form::label('descripcion', 'Descripción Detallada', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! form::textarea('descripcion', null, [
                    'class' => 'w-full bg-white border border-gray-300 rounded-xl',
                ]) !!}
                @error('descripcion') <p class="mt-1 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Sección 2: Clasificación y Detalles --}}
    <div class="bg-gray-50/50 p-8 rounded-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
            <i class="fas fa-list-ul mr-2"></i> Configuración y Detalles
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                {!! Form::label('categoria_id', 'Categoría', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! Form::select('categoria_id', $categorias, null, ['class' => 'bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block w-full p-3']) !!}
            </div>
            <div>
                {!! Form::label('nivel_id', 'Nivel', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! Form::select('nivel_id', $niveles, null, ['class' => 'bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block w-full p-3']) !!}
            </div>
            <div>
                {!! Form::label('precio_id', 'Precio', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                <div class="flex items-stretch gap-2">
                    {!! Form::select('precio_id', $precios, null, ['class' => 'bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block w-full p-3 pl-3', 'id' => 'precio_id']) !!}
                    <button type="button" onclick="newPrice()" class="px-4 bg-[#335A92] text-white rounded-xl hover:bg-[#284672] shadow-sm transition" title="Crear Tarifa">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            {{-- <div>
                {!! Form::label('garantia_id', 'Garantía', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! Form::select('garantia_id', $garantias, null, ['class' => 'bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block w-full p-3']) !!}
            </div> --}}
            {{-- <div>
                {!! Form::label('tipo_formato_id', 'Formato', ['class' => 'block mb-2 text-sm font-bold text-gray-700']) !!}
                {!! Form::select('tipo_formato_id', $tipo_formatos, null, ['class' => 'bg-white border border-gray-300 text-gray-700 text-sm rounded-xl focus:ring-[#335A92] focus:border-[#335A92] block w-full p-3']) !!}
            </div> --}}
        </div>
    </div>

    {{-- Sección 3: Imagen del Curso --}}
    <div class="bg-gray-50/50 p-8 rounded-2xl border border-gray-100">
        <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
            <i class="fas fa-image mr-2"></i> Portada del Curso
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Instrucciones -->
            <div>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    Sube una imagen atractiva que represente el contenido de tu curso. Esta imagen será lo primero que vean tus estudiantes.
                </p>
                
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-6">
                    <h4 class="font-bold text-[#335A92] text-sm mb-2">Recomendaciones:</h4>
                    <ul class="text-xs text-blue-800 space-y-1 list-disc list-inside">
                        <li>Resolución recomendada: <b>1280x720 px</b> (16:9)</li>
                        <li>Formatos aceptados: <b>JPG, PNG</b></li>
                        <li>Peso máximo: <b>2MB</b></li>
                    </ul>
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="file">Subir Imagen</label>
                    <input type="file" name="file" id="file" accept="image/*" onchange="validarImagen(this)" 
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-3 file:px-6
                                  file:rounded-xl file:border-0
                                  file:text-sm file:font-bold
                                  file:bg-[#335A92] file:text-white
                                  hover:file:bg-[#284672]
                                  cursor-pointer focus:outline-none"/>
                </div>
                @error('file') <p class="mt-2 text-xs text-red-500 font-bold">{{ $message }}</p> @enderror
            </div>

            <!-- Preview -->
            <div class="relative group">
                <div class="aspect-video w-full bg-gray-200 rounded-2xl overflow-hidden shadow-md border-4 border-white ring-1 ring-gray-100">
                    @isset($course->image)
                        <img id="picture" class="w-full h-full object-cover" src="{{ Storage::url($course->image->url) }}" alt="">
                    @else
                        <img id="picture" class="w-full h-full object-contain p-8 bg-slate-100 opacity-90" src="{{ asset('img/LOGO_ACADEMIA_Effi_ERP.png') }}" alt="Sin imagen seleccionada">
                    @endisset
                </div>
                <p class="text-center text-xs text-gray-400 mt-2">Vista previa de la portada</p>
            </div>
        </div>
    </div>

</div>
