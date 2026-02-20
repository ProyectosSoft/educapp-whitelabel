<div>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Decorative Background Elements (Subtle) --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-secondary/5 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-primary-900/5 blur-3xl pointer-events-none"></div>

        {{-- Header / Search Section --}}
        <div class="p-8 border-b border-gray-100 bg-white relative z-10 flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-4">
                <div class="bg-primary-50 p-3 rounded-2xl text-primary-900 shadow-sm">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-primary-900 tracking-tight">Gestión de Usuarios</h2>
                    <p class="text-sm text-gray-500 font-medium">Administra el acceso y roles de la plataforma</p>
                </div>
            </div>
            
            <div class="relative w-full lg:w-96 group">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i class="fas fa-search text-gray-400 group-focus-within:text-secondary transition-colors"></i>
                </div>
                <input wire:keydown="limpiar_page" wire:model="search" type="text"
                    class="block w-full py-3 pl-12 pr-4 text-sm text-gray-700 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all shadow-sm group-hover:bg-white"
                    placeholder="Buscar usuario por nombre o correo...">
            </div>
        </div>

        {{-- Table Content --}}
        @if ($users->count())
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                        <tr>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">ID</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">Usuario</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">Contacto</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider">Roles</th>
                            <th scope="col" class="px-8 py-5 font-bold tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200 group">
                                <td class="px-8 py-5 font-medium text-[#335A92]">
                                    #{{ $user->id }}
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <img class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-md group-hover:scale-105 transition-transform duration-300" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                                            @else
                                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-[#477EB1] to-[#335A92] text-white font-bold text-lg border-2 border-white shadow-md">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            @endif
                                            <div class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full bg-[#ECBD2D] border-2 border-white shadow-sm" title="Activo"></div>
                                        </div>
                                        <div>
                                            <div class="text-base font-bold text-gray-900 group-hover:text-[#335A92] transition-colors">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400 font-medium">Registrado {{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center text-gray-500 group-hover:text-gray-700 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-[#477EB1] mr-3 shadow-sm border border-gray-100">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                        <span class="font-medium">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @if ($user->roles->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($user->roles as $role)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-[#ECBD2D]/20 text-[#335A92] border border-[#ECBD2D]/30">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                            Sin Roles
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white text-gray-400 hover:bg-[#ECBD2D] hover:text-[#335A92] transition-all duration-300 shadow-sm border border-gray-100 hover:border-[#ECBD2D] hover:-translate-y-1"
                                        title="Editar Usuario">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Custom Pagination --}}
            <div class="px-8 py-6 border-t border-gray-50 bg-gray-50/30">
                {{ $users->links() }}
            </div>
        @else
            <div class="p-16 text-center">
                <div class="bg-gray-50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <i class="fas fa-search text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron usuarios</h3>
                <p class="text-gray-500 max-w-sm mx-auto">No hay resultados para tu búsqueda. Intenta con otros términos.</p>
                <button wire:click="$set('search', '')" class="mt-6 px-6 py-2 bg-white border border-gray-200 text-gray-600 font-bold rounded-full hover:bg-gray-50 hover:text-primary-900 transition-colors shadow-sm">
                    Limpiar Búsqueda
                </button>
            </div>
        @endif
    </div>
</div>
