<?php include("../../include/cabecera.php"); ?>

<title>Productos - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/producto.css">

<?php include("../../include/sidebar.php"); ?>


<!-- CONTENIDO PRINCIPAL -->
<main class="main-principal">
    <div class="container-fluid">
        <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Producto</button>
    </div>

    <div class="container-fluid" style=" margin-top:20px">
        <div class="row ">
            <div class="col-lg-12 ">
                <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                    <thead class="text-center">
                        <!-- <tr> -->
                        <th class="text-center bg-info-subtle">ID</th>
                        <th class="text-center bg-info-subtle">imagen</th>
                        <th class="text-center bg-info-subtle">Producto</th>
                        <th class="text-center bg-info-subtle">Modelo</th>
                        <th class="text-center bg-info-subtle">Categoria</th>
                        <th class="text-center bg-info-subtle">Estado</th>
                        <th class="text-center bg-info-subtle">Precio</th>
                        <th class="text-center bg-info-subtle">Stock</th>
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

<!-- MODAL PARA AGREGAR PRODUCTO -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE PRODUCTO</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado" >
                    <div class="row">
                        <h5>Datos del Producto</h5>

                        <div class="row">
                            <!-- <h5> Información de Contacto </h5> -->
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="nombre_producto" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="nombre_producto" name="nombre_producto" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="imagen_producto" class="col-form-label">Imagen:</label>
                                    <input type="file" class="form-control form-control-sm text-center border-dark-subtle" id="imagen_producto" name="imagen_producto" >
                                    <span class="form-control form-control-sm " id="imagen_subida"></span>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                    

                            <div class="col-md-3">
                                <div class="form-group text-center">
                                    <label for="stock" class="col-form-label ">Stock:</label>
                                    <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" id="stock" name="stock" placeholder="0">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label for="modelo" class="col-form-label">Modelo:</label>
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="modelo" name="modelo" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group text-center">
                                    <label for="categoria" class="col-form-label">Categoria:</label>
                                    <select class="form-control text-center form-select border-dark-subtle" id="categoria" name="categoria" required>
                                        <option value="" disabled selected hidden>-- Seleccione --</option>
                                        <?php
                                        $sql = "SELECT id_categoria_producto, nombre_categoria FROM categoria_producto";
                                        $stmt = $conexion->query($sql);
                                        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $fila['id_categoria_producto'] . '">' . $fila['nombre_categoria'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            

                        </div>


                        

                        <div class="row">
                            <!-- <h5> Información de Contacto </h5> -->
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="precio_unitario" class="col-form-label">Precio:</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control text-center input-number-hide-arrows border-dark-subtle" aria-label="Amount (to the nearest dollar)" id="precio_unitario" name="precio_unitario" required step="0.01">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group justify-content-center text-center">
                                    <label for="status" class="col-form-label">Estado:</label>
                                    <div class="form-check form-switch justify-content-center text-center box-estado ">
                                        <input class="form-check-input text-center border-dark-subtle" type="checkbox" role="switch" id="status" name="status" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_minimo" class="col-form-label">Stock Minimo:</label>
                                    <input type="number" class="form-control form-control-sm text-center input-number-hide-arrows border-dark-subtle" id="stock_minimo" name="stock_minimo" required>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text">Descripcion</span>
                                <textarea class="form-control border-dark-subtle" aria-label="With textarea" rows="5" id="descripcion" name="descripcion"></textarea>
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

<!-- CRUD PRODUCTO JS -->
<script src="../../js/admin/CRUD_producto.js"></script>

</body>

</html>