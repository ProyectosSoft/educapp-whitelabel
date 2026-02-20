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
                    <h2 class="text-2xl font-bold tracking-tight">Gestión de Empresas</h2>
                    <p class="text-blue-100 text-sm font-medium">Administra las identidades corporativas</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.empresas.create') }}" class="relative z-10 px-6 py-3 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl shadow-lg shadow-black/10 transform hover:scale-105 transition-all duration-200 flex items-center group">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Nueva Empresa
             </a>
        </div>

        {{-- Table Content --}}
        <div class="overflow-x-auto">
             <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">ID</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Firma CEO</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Nombre</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">CEO</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Enlace de Registro</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($empresas as $empresa)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                             <td class="px-8 py-5 font-bold text-[#335A92]">
                                 #{{ $empresa->id }}
                             </td>
                             <td class="px-8 py-5">
                                 @if($empresa->ceo_firma)
                                     <div class="p-1 bg-white border border-gray-100 rounded-lg shadow-sm w-fit">
                                         <img src="{{ Storage::disk('do')->url($empresa->ceo_firma) }}" alt="Firma CEO" class="h-8 w-20 object-contain">
                                     </div>
                                 @else
                                     <span class="text-xs text-gray-400 italic">Sin firma</span>
                                 @endif
                             </td>
                             <td class="px-8 py-5">
                                 <span class="text-base font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">
                                     {{ $empresa->nombre }}
                                 </span>
                             </td>
                             <td class="px-8 py-5 text-gray-600">
                                 <div class="flex items-center">
                                     <i class="fas fa-user-tie text-[#477EB1] mr-2"></i>
                                     {{ $empresa->ceo_nombre }}
                                 </div>
                             </td>
                             <td class="px-8 py-5" 
                                 x-data="{ 
                                     tooltip: false,
                                     link: '{{ url('/registro?empresa=' . $empresa->slug) }}'
                                 }"
                                 @mouseleave="tooltip = false">
                                 <div class="relative flex items-center group/link cursor-pointer w-fit"
                                      @click="
                                         navigator.clipboard.writeText(link);
                                         tooltip = true;
                                         setTimeout(() => tooltip = false, 2000);
                                      ">
                                     <span class="px-3 py-1.5 text-xs font-mono font-medium rounded-lg bg-blue-50 text-blue-600 border border-blue-100 group-hover/link:bg-blue-100 transition-colors flex items-center gap-2">
                                         <i class="fas fa-link"></i> ?empresa={{ $empresa->slug }}
                                     </span>
                                     
                                     {{-- Tooltip 'Copiado' --}}
                                     <div x-show="tooltip" 
                                          style="display: none;"
                                          class="absolute left-0 -top-8 bg-[#335A92] text-white text-[10px] font-bold py-1 px-3 rounded shadow-lg whitespace-nowrap z-50">
                                         ¡Enlace Copiado!
                                         <div class="absolute bottom-0 left-4 transform translate-y-1/2 rotate-45 w-2 h-2 bg-[#335A92]"></div>
                                     </div>
                                 </div>
                             </td>
                             <td class="px-8 py-5 text-center space-x-2">
                                 <a href="{{ route('admin.empresas.edit', $empresa) }}" 
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-[#ECBD2D] hover:text-[#335A92] hover:border-[#ECBD2D] transition-all shadow-sm hover:shadow-md hover:-translate-y-1"
                                    title="Editar">
                                     <i class="fas fa-pencil-alt text-sm"></i>
                                 </a>
                                 
                                 <form action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST" class="inline-block delete-form">
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
             Mostrando {{ $empresas->count() }} empresas aliadas
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-[#335A92] text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200'
                        },
                        buttonsStyling: false
                    });
                @endif
                
                @if (session('info'))
                    Swal.fire({
                        icon: 'info',
                        title: 'Información',
                        text: '{{ session('info') }}',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'bg-[#335A92] text-white font-bold py-2.5 px-6 rounded-xl shadow-md'
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
