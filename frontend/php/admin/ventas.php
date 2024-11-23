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
                            <div class="col-md-6 border border-danger">
                                
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
                                            <label for="serie" class="col-form-label ">Serie:</label>
                                            <input type="text" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="serie" name="serie" value="F100">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group text-center">
                                            <label for="correlativo" class="col-form-label ">Correlativo:</label>
                                            <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="correlativo" name="correlativo" value="1">
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


                            <div class="col-md-6 border border-danger">

                                <h5> Datos del Cliente</h5>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="tipo_documento" class="col-form-label">Tipo de Documento:</label>
                                            <select class="form-control text-center form-select" id="tipo_documento" name="tipo_documento" required>
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
                                                <input type="text" class="form-control form-control-sm text-center" id="nro_documento" name="nro_documento" >
                                                <!-- Alerta cuando el cliente ya se encuentra registro en la BD -->
                                                <span class="alerta-documento" id="alertaClienteRegistrado" style="display: none;"></span>
                                            </div>
                                            <button type="button" class="col-sm-3 btn btn-info text-white" id="btn-buscar">Buscar</button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="nombre" class="col-form-label col-sm-2" style="margin-bottom: 2px;">Nombre:</label>
                                            <div class="col-sm-10">    
                                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center" id="nombre" name="nombre" >
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="direccion" class="col-form-label col-sm-2">Dirección:</label>
                                            <div class="col-sm-10"> 
                                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center" id="direccion" name="direccion" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="email" class="col-form-label">Email:</label>
                                            <input type="email" class="form-control form-control-sm text-center" id="email" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular" class="col-form-label">Celular:</label>
                                            <input type="tel" class="form-control form-control-sm text-center" id="celular" name="celular">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 border border-danger mt-2">
                                <!-- Contenido de la fila inferior que ocupa todo el ancho -->
                                <h5> Detalle Venta</h5>
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group text-center">
                                            <label for="producto" class="col-form-label">Producto:</label>
                                            <select class="form-control form-select" id="producto" name="producto" >
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
                                            <input type="number" class="form-control text-center input-number-hide-arrows" id="cantidad" name="cantidad">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <label for="stock" class="col-form-label ">Stock:</label>
                                            <input type="number" class="form-control text-center input-number-hide-arrows" id="stock" name="stock">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group text-center ">
                                            <label for="precio" class="col-form-label">Precio:</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control text-center input-number-hide-arrows" aria-label="Amount (to the nearest dollar)" id="precio" name="precio" >
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
                            <div class="col-md-9 border border-danger">
                                <!-- Tabla para mostrar los detalles de la venta -->
                                <table class="table mt-3" id="tabla_detalle_venta">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Importe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí se agregarán las filas de los productos -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-3 border border-danger">
                                <div class="row">
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Total</span>
                                        <input type="text" class="form-control" id="total_input" name="total_input">
                                    </div>
                                    
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Recibido</span>
                                        <input type="text" class="form-control" id="recibido_input" name="recibido_input">
                                    </div>
                                    
                                    <div class="input-group mb-2">
                                        <span class="input-group-text" >Vuelto</span>
                                        <input type="text" class="form-control" id="vuelto_input" name="vuelto_input">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer justify-content-center">
                        <input name="id_usuario" id="id_usuario" type="hidden">
                        <input name="operacion" id="operacion" type="hidden">
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
<script src="../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
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
            const tableBody = document.querySelector("#tabla_detalle_venta tbody");
            const newRow = document.createElement("tr");
            
            // Añadir las celdas a la fila
            newRow.innerHTML = `
                <td>${nombreProducto}</td>
                <td>${cantidad}</td>
                <td>${precio.toFixed(2)}</td>
                <td>${importe.toFixed(2)}</td>
            `;
            
            // Añadir la fila a la tabla
            tableBody.appendChild(newRow);

             // Recalcular el total después de añadir el nuevo producto
            calcularTotal();

            // Limpiar los campos después de agregar el producto
            document.getElementById("producto").selectedIndex = 0;
            document.getElementById("cantidad").value = "";
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

<!-- CRUD VENTA JS -->
<script src="../../js/admin/CRUD_venta.js"></script>
</body>

</html>