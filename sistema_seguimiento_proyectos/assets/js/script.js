$(document).ready(function () {
    $(".boton-finalizar-tarea, .boton-finalizar-proyecto").on("click", function () {
        const $button = $(this);
        const id = $button.data("id");
        const action = $button.data("action");
        const url = $button.data("url");

        const confirmMessage = action === "finalizar" ? "¿Está seguro de que desea finalizar la tarea?" : "¿Está seguro de que desea finalizar el proyecto?";
        const successMessage = action === "finalizar" ? "La tarea ha sido finalizada con éxito." : "El proyecto ha sido finalizado con éxito.";

        if (confirm(confirmMessage)) {
            const data = action === "finalizar" ? { id_tarea: id, accion: action } : { id_proyecto: id, accion: action };

            $.post(url, data, "json")
                .done(function (data) {
                    console.log('Respuesta del servidor:', data);
                    if (data.exito) {
                        alert(successMessage);
                        location.reload();
                    } else {
                        alert("Error al finalizar " + (action === "finalizar" ? "la tarea" : "el proyecto") + ": " + data.error);
                    }
                })
                .fail(function (error) {
                    console.log('Error en la solicitud:', error);
                    alert("Error al realizar la solicitud al servidor.");
                });
        }
    });
});
