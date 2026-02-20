<x-admin-layout>
    <div class="container mx-auto px-6 py-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden relative">
            
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary-400 opacity-10 filter blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-primary-400 opacity-10 filter blur-3xl"></div>

            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 dark:border-gray-600 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm relative z-10 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-award text-primary-600 mr-2 bg-primary-50 p-2 rounded-lg"></i>
                        <span class="tracking-tight">Mis Certificaciones</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-10">Historial de certificaciones emitidas para: <span class="font-bold text-primary-600">{{ $empresa->nombre }}</span></p>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-8 relative z-10">
                
                {{-- Placeholder / Content Area --}}
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center rounded-2xl bg-gray-50 dark:bg-gray-700/50 border-2 border-dashed border-gray-200 dark:border-gray-600">
                    <div class="bg-yellow-50 dark:bg-yellow-900/30 p-4 rounded-full mb-4">
                        <i class="fas fa-award text-4xl text-yellow-500"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Panel de Certificaciones</h3>
                    <p class="text-gray-500 dark:text-gray-400 max-w-sm mb-6">
                        Aquí próximamente podrás ver el reporte de certificaciones y descargarlas.
                    </p>
                    <button class="px-5 py-2.5 bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-300 font-bold rounded-xl cursor-not-allowed opacity-75">
                         <i class="fas fa-file-download mr-2"></i> Descargar Reporte (Próximamente)
                    </button>
                </div>

            </div>
        </div>

    </div>
</x-admin-layout>
