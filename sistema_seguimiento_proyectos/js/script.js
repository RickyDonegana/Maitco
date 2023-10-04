function mostrarFormulario() {
    // Verifica si el elemento con id "nuevoProyectoForm" existe
    var formulario = document.getElementById("nuevoProyectoForm");
    if (formulario) {
        // Muestra el formulario y oculta la tabla y el botón "Agregar Nuevo Proyecto"
        formulario.style.display = "block";
        document.getElementById("tablaProyectos").style.display = "none";
        document.getElementById("btnNuevoProyecto").style.display = "none";        
        document.getElementById("nuevoProyectoForm").style.display = "none";

    } else {
        console.error("El elemento con id 'nuevoProyectoForm' no se encontró.");
    }
}

// Función para ocultar el formulario y mostrar la tabla y el botón "Agregar Nuevo Proyecto"
function ocultarFormulario() {
    document.getElementById("tablaProyectos").style.display = "none";
    document.getElementById("btnNuevoProyecto").style.display = "block"; // Mostrar el botón "Agregar Nuevo Proyecto"
    document.getElementById("nuevoProyectoForm").style.display = "none"; // Ocultar el formulario
    document.getElementById("btnAgregarEditarProyecto").textContent = "Agregar";
    document.getElementById("id_proyecto_form").value = ""; // Limpiar el campo oculto de ID
    document.getElementById("nombre_proyecto").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("cliente").value = "";
    document.getElementById("desarrollador").value = "";
    document.getElementById("fecha_inicio").value = "";
    document.getElementById("fecha_entrega_estimada").value = "";
    document.getElementById("estado_form").value = "inicio";
}

// Función para mostrar el formulario de edición de proyecto
function editarProyecto(id, nombre, descripcion, cliente, desarrollador, fechaInicio, fechaEntrega, estado) {
    mostrarFormulario();
    document.getElementById("btnAgregarEditarProyecto").textContent = "Editar";
    document.getElementById("id_proyecto_form").value = id;
    document.getElementById("nombre_proyecto").value = nombre;
    document.getElementById("descripcion").value = descripcion;
    document.getElementById("cliente").value = cliente;
    document.getElementById("desarrollador").value = desarrollador;
    document.getElementById("fecha_inicio").value = fechaInicio;
    document.getElementById("fecha_entrega_estimada").value = fechaEntrega;
    document.getElementById("estado_form").value = estado;
}

// Función para eliminar una fila de proyecto de la tabla
function eliminarProyecto(id) {
    var confirmar = confirm("¿Estás seguro de que deseas eliminar este proyecto?");
    if (confirmar) {
        // Eliminar la fila de la tabla
        document.getElementById("filaProyecto_" + id).remove();
    }
}

// Función para finalizar un proyecto
function finalizarProyecto(id) {
    var confirmar = confirm("¿Estás seguro de que deseas finalizar este proyecto?");
    if (confirmar) {
        // Aquí deberías implementar la lógica para finalizar el proyecto
        // y actualizar la tabla si es necesario.
        alert("El proyecto se ha finalizado con éxito."); // Mensaje de confirmación
    }
}

// Evento click para el botón "Agregar Nuevo Proyecto"
document.getElementById("btnNuevoProyecto").addEventListener("click", mostrarFormulario);

// Eventos para los botones "Editar" y "Finalizar" en cada fila de proyecto
document.querySelectorAll("button[data-action='editar']").forEach(function (btn) {
    btn.addEventListener("click", function () {
        var id = btn.getAttribute("data-id");
        var nombre = btn.getAttribute("data-nombre");
        var descripcion = btn.getAttribute("data-descripcion");
        var cliente = btn.getAttribute("data-cliente");
        var desarrollador = btn.getAttribute("data-desarrollador");
        var fechaInicio = btn.getAttribute("data-fecha-inicio");
        var fechaEntrega = btn.getAttribute("data-fecha-entrega");
        var estado = btn.getAttribute("data-estado");
        editarProyecto(id, nombre, descripcion, cliente, desarrollador, fechaInicio, fechaEntrega, estado);
    });
});

document.querySelectorAll("button[data-action='finalizar']").forEach(function (btn) {
    btn.addEventListener("click", function () {
        var id = btn.getAttribute("data-id");
        finalizarProyecto(id);
    });
});

// Evento click para el botón "Agregar" o "Editar" en el formulario
document.getElementById("btnAgregarEditarProyecto").addEventListener("click", function () {
    var nombre = document.getElementById("nombre_proyecto").value;
    var descripcion = document.getElementById("descripcion").value;
    var cliente = document.getElementById("cliente").value;
    var desarrollador = document.getElementById("desarrollador").value;
    var fechaInicio = document.getElementById("fecha_inicio").value;
    var fechaEntrega = document.getElementById("fecha_entrega_estimada").value;
    var estado = document.getElementById("estado_form").value;

    if (nombre === "" || descripcion === "" || cliente === "" || desarrollador === "" || fechaInicio === "" || fechaEntrega === "") {
        alert("¡Atención! Debes completar todos los campos.");
    } else {
        var mensaje = document.getElementById("btnAgregarEditarProyecto").textContent === "Agregar" ? "¿Estás seguro de que deseas agregar este proyecto?" : "¿Estás seguro de que deseas editar este proyecto?";
        var confirmar = confirm(mensaje);
        if (confirmar) {
            ocultarFormulario();
            alert("La acción se realizó con éxito."); // Mensaje de confirmación
        }
    }
});

// Evento click para los botones "Finalizar"
document.querySelectorAll("button[data-action='finalizar']").forEach(function (btn) {
    btn.addEventListener("click", function () {
        var id = btn.getAttribute("data-id");
        finalizarProyecto(id);
    });
});
