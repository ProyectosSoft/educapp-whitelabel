<x-admin-layout>
    {{-- Main Container --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Corporate Header --}}
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
             {{-- Abstract bg decoration --}}
             <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
             
             <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-user-edit text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">Editar Rol</h2>
                    <p class="text-blue-100 text-sm font-medium">Modifica los permisos asignados a este perfil</p>
                 </div>
             </div>
             
             <a href="{{ route('admin.roles.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                 <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Lista
             </a>
        </div>

        {{-- Content --}}
        <div class="p-8 relative z-10">
            {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'put', 'class' => 'space-y-8']) !!}
                
                <div class="bg-gray-50/50 p-8 rounded-[2rem] border border-gray-100 shadow-inner">
                    @include('admin.roles.partial.form')
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-[#335A92] hover:bg-[#284672] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center text-lg">
                        <i class="fas fa-sync-alt mr-2"></i> Actualizar Rol
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</x-admin-layout>
