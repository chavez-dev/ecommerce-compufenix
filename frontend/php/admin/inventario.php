<?php include("../../include/cabecera.php"); ?>
    
<title>Inventario - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/inventario.css">

<?php include("../../include/sidebar.php"); ?>


    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-principal">
        <div class="container-fluid">
            <button type="button" class="btn btn-danger empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado">PDF</button>
        </div>
        
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12 ">
                    <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                        <thead class="text-center">
                            <!-- <tr> -->
                                <th class="text-center bg-info-subtle">ID</th>
                                <th class="text-center bg-info-subtle">Registro</th>
                                <th class="text-center bg-info-subtle">Producto</th>
                                <th class="text-center bg-info-subtle">ID Compra</th>
                                <th class="text-center bg-info-subtle">Serie</th>
                                <th class="text-center bg-info-subtle">Estado</th>
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

<!-- MODAL PARA AGREGAR INVENTARIO -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">INVENTARIO</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado">
                <div class="row">
                    <h5> Datos Producto</h5>

                    <!-- Campo para el ID de Producto Item -->
                    <div class="col-md-12 mt-2">
                        <div class="form-group row">
                            <label for="fecha_registro" class="col-form-label col-sm-4" >Fecha de Registro:</label>
                            <div class="col-sm-6">    
                                <input type="date" class="form-control form-control-sm text-center border-dark-subtle" id="fecha_registro" name="fecha_registro" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label for="id_producto_item" class="col-form-label">ID Inventario:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="id_producto_item" name="id_producto_item" readonly>
                        </div>
                    </div>

                    <!-- Campo para el ID de Producto Item -->
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label for="id_producto" class="col-form-label">ID Producto:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="id_producto" name="id_producto" readonly>
                        </div>
                    </div>

                    <!-- Campo para el ID de Producto Item -->
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label for="id_compra" class="col-form-label">ID Compra:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="id_compra" name="id_compra" readonly>
                        </div>
                    </div>

                    <!-- Campo para el Nombre del Producto -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_producto" class="col-form-label">Nombre Producto:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="nombre_producto" name="nombre_producto" readonly>
                        </div>
                    </div>

                    <!-- Campo para la Serie del Producto -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serie" class="col-form-label">Serie:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="serie" name="serie" >
                        </div>
                    </div>

                    <!-- Campo para la Ubicación del Producto -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ubicacion" class="col-form-label">Ubicación:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="ubicacion" name="ubicacion" >
                        </div>
                    </div>

                    <!-- Campo para el Cliente (si está vendido) -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado" class="col-form-label">Estado:</label>
                            <select class="form-control text-center form-select border-dark-subtle" id="estado" name="estado" >
                                <option value="" disabled selected hidden>Seleccione</option>
                                <?php 
                                    // Consulta para obtener los estados de la tabla estado
                                    include("../../../backend/config/conexion.php");
                                    $sql = "SELECT id_estado, tipo_estado FROM estado";
                                    $stmt = $conexion->query($sql);
                                    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $fila['id_estado'] . '">' . $fila['tipo_estado'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Campo para el Estado del Producto -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="garantia" class="col-form-label">Garantia:</label>
                            <input type="date" class="form-control text-center border-dark-subtle" id="garantia" name="garantia" >
                        </div>
                    </div>
                    


                    <h5 class="mt-3">Datos de Venta</h5>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_venta" class="col-form-label">ID Venta:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="id_venta" name="id_venta" readonly>
                        </div>
                    </div>


                    <!-- Campo para la Garantía del Producto -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="dni" class="col-form-label">Nro. Documento:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="dni" name="dni" readonly>
                        </div>
                    </div>

                    <!-- Campo para la Fecha de Registro -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cliente" class="col-form-label">Nombre del Cliente:</label>
                            <input type="text" class="form-control text-center border-dark-subtle" id="cliente" name="cliente" readonly>
                        </div>
                    </div>

                    <!-- Campo para el ID de Venta (si el producto fue vendido) -->
                    
                </div>

                    <div class="modal-footer justify-content-center">
                        <input  name="id_usuario" id="id_usuario" type="hidden">
                        <input  name="operacion" id="operacion" type="hidden">
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

<!-- CRUD INVENTARIO JS -->
<script src="../../js/admin/CRUD_inventario.js"></script>

</body>

</html>