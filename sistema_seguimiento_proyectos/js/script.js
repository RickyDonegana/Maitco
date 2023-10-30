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

// Event listener para botones "Cambiar Estado" en la tabla de proyectos y tareas
tablaProyectosTareas.addEventListener('change', (event) => {
    if (event.target.dataset.action === 'cambiarEstado') {
        const selectElement = event.target;
        const id = selectElement.dataset.id;
        const nuevoEstado = selectElement.value;
        const estadoActual = selectElement.dataset.estadoActual;
        let confirmMessage;
        if (selectElement.dataset.tipo === 'proyecto') {
            confirmMessage = `¿Estás seguro de que deseas cambiar el estado del proyecto a "${nuevoEstado}"?`;
        } else {
            confirmMessage = `¿Estás seguro de que deseas cambiar el estado de la tarea a "${nuevoEstado}"?`;
        }
        if (confirm(confirmMessage)) {
            cambiarEstado(id, nuevoEstado, selectElement.dataset.tipo);
        } else {
            selectElement.value = estadoActual;
        }
    }
});

// Función para cambiar el estado de un proyecto o tarea
function cambiarEstado(id, nuevoEstado, tipo) {
    const requestData = {
        cambiar_estado: true,
        id: id,
        nuevo_estado: nuevoEstado,
        tipo: tipo
    };
    let successMessage;
    let errorMessage;
    if (tipo === 'proyecto') {
        successMessage = `Estado del proyecto actualizado con éxito (${nuevoEstado})`;
        errorMessage = "Error al actualizar el estado del proyecto";
    } else {
        successMessage = `Estado de la tarea actualizado con éxito (${nuevoEstado})`;
        errorMessage = "Error al actualizar el estado de la tarea";
    }
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        const selectElement = document.querySelector(`select[data-action="cambiarEstado"][data-id="${id}"]`);
        if (selectElement) {
            selectElement.dataset.estadoActual = nuevoEstado;
        }
    });
}

// Event listener para botones "Finalizar" en la tabla de proyectos y tareas
tablaProyectosTareas.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'finalizar') {
        const id = event.target.dataset.id;
        const tipo = event.target.dataset.tipo;
        let confirmMessage;
        if (tipo === 'proyecto') {
            confirmMessage = `¿Estás seguro de que deseas finalizar este proyecto?`;
        } else {
            confirmMessage = `¿Estás seguro de que deseas finalizar esta tarea?`;
        }
        if (confirm(confirmMessage)) {
            finalizarElemento(id, tipo);
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
    let successMessage;
    let errorMessage;
    if (tipo === 'proyecto') {
        successMessage = `Proyecto finalizado con éxito`;
        errorMessage = "Error al finalizar el proyecto";
    } else {
        successMessage = `Tarea finalizada con éxito`;
        errorMessage = "Error al finalizar la tarea";
    }
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        location.reload();
    });
}

// Función genérica para enviar solicitudes AJAX
function sendAjaxRequest(data, successMessage, errorMessage, successCallback) {
    $.ajax({
        type: "POST",
        url: "../php/funcion_proyectos.php",
        url: "../php/tareas/funcion_tablaTareas.php",
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
