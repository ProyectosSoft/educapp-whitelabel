import './bootstrap';
import Swal from 'sweetalert2';

// Global Configuration for SweetAlert2 with Dark Mode and Rounded Styles
// Global Configuration for SweetAlert2 with Dark Mode and Rounded Styles
const swalCustomClass = {
    popup: 'rounded-3xl border border-gray-700 shadow-2xl',
    confirmButton: 'bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200 mx-2',
    cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200 mx-2',
    title: 'text-2xl font-bold',
    htmlContainer: 'text-gray-300',
    actions: 'gap-3'
};

const Toast = Swal.mixin({
    background: '#1f2937', // Dark gray background
    color: '#ffffff',      // White text
    buttonsStyling: false, // Disable default SweetAlert styling
    customClass: swalCustomClass
});

window.Swal = Toast;

window.confirmAction = (options = {}) => {
    return Toast.fire({
        title: options.title || '¿Estás seguro?',
        text: options.text || "¡No podrás revertir esto!",
        icon: options.icon || 'warning',
        showCancelButton: true,
        confirmButtonText: options.confirmButtonText || '¡Sí, eliminar!',
        cancelButtonText: options.cancelButtonText || 'Cancelar',
        // We extend the global customClass
        customClass: {
            ...swalCustomClass, // Inherit base classes
            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200 mx-2', // Red for dangerous actions
            cancelButton: 'bg-gray-600 hover:bg-gray-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transform hover:scale-105 transition-all duration-200 mx-2'
        },
        ...options
    });
};

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
