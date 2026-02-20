<div class="mb-8">
    {!! Form::label('name', 'Nombre del Rol', ['class' => 'block mb-2 text-sm font-bold text-[#335A92]']) !!}
    <div class="relative group">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <i class="fas fa-id-badge text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
        </div>
        {!! Form::text('name', null, [
            'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400' . ($errors->has('name') ? ' border-red-500 focus:border-red-500 focus:ring-red-200' : ''),
            'placeholder' => 'Ej: Gerente de Ventas'
        ]) !!}
    </div>
    @error('name')
        <p class="mt-2 text-xs font-bold text-red-600 bg-red-50 p-2 rounded-lg flex items-center w-fit">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
        </p>
    @enderror
</div>

<div class="mt-10">
    <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center border-b border-gray-200 pb-2">
        <div class="bg-blue-50 p-2 rounded-lg mr-3 text-[#335A92]">
            <i class="fas fa-shield-alt"></i>
        </div>
        Asignar Permisos del Sistema
    </h3>
    
    @error('permissions')
        <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-100 flex items-center font-bold">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ $message }}
        </div>
    @enderror

    @php
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            $name = strtolower($permission->name);
            if (Str::contains($name, ['examen', 'pregunta', 'dificultad', 'calificar'])) {
                return 'Evaluaciones y Exámenes';
            } elseif (Str::contains($name, ['curso', 'leccion', 'seccion'])) {
                return 'Gestión de Cursos';
            } elseif (Str::contains($name, ['usuario'])) {
                return 'Gestión de Usuarios';
            } elseif (Str::contains($name, ['role'])) {
                return 'Gestión de Roles';
            } elseif (Str::contains($name, ['empresa', 'departamento'])) {
                return 'Gestión Corporativa';
            } elseif (Str::contains($name, ['categoria', 'subcategoria'])) {
                return 'Taxonomía (Categorías)';
            } elseif (Str::contains($name, ['auditoria', 'configuracion'])) {
                return 'Auditoría y Configuración';
            } elseif (Str::contains($name, ['financiero'])) {
                return 'Módulo Financiero';
            } elseif (Str::contains($name, ['dashboard'])) {
                return 'Dashboards';
            }
            return 'Otros Permisos';
        });

        // Sort order
        $order = [
             'Gestión de Cursos',
             'Evaluaciones y Exámenes',
             'Taxonomía (Categorías)',
             'Gestión Corporativa',
             'Módulo Financiero',
             'Gestión de Usuarios',
             'Gestión de Roles',
             'Auditoría y Configuración',
             'Dashboards',
             'Otros Permisos'
        ];
        
        $sortedGroups = $groupedPermissions->sortBy(function ($items, $key) use ($order) {
            return array_search($key, $order) !== false ? array_search($key, $order) : 999;
        });
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($sortedGroups as $groupName => $groupPermissions)
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group/card">
                <div class="absolute top-0 right-0 w-16 h-16 bg-gray-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover/card:scale-150 z-0"></div>
                
                <h4 class="relative z-10 text-sm font-bold text-[#335A92] mb-4 flex items-center uppercase tracking-wide">
                    @switch($groupName)
                        @case('Evaluaciones y Exámenes')
                            <i class="fas fa-file-signature text-purple-500 mr-2 bg-purple-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Gestión de Cursos')
                            <i class="fas fa-book-open text-blue-500 mr-2 bg-blue-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Gestión de Usuarios')
                            <i class="fas fa-users text-green-500 mr-2 bg-green-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Gestión de Roles')
                            <i class="fas fa-user-shield text-red-500 mr-2 bg-red-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Gestión Corporativa')
                            <i class="fas fa-building text-indigo-500 mr-2 bg-indigo-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Taxonomía (Categorías)')
                            <i class="fas fa-tags text-teal-500 mr-2 bg-teal-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Módulo Financiero')
                            <i class="fas fa-wallet text-yellow-500 mr-2 bg-yellow-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Auditoría y Configuración')
                            <i class="fas fa-clipboard-check text-gray-600 mr-2 bg-gray-50 p-1.5 rounded-lg"></i>
                            @break
                        @case('Dashboards')
                            <i class="fas fa-chart-pie text-orange-500 mr-2 bg-orange-50 p-1.5 rounded-lg"></i>
                            @break
                        @default
                            <i class="fas fa-cog text-gray-400 mr-2 bg-gray-50 p-1.5 rounded-lg"></i>
                    @endswitch
                    {{ $groupName }}
                </h4>

                <div class="relative z-10 space-y-2">
                    @foreach ($groupPermissions as $permission)
                        <label class="flex items-start p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors group/item">
                            <div class="flex items-center h-5">
                                {!! Form::checkbox('permissions[]', $permission->id, null, [
                                    'class' => 'w-4 h-4 text-[#335A92] border-gray-300 rounded focus:ring-[#335A92] focus:ring-offset-0 cursor-pointer'
                                ]) !!}
                            </div>
                            <div class="ml-3 text-xs">
                                <span class="font-medium text-gray-600 group-hover/item:text-[#335A92] transition-colors">
                                    {{ $permission->name }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
