$(document).ready(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });

    function mensajeToast(icon, message) {
        Toast.fire({
            icon: icon,
            title: message
        });
    }

    var select = document.getElementById('metodoPago');
    var checkbox = document.getElementById('chkEfectivoExacto');

    select.addEventListener('change', function () {
        checkbox.checked = (select.value !== 'Efectivo');
        validarCheckbox();
    });

    $(document).ready(function () {
        validarCheckbox();
    });

    $('#chkEfectivoExacto').change(function () {
        validarCheckbox();
    });

    $('#iptEfectivoRecibido').on('input', function () {
        actualizarMontosEfectivo();
    });

    function validarCheckbox() {
        if ($('#chkEfectivoExacto').is(':checked')) {
            $('#iptEfectivoRecibido').val($("#boleta_total").text());
            $('#montoEfectivo').text($('#iptEfectivoRecibido').val());
            var vuelto = 0;
            $('#vuelto').text(vuelto.toFixed(2));
        } else {
            $('#iptEfectivoRecibido').val("");
            actualizarMontoEfectivo();
        }
    }

    function actualizarMontoEfectivo() {
        var montoRecibido = parseFloat($('#iptEfectivoRecibido').val()) || 0;
        $('#montoEfectivo').text(montoRecibido.toFixed(2));
    }

    function actualizarMontosEfectivo() {
        actualizarMontoEfectivo();
        var montoRecibido = parseFloat($('#iptEfectivoRecibido').val()) || 0;
        var vuelto = montoRecibido - parseFloat($("#boleta_total").text()) || 0;
        $('#vuelto').text(vuelto.toFixed(2));
    }

    $('#btnRealizarPago').on('click', function () {
        var idPedido = $("#iptNroSerie1").val();
        realizarPago(idPedido);
    });

    function realizarPago(idPedido) {
        var efectivoText = $('#montoEfectivo').text();
        var efectivo = parseFloat(efectivoText);
        var vueltoText = $("#vuelto").text();
        var vueltoA = parseFloat(vueltoText);
        if (!isNaN(efectivo)) {
            var total = parseFloat($("#boleta_total").text());

            var datosPago = {
                efectivo: efectivo.toFixed(2),
                metodo: $("#metodoPago").val(),
                vuelto: vueltoA.toFixed(2)
            };

            var datosVenta = {
                pago: datosPago,
            };

            if (efectivo >= total) {
                $.ajax({
                    url: "../views/venta/pagarVentaActual.php",
                    type: "POST",
                    data: JSON.stringify(datosVenta),
                    success: function (response) {
                        var url = 'cajero.php?c=VentaController&a=realizarPago&id=' + idPedido;
                        window.location.href = url;
                    },
                    error: function (xhr, status, error) {
                        alert("Error en la solicitud AJAX:", status, error);
                        alert(xhr.responseText);
                    }
                });
            } else {
                mensajeToast('error', "El efectivo no es suficiente.");
            }
        } else {
            console.error("Invalid value for #montoEfectivo:", efectivoText);
        }
    }
});
