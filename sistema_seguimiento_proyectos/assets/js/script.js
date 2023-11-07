$(document).ready(function () {
    $('.boton-finalizar-proyecto').click(function () {
        console.log('Clic detectado');
        var idProyecto = $(this).data('id');
        console.log('ID del proyecto:', idProyecto);
        var confirmation = confirm('¿Desea finalizar este proyecto?');
        console.log('Confirmación:', confirmation);
        if (confirmation == true) {
            console.log('Enviando solicitud POST al servidor');
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
