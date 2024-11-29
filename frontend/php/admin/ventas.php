<?php include("../../include/cabecera.php"); ?>
    
<title>Ventas - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/ventas.css">

<?php include("../../include/sidebar.php"); ?>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-principal">
    <div class="container-fluid">
        <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregar_compra"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Venta</button>
    </div>

    <div class="container-fluid" style=" margin-top:20px">
        <div class="row ">
            <div class="col-lg-12 ">
                <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                    <thead class="text-center" >
                        <!-- <tr> -->
                        <th class="text-center bg-info-subtle">ID</th>
                        <th class="text-center bg-info-subtle">Fecha Registro</th>
                        <th class="text-center bg-info-subtle">Documento Cliente</th>
                        <th class="text-center bg-info-subtle">Nombre de Cliente</th>
                        <th class="text-center bg-info-subtle">Nro Comprobante</th>
                        <th class="text-center bg-info-subtle">Total</th>
                        <th class="text-center bg-info-subtle">Opciones</th>
                        <!-- </tr> -->
                    </thead>
                    <tbody class="text-center">
                        <!-- Contenido de la tabla -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
<!-- CONTENIDO PRINCIPAL -->

<!-- MODAL PARA AGREGAR COMPRAS -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE VENTA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body"">
                <form method="post" action="" id="formulario-empleado">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 border">
                                
                                <h5> Comprobante de pago</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="fecha_emision" class="col-form-label text-center">Fecha Emisión:</label>
                                        <input type="date" class="form-control form-control-sm text-center border-dark-subtle" id="fecha_emision" name="fecha_emision" required>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_comprobante" class="col-form-label ">Tipo de Comprobante:</label>
                                            <select class="form-control text-center form-select border-dark-subtle" id="tipo_comprobante" name="tipo_comprobante" required>
                                                <option value="boleta">BOLETA</option>
                                                <option value="factura">FACTURA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group text-center">
                                            <label for="serie" class="col-form-label">Serie:</label>
                                            <select class="form-control text-center form-select border-dark-subtle" id="serie" name="serie" required>
                                                <option value="" disabled selected >Seleccione</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group text-center">
                                            <label for="correlativo" class="col-form-label ">Correlativo:</label>
                                            <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="correlativo" name="correlativo" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group text-center">
                                            <label for="metodo_pago" class="col-form-label">Metodo Pago:</label>
                                            <select class="form-control text-center form-select border-dark-subtle" id="metodo_pago" name="metodo_pago" required>
                                                <!-- <option value="" disabled selected hidden>Seleccione</option> -->
                                                <?php
                                                $sql = "SELECT id_metodo_pago, nombre_metodo FROM metodo_pago";
                                                $stmt = $conexion->query($sql);
                                                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $fila['id_metodo_pago'] . '">' . $fila['nombre_metodo'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-6 border">

                                <h5> Datos del Cliente</h5>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="tipo_documento" class="col-form-label">Tipo de Documento:</label>
                                            <select class="form-control text-center form-select border-dark-subtle" id="tipo_documento" name="tipo_documento" required>
                                                <!-- <option value="" disabled selected hidden>Seleccione</option> -->
                                                <option value="SIN_DOC">SIN DOCUMENTO</option>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="form-group row">
                                            <label for="nro_documento" class="col-sm-12 col-form-label">Nro. Documento:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="nro_documento" name="nro_documento" >
                                                <!-- Alerta cuando el cliente ya se encuentra registro en la BD -->
                                                <span class="alerta-documento" id="alertaClienteRegistrado" style="display: none;"></span>
                                            </div>
                                            <button type="button" class="col-sm-3 btn btn-info text-white" id="btn-buscar">Buscar</button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="form-group row">
                                            <label for="nombre" class="col-form-label col-sm-2">Nombre:</label>
                                            <div class="col-sm-10">    
                                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center border-dark-subtle" id="nombre" name="nombre" >
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group row">
                                            <label for="direccion" class="col-form-label col-sm-2">Dirección:</label>
                                            <div class="col-sm-10"> 
                                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center border-dark-subtle" id="direccion" name="direccion" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="email" class="col-form-label">Email:</label>
                                            <input type="email" class="form-control form-control-sm text-center border-dark-subtle" id="email" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular" class="col-form-label">Celular:</label>
                                            <input type="tel" class="form-control form-control-sm text-center border-dark-subtle" id="celular" name="celular">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 border  mt-2">
                                <!-- Contenido de la fila inferior que ocupa todo el ancho -->
                                <h5> Detalle Venta</h5>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group text-center">
                                            <label for="producto" class="col-form-label">Producto:</label>
                                            <select class="form-control form-select border-dark-subtle" id="producto" name="producto" >
                                                <option value="" disabled selected hidden>Seleccione</option>
                                                <?php
                                                $sql = "SELECT id_producto, nombre_producto FROM producto";
                                                $stmt = $conexion->query($sql);
                                                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    echo '<option value="' . $fila['id_producto'] . '">' . $fila['id_producto'] . ' - ' . $fila['nombre_producto'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <label for="cantidad" class="col-form-label ">Cantidad:</label>
                                            <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="cantidad" name="cantidad">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <label for="stock" class="col-form-label ">Stock:</label>
                                            <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="stock" name="stock" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group text-center ">
                                            <label for="precio" class="col-form-label">Precio:</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" aria-label="Amount (to the nearest dollar)" id="precio" name="precio" >
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <label for="registrar_producto" class="col-form-label">Agregar Producto:</label>
                                            <button type="button" class="btn btn-primary w-100" id="registrar_producto" name="cantidad_compra">Agregar</button>
                                        </div>
                                    </div>

                                    

                                </div>

                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-9 border  ">
                                <!-- Tabla para mostrar los detalles de la venta -->
                                <table class="table table-striped table-bordered table-hover table-sm mt-3" id="tabla_detalle_venta">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Importe</th>
                                            <th class="text-center">Opcion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se agregarán las filas de los productos -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-3 border mt-2 ">
                                <div class="row">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Total</span>
                                        <input type="text" class="form-control border-dark-subtle" id="total_input" name="total_input">
                                    </div>
                                    
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Recibido</span>
                                        <input type="text" class="form-control border-dark-subtle" id="recibido_input" name="recibido_input">
                                    </div>
                                    
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Vuelto</span>
                                        <input type="text" class="form-control border-dark-subtle" id="vuelto_input" name="vuelto_input">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer justify-content-center">
                        <input name="id_usuario" id="id_usuario" type="hidden">
                        <input name="operacion" id="operacion" type="hidden">

                        <?php  
                            // * Mostrar ID del Empleado
                            $usuario_login = $_SESSION['usuario']; 
                            $consulta = "SELECT * FROM empleado WHERE DNI = :usuario_login";
                            $stmt = $conexion->prepare($consulta);
                            $stmt->bindParam(':usuario_login', $usuario_login, PDO::PARAM_STR); // Usamos bindParam para mayor seguridad
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                                $id_empleado = $fila['id_empleado'];  // Suponiendo que 'id' es el campo del ID en la tabla empleado
                            }
                        ?>

                        <input name="empleado" id="empleado" type="hidden" value="<?php echo isset($id_empleado) ? $id_empleado : ''; ?>">
                        <button type="submit" class="btn btn-success" id="registrar_venta">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnReload">Cerrar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>


-
<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DATABLES JS -->
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- ALERTAS JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- SIDEBAR JS -->
<script src="../../js/admin/sidebar.js"></script>


<script>

$(document).ready(function() {
    // Evento para obtener datos del producto seleccionado
    $('#producto').change(function() {
        var productoId = $(this).val();
        if (productoId) {
            $.ajax({
                type: "POST",
                url: "../../../backend/consultas/datos_producto.php", // Cambia esta URL por la correcta para tu API
                data: {
                    id_producto: productoId
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status === "success") {
                        // Asignar valores de stock y precio a los campos
                        $('#stock').val(data.stock);
                        $('#precio').val(data.precio_unitario);
                    } else {
                        // Manejo de error si no se encuentra el producto
                        alert("No se pudo obtener los datos del producto.");
                    }
                },
                error: function() {
                    alert("Error al conectar con el servidor.");
                }
            });
        } else {
            // Si no hay producto seleccionado, limpiar los campos
            $('#stock').val('');
            $('#precio').val('');
        }
    });
});

