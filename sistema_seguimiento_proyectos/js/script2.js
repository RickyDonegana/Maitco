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

// Agregar evento para el botón "Agregar Nuevo Proyecto"
btnNuevoProyecto.addEventListener('click', () => {
    // Ocultar la tabla de proyectos y mostrar el formulario
    tablaProyectos.style.display = 'none';
    nuevoProyectoForm.style.display = 'block';

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
});

// Agregar evento para el botón "Agregar" del formulario
btnAgregarEditarProyecto.addEventListener('click', (event) => {
    event.preventDefault(); // Evitar que se envíe el formulario

    // Validar que todos los campos estén completos
    if (
        nombreProyectoInput.value.trim() === '' ||
        descripcionInput.value.trim() === '' ||
        clienteInput.value.trim() === '' ||
        desarrolladorInput.value.trim() === '' ||
        fechaInicioInput.value.trim() === '' ||
        fechaEntregaEstimadaInput.value.trim() === ''
    ) {
        alert('¡Atención! Por favor, complete todos los campos.');
        return;
    }

    // Mostrar mensaje de confirmación
    const confirmacion = confirm(
        `¿Está seguro de que desea ${idProyectoForm.value ? 'editar' : 'agregar'
        } este proyecto?`
    );

    if (confirmacion) {
        // Ocultar el formulario y mostrar la tabla de proyectos
        nuevoProyectoForm.style.display = 'none';
        tablaProyectos.style.display = 'table';

        // Cambiar el texto del botón "Agregar Nuevo Proyecto" a "Editar"
        btnNuevoProyecto.innerText = 'Editar Proyecto';

        // Aquí puedes enviar el formulario o realizar otras acciones según tu lógica
    }
});

// Event listener para botones "Editar" en la tabla de proyectos
tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'editar') {
        // Ocultar la tabla de proyectos y mostrar el formulario para editar proyectos
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

        // Mostrar mensaje de confirmación
        const confirmacion = confirm(
            `¿Está seguro de que desea finalizar este proyecto?`
        );

        if (confirmacion) {
            finalizarProyecto(idProyecto);
        }
    }
});

// Función para marcar el proyecto como finalizado en la interfaz de usuario (puedes personalizar esto)
function finalizarProyecto(idProyecto) {
    // Eliminar el proyecto de la tabla
    const filaProyecto = document.getElementById(`filaProyecto_${idProyecto}`);
    if (filaProyecto) {
        filaProyecto.remove();
    }
}
