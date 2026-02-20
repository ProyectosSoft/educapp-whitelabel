<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2"></div>
            
            <div class="relative z-10 flex items-center gap-4">
                <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                    <i class="fas fa-folder-plus text-xl"></i>
                </div>
                <div>
                   <h2 class="text-2xl font-bold tracking-tight">Crear Nueva Categoría</h2>
                   <p class="text-blue-100 text-sm font-medium">Registra una nueva categoría para organizar los cursos</p>
                </div>
            </div>
            
            <a href="{{ route('admin.categorias.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Categorías
            </a>
        </div>

        {{-- Form Content --}}
        <div class="p-8 relative z-10">
            {!! Form::open(['route' => 'admin.categorias.store', 'enctype' => 'multipart/form-data', 'class' => 'space-y-8']) !!}
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    {{-- Left Column --}}
                    <div class="space-y-6">
                        {{-- Nombre --}}
                        <div>
                            {!! Form::label('nombre', 'Nombre de la Categoría', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('nombre', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Ej: Marketing Digital'
                                ]) !!}
                            </div>
                            @error('nombre')
                                <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                {!! Form::label('description', 'Descripción', ['class' => 'block font-bold text-sm text-[#335A92]']) !!}
                                <span class="text-xs font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded-md" id="descripcionCount">0 / 120</span>
                            </div>
                            <div class="relative group">
                                {!! Form::textarea('description', null, [
                                    'class' => 'w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all text-gray-800 placeholder-gray-400 p-4',
                                    'placeholder' => 'Escribe una breve descripción para esta categoría...',
                                    'rows' => 5,
                                    'maxlength' => 120,
                                    'id' => 'descripcionTextarea'
                                ]) !!}
                            </div>
                            @error('descripcion')
                                <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Column (Image) --}}
                    <div>
                        <div x-data="{ fileName: '' }" class="bg-gray-50 p-6 rounded-2xl border border-gray-100 h-full flex flex-col justify-center">
                            {!! Form::label('imagen', 'Imagen de Portada', ['class' => 'block font-bold text-sm text-[#335A92] mb-4 text-center']) !!}
                            
                            <div class="flex items-center justify-center w-full">
                                <label for="imagen" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer hover:bg-white hover:border-[#335A92] hover:shadow-md transition-all group relative overflow-hidden">
                                    
                                    {{-- Upload UI --}}
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4 relative z-10">
                                        <div class="bg-white p-4 rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-[#335A92] group-hover:text-[#ECBD2D] transition-colors"></i>
                                        </div>
                                        <p class="mb-1 text-sm text-gray-500 group-hover:text-[#335A92] transition-colors" x-show="!fileName">
                                            <span class="font-bold">Haz clic para subir</span> o arrastra
                                        </p>
                                        <p class="mb-1 text-sm text-[#335A92] font-bold break-all px-2" x-show="fileName" x-text="fileName"></p>
                                        <p class="text-xs text-gray-400 group-hover:text-gray-500">Recomendado: 640x480px (PNG, JPG)</p>
                                    </div>

                                    {{-- File Input --}}
                                    {!! Form::file('imagen', [
                                        'id' => 'imagen', 
                                        'class' => 'hidden', 
                                        'accept' => 'image/*', 
                                        'onchange' => 'validarImagen(this); if(this.files.length > 0) { this.closest("[x-data]").__x.$data.fileName = this.files[0].name; }'
                                    ]) !!}
                                </label>
                            </div>
                            <p class="mt-3 text-xs text-red-600 font-bold hidden flex items-center bg-red-50 p-2 rounded-lg justify-center" id="dimensionesError">
                                <i class="fas fa-exclamation-circle mr-1"></i> <span></span>
                            </p>
                            @error('imagen')
                                <p class="mt-2 text-xs text-red-600 font-bold flex items-center bg-red-50 p-2 rounded-lg">
                                    <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-[#335A92] hover:bg-[#284672] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center text-lg">
                        <i class="fas fa-save mr-2"></i> Crear Categoría
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>

    @push('js')
        <script>
            // Character counter logic
            const textArea = document.getElementById('descripcionTextarea');
            const countMessage = document.getElementById('descripcionCount');
            const maxLength = 120;

            function updateCounter() {
                if(!textArea) return;
                const currentLength = textArea.value.length;
                countMessage.innerText = `${currentLength} / ${maxLength}`;
                
                if (currentLength >= maxLength) {
                    countMessage.classList.add('bg-red-100', 'text-red-600');
                    countMessage.classList.remove('bg-gray-100', 'text-gray-400');
                } else {
                    countMessage.classList.remove('bg-red-100', 'text-red-600');
                    countMessage.classList.add('bg-gray-100', 'text-gray-400');
                }
            }

            if(textArea) {
                textArea.addEventListener('input', updateCounter);
            }

            // Image validation
            function validarImagen(input) {
                const dimensionesError = document.getElementById('dimensionesError');
                const errorText = dimensionesError.querySelector('span');
                const maxAncho = 640; 
                const maxAlto = 480;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const img = new Image();
                        img.src = e.target.result;

                        img.onload = function () {
                            if (img.width !== maxAncho || img.height !== maxAlto) {
                                errorText.innerText = 'La imagen debe ser de ' + maxAncho + 'x' + maxAlto + 'px.';
                                dimensionesError.classList.remove('hidden');
                                input.value = ''; // Clear file input
                            } else {
                                dimensionesError.classList.add('hidden');
                                errorText.innerText = '';
                            }
                        };
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
</x-admin-layout>
