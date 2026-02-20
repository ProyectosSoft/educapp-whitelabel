<x-instructor-layout>
    @livewire('author.cursos-index')
</x-instructor-layout>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('info'))
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('info') }}',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#d33',
                    });
                @endif
            });
        </script>
    @endpush
