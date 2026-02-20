<x-admin-layout>
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
        
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

        <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-sitemap text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                    <span class="tracking-tight">Gestión de Departamentos</span>
                </h2>
                <div class="flex items-center text-xs text-gray-500 mt-1 ml-10">
                    <a href="{{ route('home') }}" class="hover:text-primary-600 transition">Inicio</a>
                    <i class="fas fa-chevron-right text-[10px] mx-2"></i>
                    <span>Departamentos</span>
                </div>
            </div>
            
            <a href="{{ route('admin.departamentos.create') }}" class="px-5 py-2.5 bg-secondary text-primary-900 font-bold rounded-xl hover:bg-secondary-400 transition-all shadow-lg shadow-secondary/20 flex items-center transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Nuevo Departamento
            </a>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 dark:bg-gray-700/80 dark:text-gray-400 tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200">ID</th>
                        <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200">Firma Jefe</th>
                        <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200">Departamento</th>
                         <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200">Jefe</th>
                        <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200">Empresa</th>
                        <th scope="col" class="px-6 py-4 font-bold text-primary-900 dark:text-primary-200 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($departamentos as $departamento)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 group">
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">
                                #{{ $departamento->id }}
                            </td>
                            <td class="px-6 py-4">
                                @if($departamento->jefe_firma)
                                   <img src="{{ Storage::url($departamento->jefe_firma) }}" alt="Firma Jefe" class="h-10 w-24 object-contain rounded-lg shadow-sm bg-white">
                                @else
                                    <span class="text-xs text-gray-400">Sin firma</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-base font-bold text-gray-800 dark:text-white group-hover:text-primary-600 transition-colors">
                                    {{ $departamento->nombre }}
                                </span>
                            </td>
                             <td class="px-6 py-4 text-gray-600">
                                {{ $departamento->jefe_nombre }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md bg-gray-100 text-gray-800 text-xs font-bold">
                                    {{ $departamento->empresa->nombre ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('admin.departamentos.edit', $departamento) }}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-110"
                                   title="Editar">
                                    <i class="fas fa-pencil-alt text-xs"></i>
                                </a>
                                
                                <form action="{{ route('admin.departamentos.destroy', $departamento) }}" method="POST" class="inline-block delete-form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-110"
                                            title="Eliminar">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 dark:border-gray-600 bg-gray-50/50 dark:bg-gray-700/50 text-xs text-gray-400 text-center">
            Mostrando {{ $departamentos->count() }} departamentos
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
                            confirmButton: 'bg-green-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200'
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
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '¡Sí, eliminar!',
                            cancelButtonText: 'Cancelar'
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
