$(document).ready(function () {
    $(".boton-finalizar").on("click", function () {
        let idProyecto = $(this).data("id");
        let action = $(this).data("action");
        if (confirm("¿Está seguro de que desea finalizar el proyecto?")) {
            $.post(
                "../php/proyectos/tablaProyectos.php",
                { id_proyecto: idProyecto, accion: action },
                function (data) {
                    if (data.exito) {
                        alert("El proyecto ha sido finalizado con éxito.");
                        location.reload();
                    } else {
                        alert("Error al finalizar el proyecto: " + data.error);
                    }
                },
                "json"
            );
        }
    });
});
