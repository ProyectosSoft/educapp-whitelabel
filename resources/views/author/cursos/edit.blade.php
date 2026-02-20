<x-instructor-layout :course="$course">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        {{-- Breadcrumb minimalista --}}
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="{{ route('author.cursos.index') }}" class="hover:text-[#335A92] transition-colors"><i class="fas fa-arrow-left mr-2"></i> Volver a mis cursos</a>
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
            
            {{-- Header Corporativo --}}
            <div class="bg-[#335A92] px-10 py-8 relative overflow-hidden flex justify-between items-center">
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-yellow-400/20 blur-3xl"></div>
                
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold text-white">Editar Curso</h1>
                    <p class="text-blue-100 mt-2 text-lg truncate max-w-2xl">{{ $course->nombre }}</p>
                </div>
                
                <div class="hidden md:block relative z-10">
                     <span class="bg-white/10 text-white px-4 py-2 rounded-lg text-sm font-bold border border-white/20">
                        <i class="fas fa-pencil-alt mr-2"></i> Edición
                    </span>
                </div>
            </div>
            
            <div class="p-10">
                {!! Form::model($course,['route' => ['author.cursos.update',$course],'method' => 'put', 'files'=> true])!!}
            
                    @include('author.cursos.partials.form')
                    
                    {{-- Actions Footer --}}
                    <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-end gap-4">
                         <a href="{{ route('author.cursos.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition shadow-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="cursor-pointer px-8 py-3 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center">
                            <i class="fas fa-sync-alt mr-2"></i> Actualizar Curso
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <x-slot name="js">
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

        <script>
            // Slug
            document.getElementById("nombre").addEventListener('keyup', function() {
                document.getElementById("slug").value = slug(this.value);
            });

            function slug (str) {
                var $slug = '';
                var trimmed = str.trim(str);
                $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
                replace(/-+/g, '-').
                replace(/^-|-$/g, '');
                return $slug.toLowerCase();
            }

            // CKEditor
            ClassicEditor
                .create( document.querySelector( '#descripcion' ), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                })
                .catch( error => {
                    console.log( error );
                });

            // Imagen Previsualizacion
            // Imagen Previsualizacion
            if(document.getElementById("file")){
                document.getElementById("file").addEventListener('change', cambiarImagen);
            }
            function cambiarImagen(event){
                var file = event.target.files[0];
                var reader = new FileReader();
                reader.onload = (event) => {
                    document.getElementById("picture").setAttribute('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
            
            function validarImagen(input) {
                // Validacion igual a create
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.newPrice = function() {
                Swal.fire({
                    title: '<h3 class="text-xl font-bold text-[#335A92]">Crear Nueva Tarifa</h3>',
                    html: `
                        <div class="space-y-4 text-left px-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nombre de la Tarifa</label>
                                <input id="swal-name" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#335A92] focus:border-[#335A92]" placeholder="Ej: Precio Estándar">
                            </div>
                            <div>
                                 <label class="block text-sm font-bold text-gray-700 mb-1">Valor</label>
                                <input id="swal-value" type="number" step="0.01" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#335A92] focus:border-[#335A92]" placeholder="0.00">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Dcto. Mín (%)</label>
                                    <input id="swal-dctomin" type="number" step="0.01" value="0" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#335A92] focus:border-[#335A92]" placeholder="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Dcto. Máx (%)</label>
                                    <input id="swal-dctomax" type="number" step="0.01" value="0" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#335A92] focus:border-[#335A92]" placeholder="0">
                                </div>
                            </div>
                             <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Moneda</label>
                                <select id="swal-currency" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-[#335A92] focus:border-[#335A92] bg-white">
                                     @foreach($monedas as $moneda)
                                        <option value="{{ $moneda->id }}">{{ $moneda->nombre }} ({{ $moneda->abreviatura }})</option>
                                     @endforeach
                                </select>
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar Tarifa',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#335A92',
                    cancelButtonColor: '#d33',
                    customClass: {
                        popup: 'rounded-2xl border border-gray-100 shadow-xl',
                        confirmButton: 'px-6 py-2 rounded-xl font-bold shadow-md',
                        cancelButton: 'px-6 py-2 rounded-xl font-bold shadow-sm border border-gray-200 bg-white text-gray-600 hover:bg-gray-50'
                    },
                    preConfirm: () => {
                        const name = document.getElementById('swal-name').value;
                        const value = document.getElementById('swal-value').value;
                        const dctomin = document.getElementById('swal-dctomin').value;
                        const dctomax = document.getElementById('swal-dctomax').value;
                        const currency = document.getElementById('swal-currency').value;
                        
                        if (!name || !value) {
                            Swal.showValidationMessage('Por favor completa todos los campos requeridos');
                            return false;
                        }
                        
                        return { name: name, value: value, dctomin: dctomin, dctomax: dctomax, moneda_id: currency };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request
                         fetch("{{ route('author.prices.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                name: result.value.name,
                                value: result.value.value,
                                moneda_id: result.value.moneda_id,
                                dctoMin: result.value.dctomin,
                                dctoMax: result.value.dctomax
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                             if(data.id) {
                                const select = document.getElementById('precio_id');
                                const option = new Option(data.name, data.id, true, true);
                                select.add(option);
                                Swal.fire({
                                    title: '¡Creado!',
                                    text: 'La tarifa ha sido creada exitosamente.',
                                    icon: 'success',
                                    confirmButtonColor: '#335A92'
                                });
                             } else {
                                Swal.fire('Error', 'No se pudo crear la tarifa.', 'error');
                             }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Hubo un problema al crear la tarifa. Verifica tu conexión.', 'error');
                        });
                    }
                });
            }
        </script>
    </x-slot>
</x-instructor-layout>
