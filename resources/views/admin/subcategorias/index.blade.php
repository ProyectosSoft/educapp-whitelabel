<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-layer-group text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Gestión de Subcategorías</h2>
                    <p class="text-blue-100 text-sm font-medium">Organiza el contenido en niveles específicos</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.subcategorias.create') }}" class="relative z-10 px-6 py-3 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl shadow-lg shadow-black/10 transform hover:scale-105 transition-all duration-200 flex items-center group">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Nueva Subcategoría
             </a>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
             <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">ID</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Nombre</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Categoría Principal</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Estado</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($subcategorias as $subcategoria)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                             <td class="px-8 py-5 font-bold text-[#335A92]">
                                 #{{ $subcategoria->id }}
                             </td>
                             <td class="px-8 py-5">
                                 <span class="text-base font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">
                                     {{ $subcategoria->nombre }}
                                 </span>
                             </td>
                             <td class="px-8 py-5">
                                 <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#335A92]/10 text-[#335A92] border border-[#335A92]/20">
                                     <i class="fas fa-tag mr-1.5 opacity-50"></i>
                                     {{ $subcategoria->Categoria->nombre }}
                                 </span>
                             </td>
                             <td class="px-8 py-5">
                                @if($subcategoria->estado == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i> Activo
                                    </span>
                                @else
                                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                        <i class="fas fa-ban mr-1"></i> Inactivo
                                     </span>
                                @endif
                             </td>
                             <td class="px-8 py-5 text-center space-x-2">
                                 <a href="{{ route('admin.subcategorias.edit', $subcategoria) }}" 
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-[#ECBD2D] hover:text-[#335A92] hover:border-[#ECBD2D] transition-all shadow-sm hover:shadow-md hover:-translate-y-1"
                                    title="Editar">
                                     <i class="fas fa-pencil-alt text-sm"></i>
                                 </a>
                                 
                                 <form action="{{ route('admin.subcategorias.destroy', $subcategoria) }}" method="POST" class="inline-block delete-form">
                                     @csrf
                                     @method('delete')
                                     <button type="submit" 
                                             class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm hover:shadow-md hover:-translate-y-1"
                                             title="Eliminar">
                                         <i class="fas fa-trash text-sm"></i>
                                     </button>
                                 </form>
                             </td>
                        </tr>
                    @endforeach
                </tbody>
             </table>
        </div>
        
        {{-- Footer --}}
        <div class="p-4 border-t border-gray-100 bg-gray-50/50 text-xs text-gray-500 text-center font-medium">
             Mostrando {{ $subcategorias->count() }} subcategorías registradas
        </div>
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
            {{ $subcategorias->links() }}
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check for success message
                @if (session('info'))
                    Swal.fire({
                        icon: 'success',
                        title: '¡Operación Exitosa!',
                        text: '{{ session('info') }}',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-[#335A92] text-white font-bold py-2.5 px-6 rounded-xl shadow-md'
                        },
                        buttonsStyling: false
                    });
                @endif

                // Check for error message
                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '{{ session('error') }}',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md'
                        },
                        buttonsStyling: false
                    });
                @endif

                const deleteForms = document.querySelectorAll('.delete-form');
                
                deleteForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡No podrás revertir esta acción!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#335A92',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar',
                            customClass: {
                                popup: 'rounded-2xl',
                                confirmButton: 'bg-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md ml-2',
                                cancelButton: 'bg-gray-200 text-gray-800 font-bold py-2.5 px-6 rounded-xl shadow-sm hover:bg-gray-300'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
</x-admin-layout>
