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
    btnNuevoProyecto: document.getElementById('btnNuevoProyecto'),
    agregarProyectoForm: document.getElementById('agregarProyectoForm'),
    editarProyectoForm: document.getElementById('editarProyectoForm'),
    tablaProyectos: document.getElementById('tablaProyectos'),
    btnAgregar: document.getElementById('btnAgregar'),
    btnEditar: document.getElementById('btnEditar'),
    btnAgregarTarea: document.getElementById('btnAgregarTarea')
};

// Agregar evento para el botón "Agregar Nueva Tarea"
/*btnAgregarTarea.addEventListener('click', () => {
    idTareaForm.value = '';
    nombreTarea.value = '';
    descripcionTarea.value = '';
    idProyectoForm.value = '';
    idUsuarioForm.value = '';
    fechaVencimiento.value = '';
    estadoIdForm.value = ''; // Establece el campo de estado en blanco
    btnAgregarEditarTarea.innerText = 'Agregar';
});
*/
// Agregar evento para el botón "Agregar Nuevo Proyecto"
btnNuevoProyecto.addEventListener('click', () => {
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

// Agregar un evento de escucha al formulario
/*const editarProyectoForm = document.getElementById('editarProyectoForm');

proyectoForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const idProyecto = document.getElementById('id_proyecto_form').value;
    const nombreProyecto = document.getElementById('nombre_proyecto').value;
    const descripcion = document.getElementById('descripcion').value;
    const cliente = document.getElementById('cliente').value;
    const desarrollador = document.getElementById('desarrollador').value;
    const fechaInicio = document.getElementById('fecha_inicio').value;
    const fechaEntregaEstimada = document.getElementById('fecha_entrega_estimada').value;
    const estado = document.getElementById('estado_form').value;

    const requestData = {
        id_proyecto: idProyecto,
        nombre_proyecto: nombreProyecto,
        descripcion: descripcion,
        cliente: cliente,
        desarrollador: desarrollador,
        fecha_inicio: fechaInicio,
        fecha_entrega_estimada: fechaEntregaEstimada,
        estado: estado
    };
    sendAjaxRequest(requestData);
});
*/
// Event listener para botones "Cambiar Estado" en la tabla de proyectos
tablaProyectos.addEventListener('change', (event) => {
    if (event.target.dataset.action === 'cambiarEstado') {
        const selectElement = event.target;
        const idProyecto = selectElement.dataset.id;
        const nuevoEstado = selectElement.value;
        const estadoActual = selectElement.dataset.estadoActual;
        const confirmMessage = `¿Estás seguro de que deseas cambiar el estado del proyecto a "${nuevoEstado}"?`;
        if (confirm(confirmMessage)) {
            cambiarEstadoProyecto(idProyecto, nuevoEstado);
        } else {
            selectElement.value = estadoActual;
        }
    }
});

// Función para cambiar el estado de un proyecto
function cambiarEstadoProyecto(idProyecto, nuevoEstado) {
    const requestData = {
        nuevo_estado: true,
        id_proyecto: idProyecto,
        nuevo_estado: nuevoEstado
    };
    const successMessage = `Estado del proyecto actualizado con éxito (${nuevoEstado})`;
    const errorMessage = "Error al actualizar el estado del proyecto";
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        const selectElement = document.querySelector(`select[data-action="cambiarEstado"][data-id="${idProyecto}"]`);
        if (selectElement) {
            selectElement.dataset.estadoActual = nuevoEstado;
        }
    });
}

// Event listener para botones "Finalizar" en la tabla de proyectos
tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'finalizar') {
        const idProyecto = event.target.dataset.id;
        const confirmMessage = "¿Estás seguro de que deseas finalizar este proyecto?";
        if (confirm(confirmMessage)) {
            finalizarProyecto(idProyecto);
        }
    }
});

// Función para finalizar un proyecto
function finalizarProyecto(idProyecto) {
    const requestData = {
        confirmar_finalizar_proyecto: true,
        id_proyecto: idProyecto
    };
    const successMessage = "Proyecto finalizado con éxito";
    const errorMessage = "Error al finalizar el proyecto";
    sendAjaxRequest(requestData, successMessage, errorMessage, () => {
        location.reload();
    });
}

// Función genérica para enviar solicitudes AJAX
function sendAjaxRequest(data, successMessage, errorMessage, successCallback) {
    $.ajax({
        type: "POST",
        url: "../php/funcion_proyectos.php",
        url: "../php/proyectos/editar_proyecto.php",
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
