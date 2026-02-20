<x-admin-layout>
    {{-- Main Container with Clean Corporate Design --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            {{-- Abstract bg decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-1">
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-user-edit text-xl text-[#ECBD2D]"></i>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight">Editar Usuario</h2>
                </div>
                <p class="text-blue-100 text-sm font-medium ml-12">Gestiona los roles y permisos de acceso para este usuario</p>
            </div>
            
            <a href="{{ route('admin.users.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver
            </a>
        </div>

        {{-- Content Area --}}
        <div class="p-8">
            
            {{-- User Profile Summary Card --}}
            <div class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#335A92]/5 rounded-full blur-xl -mr-10 -mt-10"></div>
                
                <div class="relative flex-shrink-0">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <img class="h-20 w-20 rounded-full object-cover border-4 border-white shadow-md" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                    @else
                        <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-[#477EB1] to-[#335A92] text-white text-3xl font-bold border-4 border-white shadow-md">
                            {{ substr($user->name, 0, 1) }}
                        </span>
                    @endif
                    <div class="absolute bottom-1 right-1 h-5 w-5 rounded-full bg-[#ECBD2D] border-4 border-white shadow-sm flex items-center justify-center" title="Usuario">
                         <i class="fas fa-check text-[8px] text-[#335A92]"></i>
                    </div>
                </div>
                
                <div class="text-center md:text-left flex-1">
                    <h3 class="text-2xl font-bold text-[#335A92] mb-1">{{ $user->name }}</h3>
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm text-gray-500">
                        <span class="flex items-center"><i class="far fa-envelope mr-2 text-[#477EB1]"></i> {{ $user->email }}</span>
                        <span class="flex items-center"><i class="far fa-id-card mr-2 text-[#477EB1]"></i> ID: #{{ $user->id }}</span>
                        <span class="flex items-center"><i class="far fa-clock mr-2 text-[#477EB1]"></i> Registrado: {{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Roles Form --}}
            {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
                
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-[#335A92] mb-4 flex items-center">
                        <i class="fas fa-shield-alt mr-2 bg-[#335A92]/10 p-1.5 rounded text-[#335A92]"></i> 
                        Asignación de Roles
                    </h3>
                    <p class="text-gray-500 text-sm mb-6">Selecciona los roles que definen los permisos de este usuario en la plataforma.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($roles as $role)
                            <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 group bg-white hover:border-[#335A92]/30 hover:shadow-md
                                {{ $user->roles->contains($role->id) ? 'border-[#335A92] bg-[#335A92]/5' : 'border-gray-100' }}">
                                
                                {!! Form::checkbox('roles[]', $role->id, null, [
                                    'class' => 'form-checkbox h-5 w-5 text-[#335A92] rounded border-gray-300 focus:ring-[#335A92] transition duration-150 ease-in-out'
                                ]) !!}
                                
                                <span class="ml-3 font-bold transition-colors group-hover:text-[#335A92] 
                                    {{ $user->roles->contains($role->id) ? 'text-[#335A92]' : 'text-gray-600' }}">
                                    {{ $role->name }}
                                </span>
                                
                                {{-- Checkmark indicator for selected items --}}
                                @if($user->roles->contains($role->id))
                                    <div class="absolute top-0 right-0 -mt-2 -mr-2 w-6 h-6 bg-[#ECBD2D] text-[#335A92] rounded-full flex items-center justify-center shadow-sm">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                @endif
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-[#335A92] hover:bg-[#284672] text-white font-bold rounded-xl shadow-lg shadow-blue-900/10 transform hover:-translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>
