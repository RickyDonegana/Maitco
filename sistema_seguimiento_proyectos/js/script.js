// Obtener elementos HTML relevantes
const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
const nuevoProyectoForm = document.getElementById('nuevoProyectoForm');
const btnAgregarEditarProyecto = document.getElementById('btnAgregarEditarProyecto');
const tablaProyectos = document.getElementById('tablaProyectos');
const estadoForm = document.getElementById('estado_form');
const idProyectoForm = document.getElementById('id_proyecto_form');
const nombreProyectoInput = document.getElementById('nombre_proyecto');
const descripcionInput = document.getElementById('descripcion');
const clienteInput = document.getElementById('cliente');
const desarrolladorInput = document.getElementById('desarrollador');
const fechaInicioInput = document.getElementById('fecha_inicio');
const fechaEntregaEstimadaInput = document.getElementById('fecha_entrega_estimada');

// Variable para rastrear si el formulario está visible
let formularioVisible = false;

// Función para alternar la visibilidad del formulario y la tabla
function alternarFormularioYTabla() {
    if (formularioVisible) {
        // Si el formulario está visible, ocultarlo y mostrar la tabla
        nuevoProyectoForm.style.display = 'none';
        tablaProyectos.style.display = 'table';
        btnNuevoProyecto.textContent = 'Agregar Nuevo Proyecto';
    } else {
        // Si el formulario está oculto, mostrarlo y ocultar la tabla
        nuevoProyectoForm.style.display = 'block';
        tablaProyectos.style.display = 'none';
        btnNuevoProyecto.textContent = 'Mostrar Proyectos'; // Cambia el texto del botón
    }

    // Cambiar el estado del formularioVisible
    formularioVisible = !formularioVisible;
}

// Agregar evento para el botón "Agregar Nuevo Proyecto"
btnNuevoProyecto.addEventListener('click', () => {
    // Limpiar los campos del formulario
    idProyectoForm.value = '';
    nombreProyectoInput.value = '';
    descripcionInput.value = '';
    clienteInput.value = '';
    desarrolladorInput.value = '';
    fechaInicioInput.value = '';
    fechaEntregaEstimadaInput.value = '';
    estadoForm.value = 'inicio';

    // Cambiar el texto del botón del formulario a "Agregar"
    btnAgregarEditarProyecto.innerText = 'Agregar';

    // Llama a la función para alternar la visibilidad del formulario y la tabla
    alternarFormularioYTabla();
});

// Agregar evento al botón de "Cancelar" en el formulario
const btnCancelar = document.getElementById('btnCancelar');
btnCancelar.addEventListener('click', () => {
    // Llama a la función para alternar la visibilidad del formulario y la tabla
    alternarFormularioYTabla();
});

// Agregar evento al botón "Agregar" o "Editar" en el formulario
btnAgregarEditarProyecto.addEventListener('click', () => {
    // Tu lógica para agregar o editar el proyecto en la base de datos debe ir aquí
    // Después de realizar la acción, puedes llamar a la función para alternar la visibilidad del formulario y la tabla
    alternarFormularioYTabla();
});

// Event listener para botones "Editar" en la tabla de proyectos
tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'editar') {
        // Mostrar el formulario para editar proyectos
        tablaProyectos.style.display = 'none';
        nuevoProyectoForm.style.display = 'block';

        // Llenar el formulario con los datos del proyecto seleccionado
        idProyectoForm.value = event.target.dataset.id;
        nombreProyectoInput.value = event.target.dataset.nombre;
        descripcionInput.value = event.target.dataset.descripcion;
        clienteInput.value = event.target.dataset.cliente;
        desarrolladorInput.value = event.target.dataset.desarrollador;
        fechaInicioInput.value = event.target.dataset.fechaInicio;
        fechaEntregaEstimadaInput.value = event.target.dataset.fechaEntrega;
        estadoForm.value = event.target.dataset.estado;

        // Cambiar el texto del botón del formulario a "Editar"
        btnAgregarEditarProyecto.innerText = 'Editar Proyecto';
    } else if (event.target.dataset.action === 'finalizar') {
        // Marcar el proyecto como finalizado en la interfaz de usuario (puedes personalizar esta parte)
        const idProyecto = event.target.dataset.id;
    }
});

// Función para eliminar el proyecto de la tabla en la interfaz de usuario
function finalizarProyecto(idProyecto) {
    // Mostrar un mensaje de confirmación antes de finalizar
    const confirmacion = confirm('¿Está seguro de que desea finalizar este proyecto?');

    if (confirmacion) {
        // Eliminar el proyecto de la tabla en la interfaz de usuario
        const filaProyecto = document.getElementById(`filaProyecto_${idProyecto}`);
        if (filaProyecto) {
            filaProyecto.remove();
            alert('El proyecto se ha eliminado de la tabla en la interfaz de usuario.');
        } else {
            alert('No se pudo encontrar el proyecto en la tabla.');
        }
    }
}
