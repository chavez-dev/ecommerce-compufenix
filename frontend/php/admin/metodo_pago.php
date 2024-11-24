<?php include("../../include/cabecera.php"); ?>
    
<title>Método Pago - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/metodo_pago.css">

<?php include("../../include/sidebar.php"); ?>


    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-principal">
        <div class="container-fluid">
            <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Método de Pago</button>
        </div>
        
        <div class="container-fluid" style=" margin-top:20px">
            <div class="row ">
                <div class="col-lg-12 ">
                    <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                        <thead class="text-center">
                            <!-- <tr> -->
                                <th class="text-center bg-info-subtle">ID</th>
                                <th class="text-center bg-info-subtle">Nombre</th>
                                <th class="text-center bg-info-subtle">Descripcion</th>
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

<!-- MODAL PARA AGREGAR METODO DE PAGO -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE CATEGORIA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado">
                    <div class="row">
                        <h5> Datos Categoria</h5>

                        <div class="col-md-3">
                            <div class="form-group text-center">
                                <label for="id_metodo_pago" class="col-form-label ">Codigo:</label>

                                <?php
                                    include("../../../backend/config/conexion.php");
                                    $sql_ultimo_codigo = "SELECT MAX(id_metodo_pago) AS max_id FROM metodo_pago";
                                    $stmt = $conexion->query($sql_ultimo_codigo);
                                    if ($stmt->rowCount() > 0) {
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $ultimo_id = $row["max_id"];
                                        $siguiente_id = $ultimo_id + 1;
                                    }
                                ?>

                                <input type="text" class="form-control text-center border-dark-subtle" id="id_metodo_pago" value="<?php echo $siguiente_id ?>" readonly name="id_metodo_pago">
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="form-group text-center">
                                <label for="nombre_metodo" class="col-form-label">Nombre de Método de Pago:</label>
                                <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="nombre_metodo" name="nombre_metodo" required>
                            </div>
                        </div>
                                    
                        <div class="col-md-12">
                            <br>
                            <div class="input-group">
                                <span class="input-group-text">Descripcion</span>
                                <textarea class="form-control border-dark-subtle" aria-label="With textarea" rows="3" id="descripcion" name="descripcion"></textarea>
                            </div>
                        </div>
                        
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
<script src="../../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- ALERTAS JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- SIDEBAR JS -->
<script src="../../js/admin/sidebar.js"></script>

<!-- CRUD METODO DE PAGO JS -->
<script src="../../js/admin/CRUD_metodo_pago.js"></script>

</body>

</html>