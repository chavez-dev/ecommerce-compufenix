<?php include("../../include/cabecera.php"); ?>
    
<title>Serie - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/serie.css">

<?php include("../../include/sidebar.php"); ?>


    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-principal">
        <div class="container-fluid">
            <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Serie</button>
        </div>
        
        <div class="container-fluid" style=" margin-top:20px">
            <div class="row ">
                <div class="col-lg-12 ">
                    <div class="table-responsive">
                        <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                            <thead class="text-center">
                                <!-- <tr> -->
                                    <th class="text-center bg-info-subtle">ID</th>
                                    <th class="text-center bg-info-subtle">Tipo</th>
                                    <th class="text-center bg-info-subtle">Serie</th>
                                    <th class="text-center bg-info-subtle">Inicio</th>
                                    <th class="text-center bg-info-subtle">Correlativo</th>
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
        </div>
    </main>
    <!-- CONTENIDO PRINCIPAL -->

<!-- MODAL PARA AGREGAR METODO DE PAGO -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE SERIE</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado">
                    <div class="row">
                        <h5> Datos de Serie</h5>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_serie" class="col-form-label">Tipo de Comprobante:</label>
                                <select class="form-control text-center form-select border-dark-subtle" id="tipo_serie" name="tipo_serie" required>
                                    <option value="BOLETA">BOLETA</option>
                                    <option value="FACTURA">FACTURA</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="serie" class="col-form-label">Nombre de Serie:</label>
                                <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="serie" name="serie" required>
                            </div>
                        </div>
                                    
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="correlativo" class="col-form-label">Inicio de Correlativo:</label>
                                <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="correlativo" name="correlativo" required>
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <div class="form-group justify-content-center text-center">
                                <label for="estado" class="col-form-label">Estado:</label>
                                <div class="form-check form-switch justify-content-center text-center">
                                    <input class="form-check-input text-center border-dark-subtle" type="checkbox" role="switch" id="estado"  name="estado" checked >
                                </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- ALERTAS JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- SIDEBAR JS -->
<script src="../../js/admin/sidebar.js"></script>

<!-- CRUD METODO DE PAGO JS -->
<script src="../../js/admin/CRUD_serie.js"></script>

</body>

</html>