<?php include("../../include/cabecera.php"); ?>

<title>Empleados - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/empleados.css">


<?php include("../../include/sidebar.php"); ?>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-principal">
    <div class="container-fluid">
        <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Empleado</button>
    </div>

    <div class="container-fluid" style="margin-top:20px">
        <div class="row ">
            <div class="col-lg-12 ">
                <div class="table-responsive">
                    <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                        <thead class="text-center">
                            <!-- <tr> -->
                                <th class="text-center bg-info-subtle">ID</th>
                                <th class="text-center bg-info-subtle">DNI</th>
                                <th class="text-center bg-info-subtle">Nombre Completo</th>
                                <th class="text-center bg-info-subtle">Cargo</th>
                                <th class="text-center bg-info-subtle">Estado</th>
                                <th class="text-center bg-info-subtle">Celular</th>
                                <th class="text-center bg-info-subtle">Email</th>
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

<!-- MODAL PARA AGREGAR EMPLEADOS -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE EMPLEADO</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado">
                    <div class="row">
                        <h5> Datos Personales</h5>
                        <div class="col-md-11 ">
                            <div class="form-group row">
                                <label for="dni" class="col-sm-2 col-form-label">DNI:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="dni" name="dni" required>
                                    <span class="alerta-documento" id="alertaClienteRegistrado" ></span>
                                </div>
                                <button type="button" class="col-sm-3 btn btn-info text-white" id="prueba">Buscar</button>
                            </div>
                        </div>
                
                    
                        <div class="col-md-12 mt-2">
                            <div class="form-group row">
                                <label for="nombre" class="col-form-label col-sm-2" style="margin-bottom: 2px;">Nombres:</label>
                                <div class="col-sm-10">    
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="nombre" name="nombre" required>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="apellido" class="col-form-label col-sm-2" style="margin-bottom: 2px;">Apellidos:</label>
                                <div class="col-sm-10">    
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="apellido" name="apellido" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                                <label for="fecha_nac" class="col-form-label text-center">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control form-control-sm text-center border-dark-subtle" id="fecha_nac" name="fecha_nac" required>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nacionalidad" class="col-form-label">Nacionalidad:</label>
                                <select class="form-control text-center form-select border-dark-subtle" id="nacionalidad" name="nacionalidad" required>
                                    <option value="" disabled selected hidden>Seleccione un pais</option>
                                    <option value="PER">Perú</option>
                                    <option value="ARG">Argentina</option>
                                    <option value="COL">Colombia</option>
                                    <option value="VEN">Venezuela</option>
                                    <option value="ECU">Ecuador</option>
                                    <option value="BOL">Bolivia</option>
                                    <option value="---">Otro</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-3">
                        <h5> Información de Contacto </h5>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="direccion" class="col-form-label col-sm-2">Dirección:</label>
                                <div class="col-sm-10"> 
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="direccion" name="direccion" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control form-control-sm text-center border-dark-subtle" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="celular" class="col-form-label">Celular:</label>
                                <input type="tel" class="form-control form-control-sm text-center border-dark-subtle" id="celular" name="celular" required>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row mt-3">
                        <h5>Datos del Empleado</h5>
                        <div class="col-md-2">
                            <div class="form-group text-center">
                                <label for="codigo_empleado" class="col-form-label ">Codigo:</label>

                                <?php
                                    include("../../../backend/config/conexion.php");
                                    $sql_ultimo_codigo = "SELECT MAX(id_empleado) AS max_id FROM empleado";
                                    $stmt = $conexion->query($sql_ultimo_codigo);
                                    if ($stmt->rowCount() > 0) {
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $ultimo_id = $row["max_id"];
                                        $siguiente_id = $ultimo_id + 1;
                                    }
                                ?>

                                <input type="text" class="form-control text-center border-dark-subtle" id="codigo_empleado" value="<?php echo $siguiente_id ?>" readonly name="codigo_empleado">
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="form-group text-center">
                                <label for="area" class="col-form-label">Cargo:</label>
                                <select class="form-control text-center form-select border-dark-subtle" id="area" name="area" required>
                                    <option value="" disabled selected hidden>Seleccione</option>
                                    <!-- <option value="Administrador">Administrador</option>
                                    <option value="Atencion al Cliente">Atencion al Cliente</option>
                                    <option value="Inventario">Inventario</option> -->
                                    <?php 
                                        $sql = "SELECT id_cargo, nombre_cargo FROM cargo";
                                        $stmt = $conexion->query($sql);
                                        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $fila['id_cargo'] . '">' . $fila['nombre_cargo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="form-group justify-content-center text-center">
                                <label for="estado" class="col-form-label">Estado:</label>
                                <div class="form-check form-switch justify-content-center text-center">
                                    <input class="form-check-input text-center border-dark-subtle" type="checkbox" role="switch" id="estado"  name="estado" checked>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group text-center">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="text" class="form-control form-control-sm text-center border-dark-subtle" placeholder="*********" id="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <input  name="id_usuario" id="id_usuario" type="hidden" >
                        <input  name="operacion" id="operacion" type="hidden" >
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
<script src="../../js/admin/CRUD_empleado.js"></script>

<script>
    // CONECTANDO CON EL API DNI Y TRAER LOS DATOS
    $("#prueba").click(function() {
            var dni = $("#dni").val();
            var tipoUsuario = 'empleado';
            $.ajax({
                type: "POST",
                url: "../../../backend/consultas/API_dni.php",
                data: {
                    dni: dni,
                    tipoUsuario: tipoUsuario
                },
                dataType: 'json',
                success: function(data) {
                    
                    if (data.status === "error") {
                        // Mostrar el span cuando el DNI ya está registrado
                        $("#alertaClienteRegistrado").text(data.message).show(); 
                    }else {
                        $('#alertaClienteRegistrado').hide();
                        $("#nombre").val(data.nombres);
                        var apellidoCompleto = data.apellidoPaterno + ' ' + data.apellidoMaterno;
                        $("#apellido").val(apellidoCompleto);
                    }
                }
            });
        });
</script>

</body>

</html>