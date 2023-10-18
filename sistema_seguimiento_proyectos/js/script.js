// Obtener elementos HTML relevantes
const idProyectoForm = document.getElementById('id_proyecto_form');
const nombreProyectoInput = document.getElementById('nombre_proyecto');
const descripcionInput = document.getElementById('descripcion');
const clienteInput = document.getElementById('cliente');
const desarrolladorInput = document.getElementById('desarrollador');
const fechaInicioInput = document.getElementById('fecha_inicio');
const fechaEntregaEstimadaInput = document.getElementById('fecha_entrega_estimada');
const estadoForm = document.getElementById('estado_form');
const btnNuevoProyecto = document.getElementById('btnNuevoProyecto');
const agregarProyectoForm = document.getElementById('agregarProyectoForm');
const editarProyectoForm = document.getElementById('editarProyectoForm');
const tablaProyectos = document.getElementById('tablaProyectos');
const btnAgregar = document.getElementById('btnAgregar');
const btnEditar = document.getElementById('btnEditar');

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
    btnAgregar.innerText = 'Agregar';
});

// Event listener para botones "Editar" en la tabla de proyectos
tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'editar') {
        // Obtener los datos del proyecto seleccionado
        const id = event.target.dataset.id;
        const nombre = event.target.dataset.nombre;
        const descripcion = event.target.dataset.descripcion;
        const cliente = event.target.dataset.cliente;
        const desarrollador = event.target.dataset.desarrollador;
        const fechaInicio = event.target.dataset.fechaInicio;
        const fechaEntrega = event.target.dataset.fechaEntrega;
        const estado = event.target.dataset.estado;

        // Llenar el formulario con los datos del proyecto seleccionado
        idProyectoForm.value = id;
        nombreProyectoInput.value = nombre;
        descripcionInput.value = descripcion;
        clienteInput.value = cliente;
        desarrolladorInput.value = desarrollador;
        fechaInicioInput.value = fechaInicio;
        fechaEntregaEstimadaInput.value = fechaEntrega;
        estadoForm.value = estado;
        btnEditar.textContent = 'Guardar cambios';
    }
    else if (event.target.dataset.action === 'finalizar') {
        const idProyecto = event.target.dataset.id;
        // Mostrar mensaje de advertencia antes de finalizar el proyecto
        if (confirm("¿Estás seguro de que deseas finalizar este proyecto?")) {
            finalizarProyecto(idProyecto);
        }
    }
    else if (event.target.dataset.action === 'cambiarEstado') {
        const idProyecto = event.target.dataset.id;
        const nuevoEstado = event.target.dataset.nuevoEstado;
        cambiarEstado(idProyecto, nuevoEstado);
    }
});

// Función para finalizar un proyecto
function finalizarProyecto(idProyecto) {
    // Realizar la solicitud AJAX para finalizar el proyecto (ajusta la URL y los datos)
    $.ajax({
        type: "POST",
        url: "../php/funcion_proyectos.php", // Reemplaza con la URL correcta
        data: {
            confirmar_finalizar_proyecto: true,
            id_proyecto: idProyecto
        },
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

// Función para cambiar el estado de un proyecto
function cambiarEstado(idProyecto, nuevoEstado) {
    // Mostrar un mensaje de advertencia antes de cambiar el estado
    if (confirm(`¿Estás seguro de que deseas cambiar el estado del proyecto a "${nuevoEstado}"?`)) {
        // Realizar la solicitud AJAX para cambiar el estado del proyecto (ajusta la URL y los datos)
        $.ajax({
            type: "POST",
            url: "../php/funcion_proyectos.php", // Reemplaza con la URL correcta
            data: {
                nuevo_estado: true,
                id_proyecto: idProyecto,
                nuevo_estado: nuevoEstado
            },
            dataType: "json",
            success: function (response) {
                if (response.exito) {
                    alert("Estado del proyecto actualizado con éxito.");
                    // No es necesario recargar la página; el estado se actualiza en el select.
                } else {
                    alert("Error al actualizar el estado del proyecto.");
                }
            },
            error: function () {
                alert("Error al actualizar el estado del proyecto.");
            }
        });
    }
}