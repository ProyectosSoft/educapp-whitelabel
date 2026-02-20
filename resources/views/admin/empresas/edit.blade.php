<x-admin-layout>
    <div x-data="{ activeTab: 'general' }">
        {{-- Tabs Navigation --}}
        <div class="flex flex-wrap items-center gap-2 p-1.5 bg-gray-100 rounded-2xl mb-8 w-fit shadow-inner border border-gray-200">
            <button @click="activeTab = 'general'" :class="{ 'bg-white text-[#335A92] shadow-sm ring-1 ring-black/5 font-bold': activeTab === 'general', 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50 font-medium': activeTab !== 'general' }" class="px-6 py-3 rounded-xl text-sm transition-all flex items-center">
                <i class="fas fa-building mr-2" :class="activeTab === 'general' ? 'text-[#ECBD2D]' : 'text-gray-400'"></i> Información General
            </button>
            <button @click="activeTab = 'departamentos'" :class="{ 'bg-white text-[#335A92] shadow-sm ring-1 ring-black/5 font-bold': activeTab === 'departamentos', 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50 font-medium': activeTab !== 'departamentos' }" class="px-6 py-3 rounded-xl text-sm transition-all flex items-center">
                <i class="fas fa-sitemap mr-2" :class="activeTab === 'departamentos' ? 'text-[#ECBD2D]' : 'text-gray-400'"></i> Departamentos
            </button>
            <button @click="activeTab = 'invitaciones'" :class="{ 'bg-white text-[#335A92] shadow-sm ring-1 ring-black/5 font-bold': activeTab === 'invitaciones', 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50 font-medium': activeTab !== 'invitaciones' }" class="px-6 py-3 rounded-xl text-sm transition-all flex items-center">
                <i class="fas fa-ticket-alt mr-2" :class="activeTab === 'invitaciones' ? 'text-[#ECBD2D]' : 'text-gray-400'"></i> Invitaciones
            </button>
        </div>

        {{-- Tab 1: General --}}
        <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        {{-- Abstract bg decoration --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-edit text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-2xl font-bold tracking-tight">{{ Auth::user()->hasRole('Administrador') ? 'Editar Empresa' : 'Mi Empresa' }}</h2>
                    <p class="text-blue-100 text-sm font-medium">Gestión de la información corporativa</p>
                 </div>
            </div>
            
            @if(Auth::user()->hasRole('Administrador'))
            <a href="{{ route('admin.empresas.index') }}" class="relative z-10 px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all border border-white/20 shadow-sm hover:shadow-md flex items-center group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i> Volver a Lista
            </a>
            @endif
        </div>

        <div class="p-8 relative z-10">
            {!! Form::model($empresa, ['route' => ['admin.empresas.update', $empresa], 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'space-y-8']) !!}
                
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="text-lg font-bold text-[#335A92] mb-6 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i> Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Nombre --}}
                        <div>
                            {!! Form::label('nombre', 'Nombre de la Empresa', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('nombre', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 ' . (Auth::user()->hasRole('Administrador') ? '' : 'bg-gray-100 cursor-not-allowed text-gray-500'),
                                    'placeholder' => 'Ej: Grupo Effi',
                                    'id' => 'nombre',
                                    'readonly' => !Auth::user()->hasRole('Administrador')
                                ]) !!}
                            </div>
                            @error('nombre') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            {!! Form::label('slug', 'URL Personalizada (Slug)', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-link text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('slug', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400 ' . (Auth::user()->hasRole('Administrador') ? '' : 'bg-gray-100 cursor-not-allowed text-gray-500'),
                                    'placeholder' => 'Ej: grupo-effi',
                                    'id' => 'slug',
                                    'readonly' => !Auth::user()->hasRole('Administrador')
                                ]) !!}
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium bg-blue-50/50 p-2 rounded-lg border border-blue-100 inline-block">
                                <i class="fas fa-globe mr-1 text-blue-400"></i> Link: <span class="text-blue-600">educapp.com/registro?empresa={{ $empresa->slug }}</span>
                            </p>
                            @error('slug') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-6">
                         {{-- NIT --}}
                        <div>
                            {!! Form::label('nit', 'NIT / Identificador (Opcional)', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('nit', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Ej: 900.123.456-7'
                                ]) !!}
                            </div>
                            @error('nit') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        {{-- CEO Nombre --}}
                        <div>
                            {!! Form::label('ceo_nombre', 'Nombre del CEO', ['class' => 'block font-bold text-sm text-[#335A92] mb-2']) !!}
                             <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tie text-gray-400 group-focus-within:text-[#ECBD2D] transition-colors"></i>
                                </div>
                                {!! Form::text('ceo_nombre', null, [
                                    'class' => 'pl-11 w-full rounded-xl border-gray-200 bg-white focus:bg-white shadow-sm focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition-all font-medium py-3 text-gray-800 placeholder-gray-400',
                                    'placeholder' => 'Quien firma los certificados'
                                ]) !!}
                            </div>
                            @error('ceo_nombre') <span class="text-red-600 text-xs font-bold mt-1 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Firma Digital --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                        <h3 class="text-lg font-bold text-[#335A92] flex items-center">
                            <i class="fas fa-signature mr-2"></i> Firma Digital del CEO
                        </h3>
                        @if($empresa->ceo_firma)
                            <div class="mt-2 md:mt-0 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200 flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Firma Recibida
                            </div>
                        @else
                             <div class="mt-2 md:mt-0 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold border border-yellow-200 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> Pendiente
                            </div>
                        @endif
                    </div>
                    
                     <div id="ceo-signature-wrapper" x-data="{ fileName: '', tab: 'upload', signaturePad: null }" 
                          x-init="
                            signaturePad = new SignaturePad(document.getElementById('signature-pad-ceo'), {
                                backgroundColor: 'rgba(255, 255, 255, 0)',
                                penColor: 'rgb(0, 0, 0)'
                            });
                            signaturePad.addEventListener('endStroke', () => {
                               document.getElementById('ceo_firma_data').value = signaturePad.toDataURL('image/png');
                            });
                          ">
                        
                        <div class="flex flex-col md:flex-row gap-8">
                             @if($empresa->ceo_firma)
                                <div class="w-full md:w-1/3">
                                    <p class="text-xs text-gray-500 font-bold mb-2 uppercase tracking-wide">Firma Actual</p>
                                    <div class="p-4 bg-white border border-gray-200 rounded-xl flex items-center justify-center">
                                        <img src="{{ Storage::disk('do')->url($empresa->ceo_firma) }}" alt="Firma Actual" class="h-24 w-auto object-contain">
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2 text-center">Sube una nueva firma para reemplazarla</p>
                                </div>
                            @endif

                             <div class="w-full @if($empresa->ceo_firma) md:w-2/3 @endif">
                                {{-- Tabs --}}
                                <div class="flex space-x-1 mb-4 bg-white p-1 rounded-xl border border-gray-200 w-fit shadow-sm">
                                    <button type="button" @click="tab = 'upload'; document.getElementById('ceo_firma_data').value = '';" :class="{'bg-[#335A92] text-white shadow-md': tab === 'upload', 'text-gray-500 hover:bg-gray-50': tab !== 'upload'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center">
                                        <i class="fas fa-cloud-upload-alt mr-2"></i> Subir Imagen
                                    </button>
                                    <button type="button" @click="tab = 'draw'; setTimeout(() => { signaturePad.on(); window.dispatchEvent(new Event('resize')); }, 100)" :class="{'bg-[#335A92] text-white shadow-md': tab === 'draw', 'text-gray-500 hover:bg-gray-50': tab !== 'draw'}" class="px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center">
                                        <i class="fas fa-pen-nib mr-2"></i> Dibujar
                                    </button>
                                </div>

                                {{-- Upload Tab --}}
                                <div x-show="tab === 'upload'" class="flex items-center justify-center w-full">
                                    <label for="ceo_firma" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer hover:bg-white hover:border-[#335A92] hover:shadow-md transition-all group bg-white relative overflow-hidden">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                            <div class="bg-blue-50 p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                                                <i class="fas fa-file-image text-2xl text-[#335A92]"></i>
                                            </div>
                                            <p class="mb-1 text-sm text-gray-500 font-medium" x-show="!fileName"><span class="font-bold text-[#335A92]">Haz clic para subir</span> o arrastra</p>
                                            <p class="mb-1 text-sm text-[#335A92] font-bold" x-show="fileName" x-text="fileName"></p>
                                        </div>
                                        {!! Form::file('ceo_firma', [
                                            'id' => 'ceo_firma', 
                                            'class' => 'hidden', 
                                            'accept' => 'image/*', 
                                            'onchange' => 'if(this.files.length > 0) { this.closest("[x-data]").__x.$data.fileName = this.files[0].name; }'
                                        ]) !!}
                                    </label>
                                </div>

                                {{-- Draw Tab --}}
                                <div x-show="tab === 'draw'" class="border-2 border-dashed border-gray-300 rounded-2xl p-4 flex flex-col items-center justify-center bg-white">
                                    <canvas id="signature-pad-ceo" class="border border-gray-200 rounded-xl shadow-inner bg-white cursor-crosshair w-full max-w-[500px]" width="500" height="180"></canvas>
                                    <div class="flex justify-between w-full max-w-[500px] mt-4 px-2">
                                        <button type="button" @click="signaturePad.clear(); document.getElementById('ceo_firma_data').value = '';" class="text-xs text-red-500 hover:text-red-700 font-bold uppercase tracking-wider flex items-center bg-red-50 px-3 py-1.5 rounded-lg hover:bg-red-100 transition-colors">
                                            <i class="fas fa-trash mr-1.5"></i> Limpiar
                                        </button>
                                        <input type="hidden" name="ceo_firma_data" id="ceo_firma_data">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('ceo_firma') <span class="text-red-600 text-xs font-bold mt-2 block flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Estado --}}
                <div class="bg-gray-50/50 p-6 rounded-2xl border border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="block font-bold text-[#335A92]">Estado de la Empresa</span>
                        <span class="text-xs text-gray-500">Define si la empresa puede operar en la plataforma</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        {!! Form::checkbox('estado', 1, null, ['class' => 'sr-only peer']) !!}
                        <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-[#335A92]"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700 peer-checked:text-[#335A92] peer-checked:font-bold">Activa</span>
                    </label>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-[#335A92] hover:bg-[#284672] text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-900/20 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center text-lg">
                        <i class="fas fa-save mr-2"></i> Actualizar Empresa
                    </button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>

    {{-- Departments Section --}}
    <div x-show="activeTab === 'departamentos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative" x-data="{ openCreateModal: false, openEditModal: false, editAction: '', editName: '', editBoss: '', editBossSignature: '' }">
        <div class="px-8 py-6 bg-[#335A92] text-white flex flex-col sm:flex-row justify-between items-center gap-4 relative overflow-hidden">
            <div class="relative z-10 flex items-center gap-4">
                 <div class="bg-white/10 p-3 rounded-xl backdrop-blur-sm shadow-inner text-[#ECBD2D]">
                     <i class="fas fa-sitemap text-2xl"></i>
                 </div>
                 <div>
                    <h2 class="text-xl font-bold tracking-tight">Departamentos Asociados</h2>
                    <p class="text-blue-100 text-sm font-medium">Gestión de áreas y jefaturas</p>
                 </div>
            </div>
             <button @click="openCreateModal = true" type="button" class="relative z-10 px-5 py-2.5 bg-[#ECBD2D] hover:bg-[#d4aa27] text-[#335A92] font-bold rounded-xl shadow-lg transition-all flex items-center transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Agregar Departamento
            </button>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-white uppercase bg-[#335A92] border-b border-[#335A92]">
                    <tr>
                         <th scope="col" class="px-8 py-5 font-bold tracking-wider">Nombre</th>
                         <th scope="col" class="px-8 py-5 font-bold tracking-wider">Jefe Inmediato</th>
                         <th scope="col" class="px-8 py-5 font-bold tracking-wider">Firma</th>
                         <th scope="col" class="px-8 py-5 font-bold tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($empresa->departamentos as $depto)
                        <tr class="bg-white even:bg-[#335A92]/5 hover:bg-[#477EB1]/10 transition duration-200">
                            <td class="px-8 py-5 font-bold text-gray-800">{{ $depto->nombre }}</td>
                            <td class="px-8 py-5">{{ $depto->jefe_nombre }}</td>
                            <td class="px-8 py-5">
                                @if($depto->jefe_firma)
                                    <div class="p-1 bg-white border border-gray-100 rounded-lg shadow-sm w-fit">
                                         <img src="{{ Storage::disk('do')->url($depto->jefe_firma) }}" class="h-8 w-auto" title="Firma Cargada">
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center space-x-2">
                                <button @click="openEditModal = true; 
                                                editAction = '{{ route('admin.departamentos.update', $depto) }}'; 
                                                editName = '{{ $depto->nombre }}'; 
                                                editBoss = '{{ $depto->jefe_nombre }}';" 
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-[#ECBD2D] hover:text-[#335A92] hover:border-[#ECBD2D] transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </button>
                                <form action="{{ route('admin.departamentos.destroy', $depto) }}" method="POST" class="inline-block delete-form">
                                    @csrf @method('delete')
                                    <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-400 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-500 bg-gray-50">
                                <i class="fas fa-folder-open text-4xl text-gray-300 mb-2"></i>
                                <p>No hay departamentos registrados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Create Modal --}}
        <div x-show="openCreateModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openCreateModal" @click="openCreateModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="openCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    {{-- Modal Header --}}
                    <div class="bg-[#335A92] px-4 py-3 sm:px-6">
                        <h3 class="text-lg leading-6 font-bold text-white flex items-center" id="modal-title">
                            <i class="fas fa-plus-circle mr-2"></i> Nuevo Departamento
                        </h3>
                    </div>

                    <form action="{{ route('admin.departamentos.store') }}" method="POST" enctype="multipart/form-data" id="createDeptoForm">
                        @csrf
                        <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-[#335A92] mb-1">Nombre Departamento</label>
                                <input type="text" name="nombre" required class="w-full rounded-xl border-gray-300 focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition py-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#335A92] mb-1">Nombre Jefe Inmediato</label>
                                <input type="text" name="jefe_nombre" required class="w-full rounded-xl border-gray-300 focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition py-2.5">
                            </div>
                            
                            {{-- Firma Create Tabs --}}
                            <div x-data="{ tab: 'upload', signaturePad: null }" 
                                 x-init="$watch('openCreateModal', value => {
                                    if (value) {
                                        setTimeout(() => {
                                            if (!signaturePad) {
                                                signaturePad = new SignaturePad(document.getElementById('signature-pad-depto-create'), {
                                                    backgroundColor: 'rgba(255, 255, 255, 0)', penColor: 'rgb(0, 0, 0)'
                                                });
                                                signaturePad.addEventListener('endStroke', () => {
                                                   document.getElementById('chef_firma_create_data').value = signaturePad.toDataURL('image/png');
                                                });
                                            }
                                            signaturePad.on(); window.dispatchEvent(new Event('resize'));
                                        }, 200);
                                    }
                                 })">
                                 <label class="block text-sm font-bold text-[#335A92] mb-1">Firma Jefe</label>
                                 <div class="flex space-x-1 mb-2 bg-gray-100 p-1 rounded-lg w-fit">
                                    <button type="button" @click="tab = 'upload'; document.getElementById('chef_firma_create_data').value = '';" :class="{'bg-white text-[#335A92] shadow': tab === 'upload', 'text-gray-500': tab !== 'upload'}" class="px-3 py-1 rounded text-xs font-bold transition">Subir</button>
                                    <button type="button" @click="tab = 'draw'; setTimeout(() => { signaturePad.on(); window.dispatchEvent(new Event('resize')); }, 100)" :class="{'bg-white text-[#335A92] shadow': tab === 'draw', 'text-gray-500': tab !== 'draw'}" class="px-3 py-1 rounded text-xs font-bold transition">Dibujar</button>
                                 </div>

                                 <div x-show="tab === 'upload'">
                                     <input type="file" name="jefe_firma" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#335A92]/10 file:text-[#335A92] hover:file:bg-[#335A92]/20">
                                 </div>
                                 <div x-show="tab === 'draw'" class="border border-gray-300 rounded-xl p-2 bg-gray-50">
                                     <canvas id="signature-pad-depto-create" class="bg-white w-full border border-gray-200 rounded-lg" width="400" height="150"></canvas>
                                     <button type="button" @click="signaturePad.clear(); document.getElementById('chef_firma_create_data').value = '';" class="text-xs text-red-500 font-bold mt-1 uppercase">Borrar</button>
                                     <input type="hidden" name="jefe_firma_data" id="chef_firma_create_data">
                                 </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-4 py-2.5 bg-[#335A92] text-base font-bold text-white hover:bg-[#284672] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
                            <button @click="openCreateModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Edit Modal --}}
        <div x-show="openEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
             <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openEditModal" @click="openEditModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="openEditModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    {{-- Modal Header --}}
                    <div class="bg-[#335A92] px-4 py-3 sm:px-6">
                        <h3 class="text-lg leading-6 font-bold text-white flex items-center">
                            <i class="fas fa-edit mr-2"></i> Editar Departamento
                        </h3>
                    </div>

                    <form :action="editAction" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-[#335A92] mb-1">Nombre Departamento</label>
                                <input type="text" name="nombre" x-model="editName" required class="w-full rounded-xl border-gray-300 focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition py-2.5">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#335A92] mb-1">Nombre Jefe Inmediato</label>
                                <input type="text" name="jefe_nombre" x-model="editBoss" required class="w-full rounded-xl border-gray-300 focus:border-[#335A92] focus:ring focus:ring-[#335A92]/20 transition py-2.5">
                            </div>
                            
                            {{-- Firma Edit Tabs --}}
                            <div x-data="{ tab: 'upload', signaturePad: null }" 
                                 x-init="$watch('openEditModal', value => {
                                    if (value) {
                                        setTimeout(() => {
                                            if (!signaturePad) {
                                                signaturePad = new SignaturePad(document.getElementById('signature-pad-depto-edit'), {
                                                    backgroundColor: 'rgba(255, 255, 255, 0)', penColor: 'rgb(0, 0, 0)'
                                                });
                                                 signaturePad.addEventListener('endStroke', () => {
                                                   document.getElementById('chef_firma_edit_data').value = signaturePad.toDataURL('image/png');
                                                });
                                            }
                                            signaturePad.on(); window.dispatchEvent(new Event('resize'));
                                        }, 200);
                                    }
                                 })">
                                 <label class="block text-sm font-bold text-[#335A92] mb-1">Actualizar Firma</label>
                                 <div class="flex space-x-1 mb-2 bg-gray-100 p-1 rounded-lg w-fit">
                                    <button type="button" @click="tab = 'upload'; document.getElementById('chef_firma_edit_data').value = '';" :class="{'bg-white text-[#335A92] shadow': tab === 'upload', 'text-gray-500': tab !== 'upload'}" class="px-3 py-1 rounded text-xs font-bold transition">Subir</button>
                                    <button type="button" @click="tab = 'draw'; setTimeout(() => { signaturePad.on(); window.dispatchEvent(new Event('resize')); }, 100)" :class="{'bg-white text-[#335A92] shadow': tab === 'draw', 'text-gray-500': tab !== 'draw'}" class="px-3 py-1 rounded text-xs font-bold transition">Dibujar</button>
                                 </div>

                                 <div x-show="tab === 'upload'">
                                     <input type="file" name="jefe_firma" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-[#335A92]/10 file:text-[#335A92] hover:file:bg-[#335A92]/20">
                                     <p class="text-xs text-gray-400 mt-1 italic">Deja vacío para mantener la actual.</p>
                                 </div>
                                 <div x-show="tab === 'draw'" class="border border-gray-300 rounded-xl p-2 bg-gray-50">
                                     <canvas id="signature-pad-depto-edit" class="bg-white w-full border border-gray-200 rounded-lg" width="400" height="150"></canvas>
                                     <button type="button" @click="signaturePad.clear(); document.getElementById('chef_firma_edit_data').value = '';" class="text-xs text-red-500 font-bold mt-1 uppercase">Borrar</button>
                                     <input type="hidden" name="jefe_firma_data" id="chef_firma_edit_data">
                                 </div>
                            </div>

                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-4 py-2.5 bg-[#335A92] text-base font-bold text-white hover:bg-[#284672] focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Actualizar</button>
                            <button @click="openEditModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2.5 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
    {{-- Invitations Section --}}
    <div x-show="activeTab === 'invitaciones'" class="mt-0">
        @livewire('admin.empresa.invitation-manager', ['empresa' => $empresa], key('invitation-manager-'.$empresa->id))
    </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
        <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const nombreInput = document.getElementById('nombre');
                const slugInput = document.getElementById('slug');
                const slugPreview = document.getElementById('slug-preview');

                function stringToSlug(str) {
                    return str
                        .toLowerCase()
                        .trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                }

                nombreInput.addEventListener('input', function() {
                    const slug = stringToSlug(this.value);
                    slugInput.value = slug;
                    if(slugPreview) slugPreview.textContent = slug;
                });

                slugInput.addEventListener('input', function() {
                    if(slugPreview) slugPreview.textContent = this.value;
                });
            });
        </script>
    @endpush
</x-admin-layout>
