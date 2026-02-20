<div>
    {{-- Header --}}
    <div class="mb-8 pl-1">
        <h1 class="text-3xl font-bold text-[#335A92]">Configuración de la Cuenta</h1>
        <div class="flex items-center text-sm font-medium text-gray-400 mt-2">
            <a href="{{ route('home') }}" class="hover:text-[#335A92] transition-colors">Inicio</a>
            <i class="fas fa-chevron-right text-[10px] mx-3 opacity-50"></i>
            <span class="text-gray-600">Configuración</span>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-3xl">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
            
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#335A92]/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

            <div class="px-8 py-6 bg-white border-b border-gray-100 flex items-center">
                <div class="bg-blue-50 text-[#335A92] p-3 rounded-xl mr-4 shadow-sm">
                    <i class="fas fa-lock text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Cambiar Contraseña
                    </h3>
                    <p class="text-xs text-gray-500 font-medium">Actualiza tu clave de acceso periódico para mayor seguridad</p>
                </div>
            </div>
            
            <form wire:submit.prevent="updatePassword">
                <div class="p-8 space-y-6">
                    @if (session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl relative flex items-center shadow-sm" role="alert">
                            <i class="fas fa-check-circle text-xl mr-3"></i>
                            <span class="block sm:inline font-medium">{{ session('success') }}</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer text-green-500 hover:text-green-800 transition-colors" onclick="this.parentElement.style.display='none';">
                                <i class="fas fa-times"></i>
                            </span>
                        </div>
                    @endif

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-bold text-[#335A92] mb-2">Contraseña Actual</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                            </div>
                            <input type="password" id="current_password" wire:model.defer="state.current_password"
                                   placeholder="Ingresa tu contraseña actual"
                                   class="pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 text-sm">
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-xs font-bold mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-[#335A92] mb-2">Nueva Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                <input type="password" id="password" wire:model.defer="state.password"
                                       placeholder="Mínimo 8 caracteres"
                                       class="pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 text-sm">
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-xs font-bold mt-2 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-[#335A92] mb-2">Confirmar Contraseña</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-check-double text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                <input type="password" id="password_confirmation" wire:model.defer="state.password_confirmation"
                                       placeholder="Repite la nueva contraseña"
                                       class="pl-11 w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
                    <p class="text-xs text-gray-400 mr-4 font-medium italic">Todos los campos son obligatorios</p>
                    <button type="submit" wire:loading.attr="disabled"
                            class="inline-flex items-center px-6 py-3 bg-[#335A92] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-[#284672] active:bg-[#1a2e4b] focus:outline-none focus:ring-2 focus:ring-[#335A92] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5">
                        <span wire:loading wire:target="updatePassword" class="mr-2">
                             <i class="fas fa-spinner fa-spin"></i>
                        </span>
                        <i class="fas fa-save mr-2" wire:loading.remove wire:target="updatePassword"></i> Actualizar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
