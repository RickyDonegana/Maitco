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

// Función para finalizar el proyecto en la interfaz de usuario y actualizar su estado en la base de datos
function finalizarProyecto(idProyecto) {
    // Obtener el estado actual del proyecto
    const estadoProyectoInput = document.getElementById(`estado_${idProyecto}`);
    if (!estadoProyectoInput) {
        console.error(`No se encontró el elemento de estado para el proyecto con ID ${idProyecto}`);
        return;
    }
    
    const estadoProyecto = estadoProyectoInput.value;

    // Verificar si el estado es "cierre" o si se confirma finalizar el proyecto
    if (estadoProyecto === 'cierre' || confirm('¿Está seguro de que desea finalizar este proyecto? Esta acción ocultará el proyecto en el sistema web, pero no lo eliminará de la base de datos.')) {
        // Ocultar el proyecto de la tabla en la interfaz de usuario
        const filaProyecto = document.getElementById(`filaProyecto_${idProyecto}`);
        if (filaProyecto) {
            filaProyecto.style.display = 'none'; // Ocultar la fila en lugar de eliminarla
        }

        // Cambiar el estado del proyecto a "cierre" en la base de datos (puedes implementar esto mediante una solicitud al servidor)
        // Actualizar el estado del proyecto en la interfaz de usuario
        estadoProyectoInput.value = 'cierre';

        alert('El proyecto se ha finalizado y se ha ocultado en el sistema web.');
    }
}