// </script>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        
        const modal = document.getElementById("exampleModal");
        const tableBody = document.querySelector("#tabla_detalle_venta tbody");
       
        modal.addEventListener("hidden.bs.modal", function () {
            // Limpiar la tabla de detalles de venta
            tableBody.innerHTML = "";
        });

        if (seleccionarTipo.value === 'SIN_DOC') {
            deshabilitarCampos();
        }

        document.getElementById("registrar_producto").addEventListener("click", function() {
            // Obtener los valores de los campos
            const producto = document.getElementById("producto");
            const nombreProducto = producto.options[producto.selectedIndex].text;
            const cantidad = parseInt(document.getElementById("cantidad").value);
            const precio = parseFloat(document.getElementById("precio").value);
            
            // Validación de datos
            if (!producto.value || isNaN(cantidad) || cantidad <= 0 || isNaN(precio) || precio <= 0) {
                alert("Por favor, complete los campos correctamente.");
                return;
            }
            
            // Calcular el importe
            const importe = cantidad * precio;
            
            // Crear una nueva fila en la tabla
            const newRow = document.createElement("tr");
            
            // Añadir las celdas a la fila
            newRow.innerHTML = `
                <td>${nombreProducto}</td>
                <td>${cantidad}</td>
                <td>${precio.toFixed(2)}</td>
                <td>${importe.toFixed(2)}</td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm eliminar-fila">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;
            
            // Añadir la fila a la tabla
            tableBody.appendChild(newRow);

            // Agregar evento al botón de eliminar
            newRow.querySelector(".eliminar-fila").addEventListener("click", function() {
                eliminarFila(newRow);
            });

             // Recalcular el total después de añadir el nuevo producto
            calcularTotal();

            // Limpiar los campos después de agregar el producto
            document.getElementById("producto").selectedIndex = 0;
            document.getElementById("cantidad").value = "";
            document.getElementById("stock").value = "";
            document.getElementById("precio").value = "";

        });

        // Función para calcular el total sumando todos los importes de la tabla
        function calcularTotal() {
            let totalAmount = 0;
            const tableBody = document.querySelector("#tabla_detalle_venta tbody");
            
            // Sumar cada importe de las filas de la tabla
            Array.from(tableBody.querySelectorAll("tr")).forEach(row => {
                const importe = parseFloat(row.cells[3].innerText);
                totalAmount += importe;
            });

            // Actualizar el campo de total
            document.getElementById("total_input").value = totalAmount.toFixed(2);
        }

        // Función para eliminar una fila de la tabla
        function eliminarFila(row) {
            event.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Se eliminará este producto del detalle de venta.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove(); // Eliminar la fila
                    calcularTotal(); // Recalcular el total
                    Swal.fire({
                        icon: "success",
                        title: "Producto eliminado",
                        text: "El producto fue eliminado correctamente.",
                    });
                }
            });
        }

        // Calcular el vuelto automáticamente al ingresar el monto recibido
        document.getElementById("recibido_input").addEventListener("input", function() {
            const recibido = parseFloat(this.value);
            const total = parseFloat(document.getElementById("total_input").value);
            const vuelto = recibido - total;
            document.getElementById("vuelto_input").value = vuelto.toFixed(2);
        });

        
    });


    // Selección del tipo de documento
    var seleccionarTipo = document.querySelector('#tipo_documento');
    let alertaRegistroCliente = document.querySelector('#alertaClienteRegistrado');
    var tipoDocumento;
    
    // Campos a habilitar o deshabilitar
    var camposCliente = ['#nro_documento', '#nombre', '#direccion', '#email', '#celular'];

    seleccionarTipo.addEventListener("change", function(){
        // Obtener el valor del tipo de documento seleccionado
        tipoDocumento = seleccionarTipo.value;

        // Limpiar siempre los campos al cambiar el tipo de documento
        limpiarCampos(true);

        // Comprobar si el tipo es "SIN_DOC"
        if (tipoDocumento === 'SIN_DOC') {
            // Deshabilitar todos los campos si no se requiere documento
            deshabilitarCampos();
            // Limpiar los campos y esconder alerta
            limpiarCampos();
            alertaRegistroCliente.style.display = 'none';
        } else {
            // Habilitar los campos para ingreso de datos cuando es DNI o RUC
            habilitarCampos();
            alertaRegistroCliente.style.display = 'none';

            // Llamar a la función de consulta según el tipo de documento seleccionado
            if (tipoDocumento === 'DNI') {
                consultarDNI();
            } else if (tipoDocumento === 'RUC') {
                consultarRUC();
            }
        }
    });

    // Función para deshabilitar los campos
    function deshabilitarCampos() {
        camposCliente.forEach(function(selector) {
            document.querySelector(selector).disabled = true;
        });
    }

    // Función para habilitar los campos
    function habilitarCampos() {
        camposCliente.forEach(function(selector) {
            document.querySelector(selector).disabled = false;
        });
    }

    // Función para limpiar los campos
    function limpiarCampos(limpiarDocumento = false) {
        camposCliente.forEach(function (selector) {
            if (selector !== '#nro_documento' || limpiarDocumento) {
                document.querySelector(selector).value = '';
            }
        });
    }

    // Función para consultar por DNI
    function consultarDNI() {
        $("#btn-buscar").off("click").on("click", function() {
            var dni = $("#nro_documento").val();

            limpiarCampos();
            alertaRegistroCliente.style.display = 'none';
            $.ajax({
                type: "POST",
                url: "../../../backend/consultas/API_dni.php",
                data: {
                    dni: dni,
                    tipoUsuario: 'cliente'  // Tipo de usuario
                },
                dataType: 'json',
                success: function(data) {
                    
                        
                    if (data.status === "success") {
                        // Ocultar la alerta de error
                        alertaRegistroCliente.textContent = "Cliente ya Registrado ...";
                        alertaRegistroCliente.style.display = 'block';
                        alertaRegistroCliente.style.color = 'green';


                        // Rellenar los campos con la información del cliente
                        var cliente = data.cliente;
                        console.log(cliente);
                        
                        $("#nombre").val(cliente.nombre);
                        $("#direccion").val(cliente.direccion);
                        $("#email").val(cliente.email);
                        $("#celular").val(cliente.nro_celular);

                        console.log("Datos del cliente:", cliente); // Depuración
                    
                        
                    }  else {
                        alertaRegistroCliente.style.display = 'none';
                        var nombreCompleto = data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno;
                        $("#nombre").val(nombreCompleto);
                    }
                }
            });
        });
    }

    // Función para consultar por RUC
    function consultarRUC() {
        $("#btn-buscar").off("click").on("click", function() {
            var ruc = $("#nro_documento").val();

            limpiarCampos();
            alertaRegistroCliente.style.display = 'none';
            $.ajax({
                type: "POST",
                url: "../../../backend/consultas/API_ruc.php",
                data: {
                    ruc: ruc,
                    tipoUsuario: 'cliente'  // Tipo de usuario
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status === "success") {
                        // Ocultar la alerta de error
                        alertaRegistroCliente.textContent = "Cliente ya Registrado ...";
                        alertaRegistroCliente.style.display = 'block';
                        alertaRegistroCliente.style.color = 'green';


                        // Rellenar los campos con la información del cliente
                        var cliente = data.cliente;
                        console.log(cliente);
                        
                        $("#nombre").val(cliente.nombre);
                        $("#direccion").val(cliente.direccion);
                        $("#email").val(cliente.email);
                        $("#celular").val(cliente.nro_celular);

                        console.log("Datos del cliente:", cliente); // Depuración
                    } else {
                        alertaRegistroCliente.style.display = 'none';
                        $("#nombre").val(data.razonSocial);
                        $("#direccion").val(data.direccion);
                    }
                }
            });
        });
    }


    
    

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tipoComprobanteSelect = document.getElementById("tipo_comprobante");
        const serieSelect = document.getElementById("serie");

        // Función para cargar las series
        function cargarSeries(tipoComprobante) {
            // Limpiar el select de series
            serieSelect.innerHTML = '<option value="" disabled selected hidden>Seleccione</option>';

            if (tipoComprobante) {
                // Realizar la petición AJAX para obtener las series
                $.ajax({
                    type: "POST",
                    url: "../../../backend/consultas/obtener_series.php", // Ruta del archivo backend
                    data: { tipo_comprobante: tipoComprobante },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === "success") {
                            // Cargar las opciones de series en el select
                            data.series.forEach(function(serie) {
                                const option = document.createElement("option");
                                option.value = serie.serie;
                                option.textContent = serie.serie;
                                serieSelect.appendChild(option);
                            });
                        } else {
                            alert("No se encontraron series para este tipo de comprobante.");
                        }
                    },
                    error: function() {
                        alert("Error al cargar las series.");
                    }
                });
            }
        }

        // Cargar las series automáticamente al cargar la página
        cargarSeries(tipoComprobanteSelect.value);

        // Evento cuando se cambia el tipo de comprobante
        tipoComprobanteSelect.addEventListener("change", function() {
            cargarSeries(this.value);
        });

        // Evento cuando se selecciona una serie
        document.getElementById("serie").addEventListener("change", function() {
            const serieId = this.value;

            if (serieId) {
                // Realizar la petición AJAX para obtener el correlativo de la serie seleccionada
                $.ajax({
                    type: "POST",
                    url: "../../../backend/consultas/obtener_correlativo.php", // Ruta del archivo backend
                    data: { serie_id: serieId },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === "success") {
                            // Asignar el correlativo al campo correspondiente
                            document.getElementById("correlativo").value = data.correlativo;
                        } else {
                            alert("No se pudo obtener el correlativo.");
                        }
                    },
                    error: function() {
                        alert("Error al conectar con el servidor.");
                    }
                });
            }
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cantidadInput = document.getElementById("cantidad");
        const stockInput = document.getElementById("stock");
        const agregarProductoBtn = document.getElementById("registrar_producto");

        

        // Validación en tiempo real para la cantidad
        cantidadInput.addEventListener("input", function() {
            const stock = parseInt(stockInput.value);
            const cantidad = parseInt(cantidadInput.value);

            if (!isNaN(stock) && !isNaN(cantidad) && cantidad > stock) {
                cantidadInput.value = stock; // Ajustar automáticamente al stock máximo
                Swal.fire({
                    icon: "warning",
                    title: "Cantidad excedida",
                    text: "La cantidad no puede superar el stock disponible.",
                });
            }
        });

        // Validación al hacer clic en "Agregar Producto"
        agregarProductoBtn.addEventListener("click", function() {
            const stock = parseInt(stockInput.value);
            const cantidad = parseInt(cantidadInput.value);

            if ( stock <= 0) {
                Swal.fire({
                    icon: "error",
                    title: "Sin stock",
                    text: "No hay stock disponible para este producto.",
                });
                return;
            }

            if (cantidad <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Cantidad inválida",
                    text: "Debe ingresar una cantidad válida.",
                });
                return;
            }

            if (cantidad > stock) {
                Swal.fire({
                    icon: "error",
                    title: "Stock insuficiente",
                    text: "La cantidad ingresada supera el stock disponible.",
                });
                return;
            }

            // Si todo está correcto
            Swal.fire({
                icon: "success",
                title: "Producto agregado",
                text: "Producto agregado a la lista.",
            });

            // Aquí puedes continuar con la lógica para agregar el producto a la tabla de detalles
        });

        // Llamar a la función al cargar la página para verificar el estado inicial
    });

</script>
<!-- CRUD VENTA JS -->
<script src="../../js/admin/CRUD_venta.js"></script>
</body>

</html>