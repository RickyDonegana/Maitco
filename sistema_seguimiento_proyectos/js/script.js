// Obtener elementos HTML relevantes
const elements = {
    idProyectoForm: document.getElementById('id_proyecto_form'),
    nombreProyectoInput: document.getElementById('nombre_proyecto'),
    descripcionInput: document.getElementById('descripcion'),
    clienteInput: document.getElementById('cliente'),
    desarrolladorInput: document.getElementById('desarrollador'),
    fechaInicioInput: document.getElementById('fecha_inicio'),
    fechaEntregaEstimadaInput: document.getElementById('fecha_entrega_estimada'),
    estadoForm: document.getElementById('estado_form'),
    tablaProyectosTareas: document.getElementById('tablaProyectosTareas'),
};

// Event listener para botones "Finalizar" y cambios de estado en la tabla de proyectos y tareas
tablaProyectosTareas.addEventListener('click', (event) => {
    const target = event.target;
    const action = target.dataset.action;

    if (action === 'finalizar' || action === 'cambiarEstado') {
        const id = target.dataset.id;
        const confirmMessage = action === 'finalizar' ?
            `¿Estás seguro de que deseas finalizar este ${target.dataset.tipo}?` :
            `¿Estás seguro de que deseas cambiar el estado de este ${target.dataset.tipo} a "${target.value}"?`;

        if (confirm(confirmMessage)) {
            if (action === 'finalizar') {
                finalizarElemento(id, target.dataset.tipo);
            } else {
                cambiarEstadoElemento(id, target.value, target.dataset.tipo);
            }
        } else if (action === 'cambiarEstado') {
            target.value = target.dataset.estadoActual;
        }
    }
});

// Función para finalizar un proyecto o tarea
function finalizarElemento(id, tipo) {
    const requestData = {
        finalizar_elemento: true,
        id: id,
        tipo: tipo
    };
    const successMessage = `${tipo.charAt(0).toUpperCase() + tipo.slice(1)} finalizado con éxito`;
    const errorMessage = `Error al finalizar el ${tipo}`;
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        location.reload();
    });
}

// Función para cambiar el estado de un proyecto o tarea
function cambiarEstadoElemento(id, nuevoEstado, tipo) {
    const requestData = {
        cambiar_estado_elemento: true,
        id: id,
        nuevo_estado: nuevoEstado,
        tipo: tipo
    };
    const successMessage = `Estado del ${tipo} actualizado con éxito (${nuevoEstado})`;
    const errorMessage = `Error al actualizar el estado del ${tipo}`;
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        const selectElement = document.querySelector(`select[data-action="cambiarEstado"][data-id="${id}"]`);
        if (selectElement) {
            selectElement.dataset.estadoActual = nuevoEstado;
        }
    });
}

// Función genérica para enviar solicitudes AJAX
function sendAjaxRequest(data, successMessage, errorMessage, successCallback) {
    $.ajax({
        type: "POST",
        url: "../php/proyectos/tablaProyectos.php",
        url: "../php/tareas/tablaTareas.php",
        data,
        dataType: "json",
        success: function (response) {
            if (response.exito) {
                alert(successMessage);
                if (successCallback) {
                    successCallback();
                }
            } else {
                alert(errorMessage);
            }
        },
        error: function () {
            alert(errorMessage);
        }
    });
}