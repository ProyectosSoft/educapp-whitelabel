<x-admin-layout>
    {{-- Main Container --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-users-gear text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Lista de Roles</h2>
                    <p class="text-blue-100 text-sm font-medium">Gestión de permisos y accesos del sistema</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.roles.create') }}" class="relative z-10 px-5 py-2.5 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl shadow-lg transition-all flex items-center transform hover:scale-105 group">
                 <i class="fas fa-plus mr-2 text-lg group-hover:rotate-90 transition-transform"></i> Crear Nuevo Rol
             </a>
        </div>

        @if (session('info'))
            <div class="px-8 pt-6">
                <div class="flex items-center p-4 mb-4 text-sm text-[#335A92] rounded-xl bg-[#335A92]/10 border border-[#335A92]/20 shadow-sm" role="alert">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-bold">¡Éxito!</span> {{ session('info') }}
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider w-24">ID</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider">Nombre del Rol</th>
                        <th scope="col" class="px-8 py-5 font-bold tracking-wider text-center w-48">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                            <td class="px-8 py-5 font-bold text-[#335A92]">
                                #{{ $role->id }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-[#335A92] flex items-center justify-center mr-3 border border-blue-100 group-hover:bg-white group-hover:shadow-sm transition-all">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                    <span class="text-base font-bold text-gray-800 group-hover:text-[#335A92] transition-colors">
                                        {{ $role->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center space-x-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-[#ECBD2D] hover:text-[#335A92] hover:border-[#ECBD2D] transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1"
                                   title="Editar">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline-block delete-form">
                                    @method('delete')
                                    @csrf
                                    <button type="button" 
                                            onclick="confirmDelete(this)"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-1"
                                            title="Eliminar">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-16 text-center text-gray-500 bg-gray-50">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-700">No hay roles registrados</h3>
                                    <p class="text-sm text-gray-400">Comienza creando uno nuevo desde el botón superior.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(button) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    backdrop: `rgba(0,0,0,0.4)`,
                    customClass: {
                        popup: 'rounded-[1.5rem] p-10 border-0',
                        title: 'text-3xl font-bold text-gray-800 mb-2',
                        htmlContainer: 'text-lg text-gray-500',
                        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all transform hover:scale-105',
                        cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-sm mr-4 transition-all transform hover:scale-105',
                        actions: 'mt-6 w-full flex justify-center gap-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                })
            }
        </script>
    @endpush
</x-admin-layout>
