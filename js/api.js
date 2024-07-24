var boton = document.getElementById("boton");

    function capitalizarPrimeraLetra(cadena) {
        return cadena.toLowerCase().replace(/(?:^|\s)\S/g, function (a) {
            return a.toUpperCase();
        });
    }

    function traer() {
        var dni = $("#txtDNI").val();
        // Realizar consulta a la base de datos
        $.ajax({
            url: "../buscador/cliente.php",
            type: "GET",
            data: {
                dni: dni
            },
            dataType: "json",
            success: function (data) {
                if (data) {
                    var nombre = capitalizarPrimeraLetra(data.nombreCliente);
                    var apellido = capitalizarPrimeraLetra(data.apellidoCliente);

                    $("#txtNombre").val(nombre);
                    $("#txtApellido").val(apellido);
                } else {
                    // Cliente no registrado en la BD, usando la API externa
                    fetch(
                            "https://apiperu.dev/api/dni/" +
                            dni +
                            "?api_token=4d12a37d8767c5970cbc355169ee9799131ac08c85c8fd4827a549ae26943688"
                        )
                        .then((res) => res.json())
                        .then((data) => {
                            var nombre = capitalizarPrimeraLetra(data.data.nombres);
                            var apellido = capitalizarPrimeraLetra(data.data.apellido_paterno + " " + data.data.apellido_materno);

                            document.getElementById("txtNombre").value = nombre;
                            document.getElementById("txtApellido").value = apellido;
                        });
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                console.log(xhr.responseText);
            }
        });
    }


    boton.addEventListener("click", traer);