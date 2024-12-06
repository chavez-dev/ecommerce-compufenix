<?php include("../../include/cabecera.php"); ?>

<title>Compra - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/compras.css">

<?php include("../../include/sidebar.php"); ?>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-principal">
    <div class="container-fluid">
        <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Compra</button>
        <button type="button" class="btn btn-danger" id="reporte_compra"><i class="fa-solid fa-file-pdf" style="color: #ffffff;"></i> Reporte</button>
    </div>

    <div class="container-fluid" style=" margin-top:20px">
        <div class="row ">
            <div class="col-lg-12 ">
                <div class="table-responsive">
                    <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                        <thead class="text-center">
                            <!-- <tr> -->
                            <th class="text-center bg-info-subtle">ID</th>
                            <th class="text-center bg-info-subtle">Fecha</th>
                            <th class="text-center bg-info-subtle">Proveedor</th>
                            <th class="text-center bg-info-subtle">Producto</th>
                            <th class="text-center bg-info-subtle">Estado</th>
                            <th class="text-center bg-info-subtle">Cantidad</th>
                            <th class="text-center bg-info-subtle">Total</th>
                            <th class="text-center bg-info-subtle">Factura</th>
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
    </div>


</main>
<!-- CONTENIDO PRINCIPAL -->

<!-- MODAL PARA AGREGAR COMPRAS -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE COMPRA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body"">
                <form method=" post" action="" id="formulario-empleado">
                <div class="row">
                    <h5> Datos de Compra</h5>

                    <div class="col-md-6 ">
                        <div class="form-group text-center">
                            <label for="proveedor" class="col-form-label">Proveedor:</label>
                            <select class="form-control form-select border-dark-subtle" id="proveedor" name="proveedor" required onchange="cargarProductosPorProveedor(this.value)">
                                <option value="" disabled selected hidden>Seleccione</option>
                                <?php
                                $sql = "SELECT id_proveedor, nombre FROM proveedor";
                                $stmt = $conexion->query($sql);
                                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $fila['id_proveedor'] . '">' . $fila['id_proveedor'] . ' - ' . $fila['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="form-group text-center">
                            <label for="producto" class="col-form-label">Producto:</label>
                            <select class="form-control form-select border-dark-subtle" id="producto" name="producto" required>
                                <option value="" disabled selected hidden>Seleccione</option>
                                <!-- Las opciones se llenarán dinámicamente mediante JavaScript -->
                            </select>
                        </div>
                    </div>


                    
                    <?php

                    $sql_id_empleado = $conexion->prepare("SELECT id_empleado FROM empleado WHERE DNI = '" . $_SESSION["usuario"] . "' LIMIT 1 ");
                    $sql_id_empleado->execute();
                    $id_empleado = $sql_id_empleado->fetchColumn();

                    ?>
                    <input type="hidden" class="form-control text-center input-number-hide-arrows" id="empleado" name="empleado" value="<?php echo $id_empleado ?>" readonly  >
                    

                    <div class="col-md-2">
                        <div class="form-group text-center">
                            <label for="cantidad_compra" class="col-form-label ">Cantidad:</label>
                            <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="cantidad_compra" name="cantidad_compra">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group text-center ">
                            <label for="precio_unitario" class="col-form-label">Precio Und.:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" aria-label="Amount (to the nearest dollar)" id="precio_unitario" name="precio_unitario" required>
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group text-center ">
                            <label for="pago_total" class="col-form-label">Total:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" aria-label="Amount (to the nearest dollar)" id="pago_total" name="pago_total" required>
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label for="factura" class="col-form-label ">Nro Boleta:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="factura" name="factura">
                        </div>
                    </div>


                    <div class="col-md-4 ">
                        <div class="form-group text-center">
                            <label for="metodo_pago" class="col-form-label">Metodo Pago:</label>
                            <select class="form-control text-center form-select border-dark-subtle" id="metodo_pago" name="metodo_pago" required>
                                <option value="" disabled selected hidden>Seleccione</option>
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

                    <div class="col-md-2">
                        <div class="form-group justify-content-center text-center">
                            <label for="status" class="col-form-label">Estado:</label>
                            <div class="form-check form-switch justify-content-center text-center box-estado">
                                <input class="form-check-input text-center border-dark-subtle" type="checkbox" role="switch" id="estado" name="estado" checked>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col-md-12 mt-3">
                        <div class="input-group">
                            <span class="input-group-text">Descripcion</span>
                            <textarea class="form-control border-dark-subtle" aria-label="With textarea" rows="3" id="descripcion" name="descripcion"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <br>
                        <p class="d-inline-flex gap-1">
                            <a class="btn btn-warning" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Asignar Serie a Productos
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="col-md-12">
                                <div class="form-group row" id="inputSeries">
                                    <!-- Para el ingreso de numeros de Serie -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    <input name="id_usuario" id="id_usuario" type="hidden">
                    <input name="operacion" id="operacion" type="hidden">
                    <button type="submit" class="btn btn-success" id="registrar-empleado">Registrar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnReload">Cerrar</button>
                </div>
                </form>

            </div>

        </div>
    </div>
</div>


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

<!-- CRUD EMPLEADO JS -->
<script src="../../js/admin/CRUD_compra.js"></script>

<script>
    var inputCantidad = document.querySelector('#cantidad_compra');
    var inputPrecioUnitario = document.querySelector('#precio_unitario');
    var inputPrecioTotal = document.querySelector('#pago_total');
    var precioTotal;

    inputCantidad.addEventListener("input", actualizarPrecioTotal);
    inputPrecioUnitario.addEventListener("input", actualizarPrecioTotal);

    inputCantidad.addEventListener("input", function() {
        var cantidad = parseInt(this.value);
        agregarInputsSeries(cantidad);
    })

    function actualizarPrecioTotal() {
        var cantidad = parseFloat(inputCantidad.value);
        var precioUnitario = parseFloat(inputPrecioUnitario.value);

        if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
            precioTotal = cantidad * precioUnitario;
            inputPrecioTotal.value = precioTotal; // Asignamos el valor al campo de pago_total
            console.log(precioTotal);
        } else {
            inputPrecioTotal.value = ''; // Borramos el valor si no es un número válido
        }
    }

    function agregarInputsSeries(cantidad) {
        var inputSeriesDiv = document.getElementById('inputSeries');
        inputSeriesDiv.innerHTML = ''; // Limpiar los inputs anteriores

        for (var i = 1; i <= cantidad; i++) {
            var label = document.createElement('label');
            label.setAttribute('for', 'serie' + i);
            label.classList.add('col-form-label', 'col-sm-3');
            label.innerText = 'Producto ' + i;

            var div = document.createElement('div');
            div.classList.add('col-sm-9');

            var input = document.createElement('input');
            input.setAttribute('type', 'text');
            input.setAttribute('oninput', "this.value = this.value.toUpperCase()");
            input.classList.add('form-control', 'form-control-sm', 'text-center');
            input.setAttribute('id', 'serie' + i);
            input.setAttribute('name', 'serie' + i);
            input.setAttribute('placeholder', 'Número de serie ' + i);

            div.appendChild(input);
            inputSeriesDiv.appendChild(label);
            inputSeriesDiv.appendChild(div);
        }
    }

    function cargarProductosPorProveedor(proveedorId) {
        // Verificar que se ha seleccionado un proveedor válido
        if (proveedorId) {
            // Hacer la solicitud AJAX al servidor
            fetch(`../../../backend/consultas/obtener_productos.php?proveedor_id=${proveedorId}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar las opciones actuales del select de productos
                    const productoSelect = document.getElementById('producto');
                    productoSelect.innerHTML = '<option value="" disabled selected hidden>Seleccione</option>';

                    // Agregar las opciones recibidas
                    data.forEach(producto => {
                        const option = document.createElement('option');
                        option.value = producto.id_producto;
                        // Mostrar el ID, nombre del producto y precio formateado
                        option.textContent = `${producto.id_producto} - ${producto.nombre_producto} - S./ ${producto.precio_unitario}`;
                        productoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error al cargar productos:', error));
        }
    }
</script>

</body>

</html>