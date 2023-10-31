// Obtener elementos HTML relevantes
const elements = {
    tablaProyectosTareas: document.getElementById('tablaProyectosTareas'),
};

// Event listener para botones "Finalizar" en la tabla de proyectos
tablaProyectosTareas.addEventListener('click', (event) => {
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

    try {
        sendAjaxRequest(requestData, successMessage, errorMessage, () => {
            location.reload();
        });
    } catch (error) {
        alert(error.message);
    }
}

// Función genérica para enviar solicitudes AJAX
function sendAjaxRequest(data, successMessage, errorMessage, successCallback) {
    $.ajax({
        type: "POST",
        url: "../php/proyectos/tablaProyectos.php",
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