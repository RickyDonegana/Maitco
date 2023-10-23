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
});*/

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

// Event listener para botones "Editar" en la tabla de proyectos
tablaProyectos.addEventListener('click', (event) => {
    if (event.target.dataset.action === 'editar') {
        const id = event.target.dataset.id;
        const nombre = event.target.dataset.nombre;
        const descripcion = event.target.dataset.descripcion;
        const cliente = event.target.dataset.cliente;
        const desarrollador = event.target.dataset.desarrollador;
        const fechaInicio = event.target.dataset.fechaInicio;
        const fechaEntrega = event.target.dataset.fechaEntrega;
        const estado = event.target.dataset.estado;
        document.getElementById('id_proyecto_form').value = id;
        document.getElementById('nombre_proyecto').value = nombre;
        document.getElementById('descripcion').value = descripcion;
        document.getElementById('cliente').value = cliente;
        document.getElementById('desarrollador').value = desarrollador;
        document.getElementById('fecha_inicio').value = fechaInicio;
        document.getElementById('fecha_entrega_estimada').value = fechaEntrega;
        document.getElementById('estado_form').value = estado;
        document.getElementById('btnEditar').textContent = 'Guardar cambios';
        agregarProyectoForm.onsubmit = function (e) {
            e.preventDefault();
            editarProyecto();
        };
    }
});

// Función para editar un proyecto
function editarProyecto() {
    // Obtener los valores del formulario
    const id = idProyectoForm.value;
    const nombre = nombreProyectoInput.value;
    const descripcion = descripcionInput.value;
    const cliente = clienteInput.value;
    const desarrollador = desarrolladorInput.value;
    const fechaInicio = fechaInicioInput.value;
    const fechaEntrega = fechaEntregaEstimadaInput.value;
    const estado = estadoForm.value;

    // Realizar la solicitud AJAX para editar el proyecto (ajusta la URL y los datos)
    $.ajax({
        type: "POST",
        url: "../php/funcion_proyectos.php",
        data: {
            editar_proyecto: true,
            id_proyecto: id,
            nombre_proyecto: nombre,
            descripcion: descripcion,
            cliente: cliente,
            desarrollador: desarrollador,
            fecha_inicio: fechaInicio,
            fecha_entrega_estimada: fechaEntrega,
            estado: estado
        },
        dataType: "json",
        success: function (response) {
            if (response.exito) {
                alert("Proyecto editado con éxito");
                location.reload();
            } else {
                alert("Error al editar el proyecto");
            }
        },
        error: function () {
            alert("Error al editar el proyecto");
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

// Función genérica para enviar solicitudes AJAX
function sendAjaxRequest(data, successMessage, errorMessage, successCallback) {
    $.ajax({
        type: "POST",
        url: "../php/funcion_proyectos.php",
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