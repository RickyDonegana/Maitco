$(document).ready(function () {
    $(".boton-finalizar-proyecto, .boton-finalizar-tarea").on("click", function () {
        const $button = $(this);
        const id = $button.data("id");
        const action = $button.data("action");
        const url = $button.data("url");

        const confirmMessage = action === "finalizar" ? "¿Está seguro de que desea finalizar el proyecto?" : "¿Está seguro de que desea finalizar la tarea?";
        const successMessage = action === "finalizar" ? "El proyecto ha sido finalizado con éxito." : "La tarea ha sido finalizada con éxito.";

        if (confirm(confirmMessage)) {
            const data = action === "finalizar" ? { id_proyecto: id, accion: action } : { id_tarea: id, accion: action };

            $.post(url, data, "json")
                .done(function (data) {
                    console.log('Respuesta del servidor:', data);
                    if (data.exito) {
                        alert(successMessage);
                        location.reload();
                    } else {
                        alert("Error al finalizar " + (action === "finalizar" ? "el proyecto" : "la tarea") + ": " + data.error);
                    }
                })
                .fail(function (error) {
                    console.log('Error en la solicitud:', error);
                    alert("Error al realizar la solicitud al servidor.");
                });
        }
    });
});
