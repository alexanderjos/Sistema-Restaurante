$(document).ready(function () {
    var contador = 1;
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
    $("#iptCodigoVenta").on("input", function () {
        var terminoBusqueda = $(this).val().trim();

        if (terminoBusqueda === "") {
            $("#resultados").empty();
            return;
        }

        $.ajax({
            url: "../buscador/buscar_producto.php",
            type: "GET",
            data: {
                termino_busqueda: terminoBusqueda
            },
            dataType: "json",
            success: function (data) {
                var resultadosHtml = "";
                for (var i = 0; i < data.length; i++) {
                    resultadosHtml += "<p class='producto' data-id='" + data[i].idProducto +
                        "' data-nombre='" + data[i].nombreProducto +
                        "' data-productotp='" + data[i].nombre_tipoProducto +
                        "' data-marca='" + data[i].nombreMarca +
                        "' data-precio='" + data[i].precioUnitario + "'>" +
                        data[i].nombreProducto + " - " + data[i].precioUnitario + "</p>";
                }
                $("#resultados").html(resultadosHtml);
            }
        });
    });
    //Verificar Stock
    function obtenerProductoPorId(productoId) {
        var producto = null;

        $.ajax({
            url: "../buscador/buscar_producto.php",
            type: "GET",
            data: {
                termino_busqueda: productoId
            },
            dataType: "json",
            async: false,
            success: function (data) {
                producto = data.length > 0 ? data[0] : null;
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });

        return producto ? producto.stock : 0;
    }
    //consulta terciario 
    //variable o coindicion ? valor verdadero : valor falso
    function verificador(idProducto) {
        var stock = obtenerProductoPorId(idProducto);
        var validacion;
        if (stock == 0) {
            validacion = "No cuenta con Stock";
            return validacion;
        } else {
            validacion = "Cuenta con Stock";
            return validacion;
        }
    }



    //agregar productos a la tabla cuando se seleccionan 
    $("#resultados").on("click", ".producto", function () {
        var productoId = $(this).data("id");
        var productoNombre = $(this).data("nombre");
        var productoPrecio = parseFloat($(this).data("precio"));
        var tipoProducto = $(this).data("productotp");
        var marca = $(this).data("marca");

        var filaExistente = buscarFilaExistente(productoId);
        var verificacion = verificador(productoId);

        if (filaExistente) {
            var inputCantidad = filaExistente.find(".cantidad");
            var stockActual = obtenerProductoPorId(productoId);
            if(verificacion=="No cuenta con Stock"){
                var nuevaCantidad = parseFloat(inputCantidad.val()) + 1;
                inputCantidad.val(nuevaCantidad);
                actualizarTotal(inputCantidad);
            }else{
                if (inputCantidad < stockActual) {
                    var nuevaCantidad = parseFloat(inputCantidad.val()) + 1;
                    inputCantidad.val(nuevaCantidad);
                    actualizarTotal(inputCantidad);
                } else {
                    mensajeToast('error', 'Prodcuto sin stock');
                }
            }
        } else {
            agregarProductoATabla(contador, productoId, tipoProducto, marca, productoNombre, 1, productoPrecio, productoPrecio);
            contador++;
        }

        $("#iptCodigoVenta").val("");
        $("#resultados").empty();

        actualizarTotalVenta();
    });

    function buscarFilaExistente(productoId) {
        var filas = $("#lstProductosVenta tbody tr");
        var filaExistente = null;

        filas.each(function () {
            var id = $(this).find("td:eq(1)").text();
            if (id === productoId.toString()) {
                filaExistente = $(this);
                return false;
            }
        });

        return filaExistente;
    }

    function agregarProductoATabla(posicion, codigoProducto, tipoProducto, marca, nombre, cantidad, precio, total) {

        //verificar si el producto cuenta con stock ya que los productos que no cuentan con stock como son las comidas que se preparan del momento
        var verificacion = verificador(codigoProducto);
        if (verificacion == "Cuenta con Stock") {
            var stockActual = obtenerProductoPorId(codigoProducto);

            if (cantidad > (stockActual - 1)) {
                mensajeToast('error', '¡No hay suficiente stock disponible!');
                return;
            }
        }
        var tabla = $("#lstProductosVenta tbody");
        var fila = "<tr>" +
            "<td class='text-center'>" + posicion + "</td>" +
            "<td class='text-center'>" + codigoProducto + "</td>" +
            "<td class='text-center'>" + tipoProducto + "</td>" +
            "<td class='text-center'>" + marca + "</td>" +
            "<td class='text-center'>" + nombre + "</td>" +
            "<td><input type='number' class='form-control form-control-xs cantidad' style='width:80px;' value='" + cantidad + "' min='1'></td>" +
            "<td class='text-center'>" + precio.toFixed(2) + "</td>" +
            "<td class='total text-center'>" + total.toFixed(2) + "</td>" +
            "<td class='align-middle text-center'><button class='btn btn-danger btnEliminar'>Eliminar</button></td>" +
            "</tr>";
        tabla.append(fila);

        $(".cantidad").on("input", function () {
            actualizarTotal($(this));
        });

        actualizarTotalVenta();
    }

    function actualizarTotal(inputCantidad) {
        var fila = inputCantidad.closest("tr");
        var precio = parseFloat(fila.find("td:eq(6)").text());
        var cantidad = parseFloat(inputCantidad.val());
        var stockActual = obtenerProductoPorId(fila.find("td:eq(1)").text()); // Obtener el stock actual
        var total = isNaN(precio) || isNaN(cantidad) ? 0 : (precio * cantidad);

        if (stockActual > 0) {
            if (cantidad > (stockActual - 1)) {
                mensajeToast('error', '¡No hay suficiente stock disponible!');
                inputCantidad.val((stockActual - 1)); // Restaurar la cantidad al stock disponible
                cantidad = stockActual - 1;
            }
        }

        total = precio * cantidad;
        fila.find("td.total").text(total.toFixed(2));

        actualizarTotalVenta();
    }


    $("#lstProductosVenta").on("click", ".btnEliminar", function () {
        $(this).closest("tr").remove();
        actualizarContador();
        actualizarTotalVenta();
    });

    function actualizarContador() {
        contador = 1;
        $("#lstProductosVenta tbody tr").each(function () {
            $(this).find("td:eq(0)").text(contador);
            contador++;
        });
    }

    function actualizarTotalVenta() {
        var sumaTotal = 0;
        $(".total").each(function () {
            sumaTotal += parseFloat($(this).text()) || 0;
        });
        var igv = sumaTotal * 0.10;
        var subtotal = sumaTotal - igv;
        $("#opGravada").text(subtotal.toFixed(2));
        $("#boleta_igv").text(igv.toFixed(2));
        $("#boleta_subtotal").text(sumaTotal.toFixed(2));
        $("#boleta_total").text(sumaTotal.toFixed(2));

        $("#totalVenta span").text(sumaTotal.toFixed(2));
    }

    actualizarTotalVenta();

    $("#btnVaciarListado").on("click", function () {
        $("#lstProductosVenta tbody").empty();
        contador = 1;
        actualizarTotalVenta();
    });
    $("#realizarVenta").on("click", function (event) {
        event.preventDefault();
        var datosCliente = {
            DNI: $("#txtDNI").val(),
            Nombre: $("#txtNombre").val(),
            Apellido: $("#txtApellido").val()
        };
        var datosMozo = {
            idMozo: $("#idUsuario").val(),
        };
        var productosEnArray = obtenerProductosEnArray();
        var ventaInfo = obtenerDatosVentaArray();
        var datosVenta = {
            cliente: datosCliente,
            productos: productosEnArray,
            venta: ventaInfo,
            mozo: datosMozo
        };
        var dni = $("#txtDNI").val();
        var nombre = $("#txtNombre").val();
        var apellido = $("#txtApellido").val();
        if (dni === "" || nombre === "" || apellido === "") {
            mensajeToast('error', 'Porfavor complete los campos del cliente');
            return;
        } else {
            $.ajax({
                url: "../views/venta/guardarventa.php",
                type: "POST",
                data: JSON.stringify(datosVenta),
                success: function (response) {

                    window.location.href = "../views/mozo.php?c=VentaController&a=nuevaVenta";
                },
                error: function (xhr, status, error) {
                    alert("Error en la solicitud AJAX:", status, error);
                    alert(xhr.responseText);
                }
            });
        }

    });

    function obtenerProductosEnArray() {
        var productosArray = [];

        $("#lstProductosVenta tbody tr").each(function () {
            var validacion = verificador($(this).find("td:eq(1)").text());

            var stockNuevo;
            if (validacion == "No cuenta con Stock") {
                stockNuevo = 0;
            } else {
                var stockDisponible = obtenerProductoPorId($(this).find("td:eq(1)").text());
                stockNuevo = stockDisponible - $(this).find(".cantidad").val();
            }
            var producto = {
                posicion: $(this).find("td:eq(0)").text(),
                codigoProducto: $(this).find("td:eq(1)").text(),
                tipoProducto: $(this).find("td:eq(2)").text(),
                marca: $(this).find("td:eq(3)").text(),
                nombre: $(this).find("td:eq(4)").text(),
                cantidad: $(this).find(".cantidad").val(),
                precio: $(this).find("td:eq(6)").text(),
                total: $(this).find("td.total").text(),
                stock: stockNuevo

            };

            productosArray.push(producto);
        });

        return productosArray;
    }

    function obtenerDatosVentaArray() {
        var ventaArray = {
            numeroSerie: $("#iptNroSerie").val(),
            Correlativo: $("#Correlativo").val(),
            igv: $("#boleta_igv").text(),
            opgravada: $("#opGravada").text(),
            subtotal: $("#boleta_subtotal").text(),
            totalVenta: $("#boleta_total").text()
        };

        return ventaArray;
    }

});