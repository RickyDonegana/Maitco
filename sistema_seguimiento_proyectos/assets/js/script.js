$(document).ready(function () {
    $('.boton-finalizar-proyecto').click(function () {
        var idProyecto = $(this).data('id');
        var confirmation = confirm('¿Desea finalizar este proyecto?');
        if (confirmation == true) {
            $.post({
                url: $(this).data('url'),
                data: { id_proyecto: idProyecto, action: 'finalizar' },
                success: function (response) {
                    if (response.exito == true) {
                        alert('Proyecto finalizado con éxito.');
                        $('[data-id="' + idProyecto + '"]').hide();
                    } else {
                        alert('Error al finalizar el proyecto: ' + response.error);
                    }
                },
                dataType: 'json'
            });
        }
    });
});

$(document).ready(function () {
    $('.boton-finalizar-tarea').click(function () {
        var idTarea = $(this).data('id');
        var confirmation = confirm('¿Desea finalizar esta tarea?');
        if (confirmation == true) {
            $.post({
                url: $(this).data('url'),
                data: { id_tarea: idTarea, action: 'finalizar' },
                success: function (response) {
                    if (response.exito == true) {
                        alert('Tarea finalizada con éxito.');
                        $('[data-id="' + idTarea + '"]').hide();
                    } else {
                        alert('Error al finalizar la tarea: ' + response.error);
                    }
                },
                dataType: 'json'
            });
        }
    });
});
