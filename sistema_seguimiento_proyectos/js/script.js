// Obtener elementos HTML relevantes
const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
const nuevoProyectoForm = document.getElementById('nuevoProyectoForm');
const botonEditarProyecto = document.getElementById('btnEditarProyecto');
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
        formularioEdicion.style.display = 'block';
        tablaProyectos.style.display = 'none';

        // Llenar el formulario con los datos del proyecto seleccionado
        idProyectoForm.value = event.target.dataset.id;
        nombreProyectoInput.value = event.target.dataset.nombre;
        descripcionInput.value = event.target.dataset.descripcion;
        clienteInput.value = event.target.dataset.cliente;
        desarrolladorInput.value = event.target.dataset.desarrollador;
        fechaInicioInput.value = event.target.dataset.fechaInicio;
        fechaEntregaEstimadaInput.value = event.target.dataset.fechaEntrega;
        estadoForm.value = event.target.dataset.estado;
        btnAgregarEditarProyecto.textContent = 'Editar Proyecto'; // Cambiar texto del botón
    } else if (event.target.dataset.action === 'finalizar') {
        // Marcar el proyecto como finalizado en la interfaz de usuario (puedes personalizar esta parte)
        const idProyecto = event.target.dataset.id;
    }
});

// Función para finalizar un proyecto
function finalizarProyecto(idProyecto) {
    // Mostrar un mensaje de advertencia antes de finalizar el proyecto
    if (confirm("¿Estás seguro de que deseas finalizar este proyecto?")) {
        // Realizar la solicitud AJAX para finalizar el proyecto
        $.ajax({
            type: "POST",
            url: "../php/funcion_proyectos.php", // Reemplaza "ruta_correcta" con la ruta correcta de tu archivo PHP
            data: { confirmar_finalizar_proyecto: true, id_proyecto: idProyecto }, // Agrega los datos necesarios
            dataType: "json",
            success: function (response) {
                if (response.exito) {
                    // Mostrar mensaje de éxito
                    alert("Proyecto finalizado con éxito");
                    location.reload(); // Recargar la página después de finalizar
                } else {
                    alert("Error al finalizar el proyecto");
                }
            },
            error: function () {
                alert("Error al finalizar el proyecto");
            }
        });
    }
}

tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'finalizar') {
        finalizarProyecto(event.target.dataset.id);
    }
});
