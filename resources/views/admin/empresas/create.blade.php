<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-building text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Crear Nueva Empresa</h2>
                    <p class="text-blue-100 text-sm font-medium">Registra una nueva identidad corporativa en la plataforma</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.empresas.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                 <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Lista
             </a>
        </div>

        {{-- Form Content --}}
        <div class="p-8 relative z-10">
            {!! Form::open(['route' => 'admin.empresas.store', 'enctype' => 'multipart/form-data', 'class' => 'space-y-8', 'id' => 'createEmpresaForm']) !!}
                
                {{-- Sección 1: Información Básica --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Nombre --}}
                        <div>
                            {!! Form::label('nombre', 'Nombre de la Empresa', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                 <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('nombre', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Ej: Grupo Effi',
                                    'id' => 'nombre'
                                ]) !!}
                            </div>
                            @error('nombre') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            {!! Form::label('slug', 'URL Personalizada (Slug)', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-link text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('slug', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Ej: grupo-effi',
                                    'id' => 'slug'
                                ]) !!}
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium bg-blue-50/50 p-2 rounded-lg border border-blue-100 inline-block">
                                <i class="fas fa-globe mr-1 text-blue-400"></i> Link de registro: <span class="text-blue-600">educapp.com/registro?empresa=</span><span id="slug-preview" class="font-bold text-[#335A92]">...</span>
                            </p>
                            @error('slug') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                         {{-- NIT --}}
                        <div>
                            {!! Form::label('nit', 'NIT / Identificador (Opcional)', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('nit', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Ej: 900.123.456-7'
                                ]) !!}
                            </div>
                            @error('nit') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- CEO Nombre --}}
                        <div>
                            {!! Form::label('ceo_nombre', 'Nombre del CEO', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                             <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tie text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('ceo_nombre', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Nombre completo del representante legal'
                                ]) !!}
                            </div>
                            @error('ceo_nombre') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Firma Digital --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
                        <i class="fas fa-signature mr-2"></i> Firma Digital del CEO
                    </h3>
                    
                     <div id="ceo-signature-wrapper" x-data="{ fileName: '', tab: 'upload', signaturePad: null }" 
                          x-init="
                            signaturePad = new SignaturePad(document.getElementById('signature-pad-ceo'), {
                                backgroundColor: 'rgba(255, 255, 255, 0)',
                                penColor: 'rgb(0, 0, 0)'
                            });
                            signaturePad.addEventListener('endStroke', () => {
                               document.getElementById('ceo_firma_data').value = signaturePad.toDataURL('image/png');
                            });
                          ">
                        
                        {{-- Tabs --}}
                        <div class="flex space-x-1 mb-6 bg-white p-1 rounded-xl border border-gray-200 w-fit shadow-sm">
                            <button type="button" @click="tab = 'upload'; document.getElementById('ceo_firma_data').value = '';" :class="{'bg-[#335A92] text-white shadow-md': tab === 'upload', 'text-gray-500 hover:bg-gray-50': tab !== 'upload'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center">
                                <i class="fas fa-cloud-upload-alt mr-2"></i> Subir Imagen
                            </button>
                            <button type="button" @click="tab = 'draw'; setTimeout(() => { signaturePad.on(); window.dispatchEvent(new Event('resize')); }, 100)" :class="{'bg-[#335A92] text-white shadow-md': tab === 'draw', 'text-gray-500 hover:bg-gray-50': tab !== 'draw'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center">
                                <i class="fas fa-pen-nib mr-2"></i> Dibujar en Pantalla
                            </button>
                        </div>

                        {{-- Upload Tab --}}
                        <div x-show="tab === 'upload'" class="flex items-center justify-center w-full">
                            <label for="ceo_firma" class="flex flex-col items-center justify-center w-full h-56 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer hover:bg-white hover:border-[#335A92] hover:shadow-md transition-all group bg-white relative overflow-hidden">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                    <div class="bg-blue-50 p-4 rounded-full mb-3 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-file-image text-3xl text-[#335A92]"></i>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500 font-medium" x-show="!fileName"><span class="font-bold text-[#335A92]">Haz clic para subir</span> o arrastra la imagen</p>
                                    <p class="mb-1 text-sm text-[#335A92] font-bold" x-show="fileName" x-text="fileName"></p>
                                    <p class="text-xs text-gray-400">Recomendado: PNG con fondo transparente</p>
                                </div>
                                {!! Form::file('ceo_firma', [
                                    'id' => 'ceo_firma_input', 
                                    'class' => 'hidden', 
                                    'accept' => 'image/*', 
                                    'onchange' => 'if(this.files.length > 0) { this.closest("[x-data]").__x.$data.fileName = this.files[0].name; }'
                                ]) !!}
                            </label>
                        </div>

                        {{-- Draw Tab --}}
                        <div x-show="tab === 'draw'" class="border-2 border-dashed border-gray-300 rounded-2xl p-6 flex flex-col items-center justify-center bg-white">
                            <canvas id="signature-pad-ceo" class="border border-gray-200 rounded-xl shadow-inner bg-white cursor-crosshair w-full max-w-[600px]" width="600" height="200"></canvas>
                            <div class="flex justify-between w-full max-w-[600px] mt-4 px-2">
                                <button type="button" @click="signaturePad.clear(); document.getElementById('ceo_firma_data').value = '';" class="text-xs text-red-500 hover:text-red-700 font-bold uppercase tracking-wider flex items-center bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100 transition-colors">
                                    <i class="fas fa-trash mr-1.5"></i> Limpiar Firma
                                </button>
                                <p class="text-xs text-gray-400 font-medium flex items-center">
                                    <i class="fas fa-mouse-pointer mr-1.5"></i> Usa tu mouse o dedo para firmar
                                </p>
                            </div>
                            <input type="hidden" name="ceo_firma_data" id="ceo_firma_data">
                        </div>

                        @error('ceo_firma') <span class="text-red-600 text-xs font-bold mt-2 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Estado --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="block font-bold text-[#335A92]">Estado de la Empresa</span>
                        <span class="text-xs text-gray-500">Define si la empresa puede operar en la plataforma</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        {!! Form::checkbox('estado', 1, true, ['class' => 'sr-only peer']) !!}
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#335A92]"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700 peer-checked:text-[#335A92] peer-checked:font-bold">Activa</span>
                    </label>
                </div>

                {{-- Nota sobre Departamentos --}}
                <div class="bg-blue-50 border border-blue-100 p-5 rounded-2xl flex items-start gap-4">
                    <div class="bg-blue-100 p-2 rounded-lg text-[#335A92] flex-shrink-0">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-[#335A92] text-sm">Próximos Pasos</h4>
                        <p class="text-sm text-blue-800 mt-1">
                            Una vez guardes la información básica, podrás configurar los <strong>Departamentos</strong> y asignar sus Jefes Inmediatos en la siguiente pantalla.
                        </p>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-[#335A92] hover:bg-[#284672] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center text-lg">
                        <i class="fas fa-save mr-2"></i> Guardar y Continuar
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const nombreInput = document.getElementById('nombre');
                const slugInput = document.getElementById('slug');
                const slugPreview = document.getElementById('slug-preview');

                function stringToSlug(str) {
                    return str
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }

                nombreInput.addEventListener('input', function() {
                    const slug = stringToSlug(this.value);
                    slugInput.value = slug;
                    slugPreview.textContent = slug;
                });

                slugInput.addEventListener('input', function() {
                    slugPreview.textContent = this.value;
                });
            });
        </script>
    @endpush
</x-admin-layout>
