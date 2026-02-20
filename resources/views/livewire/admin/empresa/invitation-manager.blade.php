<div>
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
        
        {{-- Background Effects --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

        <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                <i class="fas fa-ticket-alt text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                <span class="tracking-tight">Gestión de Invitaciones</span>
            </h2>
            <p class="text-xs text-gray-500 mt-1 ml-10">Genera enlaces seguros para registrar instructores y estudiantes automáticamente.</p>
        </div>

        <div class="p-8 relative z-10">
            {{-- Success Message --}}
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-xl p-4 flex items-start shadow-sm" role="alert">
                    <i class="fas fa-check-circle text-green-500 mt-1 mr-3 text-lg"></i>
                    <div class="text-green-800 dark:text-green-200 text-sm">
                        <span class="font-bold block mb-1">¡Invitación Creada con Éxito!</span>
                        {!! session('message') !!}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Form Section --}}
                <div class="lg:col-span-1 space-y-6">
                    <div>
                        <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Rol de Usuario</label>
                        <div class="relative">
                            <i class="fas fa-user-tag absolute left-3 top-3 text-gray-400"></i>
                            <select wire:model="role" class="pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="Estudiante">Estudiante</option>
                                <option value="Instructor">Instructor</option>
                            </select>
                        </div>
                        @error('role') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Departamento (Opcional)</label>
                        <div class="relative">
                            <i class="fas fa-building absolute left-3 top-3 text-gray-400"></i>
                            <select wire:model="departamento_id" class="pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">Cualquiera / Ninguno</option>
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto->id }}">{{ $depto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Usos Máx.</label>
                            <input type="number" wire:model="max_uses" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-center">
                            @error('max_uses') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Expira (Días)</label>
                            <input type="number" wire:model="expires_in_days" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-center">
                             @error('expires_in_days') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Email Específico (Opcional)</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                            <input type="email" wire:model="email" placeholder="Dejar vacío para público" class="pl-10 w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                         @error('email') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <button wire:click="create" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transition transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-magic mr-2"></i> Generar Link
                    </button>
                </div>

                {{-- Table Section --}}
                <div class="lg:col-span-2">
                     <h3 class="font-bold text-gray-800 dark:text-white mb-4 flex items-center">
                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-1 px-3 rounded-lg text-xs mr-2 uppercase tracking-wide">Historial</span>
                        Invitaciones Activas
                    </h3>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Rol / Depto</th>
                                        <th scope="col" class="px-6 py-3 text-center">Usos</th>
                                        <th scope="col" class="px-6 py-3">Link</th>
                                        <th scope="col" class="px-6 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($invitations as $invitation)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 rounded-full {{ $invitation->role_name == 'Instructor' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center font-bold text-xs uppercase">
                                                        {{ substr($invitation->role_name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="font-bold text-gray-900 dark:text-white">{{ $invitation->role_name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $invitation->departamento->nombre ?? 'General' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $invitation->current_uses >= $invitation->max_uses ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $invitation->current_uses }} / {{ $invitation->max_uses }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" readonly value="{{ route('invite.accept', $invitation->uuid) }}" class="text-xs border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded w-32 focus:ring-0" onclick="this.select()">
                                                    <button onclick="navigator.clipboard.writeText('{{ route('invite.accept', $invitation->uuid) }}')" class="text-gray-400 hover:text-indigo-600 transition" title="Copiar"><i class="fas fa-copy"></i></button>
                                                </div>
                                                <div class="text-[10px] text-gray-400 mt-1">
                                                    Expira: {{ $invitation->expires_at ? $invitation->expires_at->format('d/m/Y') : 'Nunca' }}
                                                    @if($invitation->expires_at && $invitation->expires_at->isPast())
                                                        <span class="text-red-500 font-bold">(Expirado)</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <button wire:click="showLogs({{ $invitation->id }})" class="text-indigo-400 hover:text-indigo-600 bg-indigo-50 p-2 rounded-full hover:bg-indigo-100 transition mr-2" title="Ver Historial"><i class="fas fa-history"></i></button>
                                                <button wire:click="delete({{ $invitation->id }})" wire:confirm="¿Eliminar invitación?" class="text-red-400 hover:text-red-600 bg-red-50 p-2 rounded-full hover:bg-red-100 transition"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                                No hay invitaciones activas. Genera una nueva para comenzar.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Log Modal --}}
    @if($showLogModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeLogModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white flex items-center" id="modal-title">
                                    <i class="fas fa-history text-indigo-500 mr-2"></i> Historial de Uso de Invitación
                                </h3>
                                <div class="mt-6">
                                    <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-700">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha y Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                @forelse($logs as $log)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $log->user->name ?? 'Usuario Eliminado' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $log->user->email ?? '-' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs font-mono">{{ $log->ip_address }}</span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $log->created_at->format('d/m/Y h:i A') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">
                                                            Sin registros de uso todavía.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeLogModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
