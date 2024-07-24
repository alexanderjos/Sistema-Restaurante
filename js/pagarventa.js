$(document).ready(function () {
    $('.btn-pagar').click(function (e) {
        e.preventDefault();

        var idPedido = $(this).data('idpedido');

        // Realizar la solicitud AJAX
        $.ajax({
            url: '../views/venta/pagarventa.php', 
            method: 'POST',
            data: { idPedido: idPedido },
            success: function (response) {
                console.log(response);

                window.location.href = "../views/cajero.php?c=VentaController&a=pagarVenta";
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX', error);
            }
        });
    });
});
