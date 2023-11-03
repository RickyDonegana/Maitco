$(document).ready(function () {
    $(".boton-finalizar-proyecto, .boton-finalizar-tarea").on("click", function () {
        let id = $(this).data("id");
        let action = $(this).data("action");
        let confirmMessage = action === "finalizar" ? "¿Está seguro de que desea finalizar el proyecto?" : "¿Está seguro de que desea finalizar la tarea?";
        let successMessage = action === "finalizar" ? "El proyecto ha sido finalizado con éxito." : "La tarea ha sido finalizada con éxito.";

        if (confirm(confirmMessage)) {
            let url = action === "finalizar" ? "../php/proyectos/tablaProyectos.php" : "../php/tareas/tablaTareas.php";
            let data = action === "finalizar" ? { id_proyecto: id, accion: action } : { id_tarea: id, accion: action };

            $.post(
                url,
                data,
                function (data) {
                    if (data.exito) {
                        alert(successMessage);
                        location.reload();
                    } else {
                        alert("Error al finalizar " + (action === "finalizar" ? "el proyecto" : "la tarea") + ": " + data.error);
                    }
                },
                "json"
            );
        }
    });
});
