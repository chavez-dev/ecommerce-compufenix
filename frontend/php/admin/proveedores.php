<?php include("../../include/cabecera.php"); ?>
    
<title>Proveedores - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/proveedores.css">

<?php include("../../include/sidebar.php"); ?>


    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-principal">
        <div class="container-fluid">
            <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado"><i class="fa-solid fa-plus" style="color: #ffffff;"></i> Agregar Proveedor</button>
        </div>
        
        <div class="container-fluid" style="margin-top:20px">
            <div class="row ">
                <div class="col-lg-12 ">
                    <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                        <thead class="text-center">
                            <!-- <tr> -->
                                <th class="text-center bg-info-subtle">ID</th>
                                <th class="text-center bg-info-subtle">Tipo</th>
                                <th class="text-center bg-info-subtle">Nro. Documento</th>
                                <th class="text-center bg-info-subtle">Nombre</th>
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

    </main>
    <!-- CONTENIDO PRINCIPAL -->

    <!-- MODAL PARA AGREGAR PROVEEDORES -->
<div class="modal fade modal__empleado" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" id="modal-form-header">
                <i class="fa-solid fa-address-card icon" style="font-size: 25px; margin: 12px"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">REGISTRO DE PROVEEDOR</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnClose"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" id="formulario-empleado">
                    <div class="row">
                        <h5> Datos Proveedor</h5>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tipo_documento" class="col-form-label">Tipo de Documento:</label>
                                <select class="form-control text-center form-select border-dark-subtle" id="tipo_documento" name="tipo_documento" required>
                                    <option value="" disabled selected hidden>Seleccione</option>
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label for="nro_documento" class="col-sm-12 col-form-label">Nro. Documento:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm text-center border-dark-subtle" id="nro_documento" name="nro_documento" required>
                                    <span class="alerta-documento" id="alertaClienteRegistrado" style="display: none;"></span>
                                </div>
                                <button type="button" class="col-sm-3 btn btn-info text-white" id="btn-buscar">Buscar</button>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group row">
                                <label for="nombre" class="col-form-label col-sm-2" style="margin-bottom: 2px;">Nombre:</label>
                                <div class="col-sm-10">    
                                    <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center border-dark-subtle" id="nombre" name="nombre" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="departamento" class="col-form-label">Departamento:</label>
                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center border-dark-subtle" id="departamento" name="departamento" required>
                            </div>
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
                        
                        <div class="col-md-12">
                            <label  class="col-form-label">Categoria:</label>
                            <div class="row">
                                <?php
                                    include("../../../backend/config/conexion.php");
                                    $sql5 = "SELECT id_categoria_producto, nombre_categoria FROM categoria_producto";
                                    $stmt5 = $conexion->query($sql5);
                                    while ($fila5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<div class="col-md-6">'.
                                        '<div class="form-check">'.
                                        '<input name="categorias[]" value="' . $fila5['id_categoria_producto'] . '" class="form-check-input border-dark-subtle" type="checkbox" id="categoria_' . $fila5['id_categoria_producto'] . '">'.
                                        '<label class="form-check-label" for="categoria_' . $fila5['id_categoria_producto'] . '">' . $fila5['nombre_categoria'] . '</label>'.
                                        '</div></div>';
                                    }
                                ?>
                            </div>
                        </div>

                    </div>

                    <br>

                    

                    <div class="row">
                        <h5> Información de Contacto </h5>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="direccion" class="col-form-label col-sm-2">Dirección:</label>
                                <div class="col-sm-10"> 
                                    <input type="text" oninput="this.value = this.value.toUpperCase()" class="form-control form-control-sm text-center border-dark-subtle" id="direccion" name="direccion" required>
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

<!-- CRUD PROVEEDOR JS -->
<script src="../../js/admin/CRUD_proveedor.js"></script>

<script>
    // CONECTANDO CON EL API DNI Y TRAE LOS DATOS
    var seleccionarTipo = document.querySelector('#tipo_documento');
    let alertaRegistroCliente = document.querySelector('#alertaClienteRegistrado');
    var tipoDocumento;

    seleccionarTipo.addEventListener("change", function(){
        // ! Limpiamos los inputs al cambiar de tipo de documento
        $('#nro_documento, #nombre, #departamento, #nacionalidad, #email, #celular, #direccion').val('');

        alertaRegistroCliente.style.display = 'none';  

        tipoDocumento = seleccionarTipo.value;
        console.log(tipoDocumento);

        // Llamar a la función según el tipo de documento seleccionado
        if(tipoDocumento == 'DNI'){
            consultarDNI('proveedor');
            
        } else {
            consultarRUC('proveedor');
        }
    });

    // Función para consultar el DNI
    function consultarDNI(tipoUsuario) {
        $("#btn-buscar").off("click").on("click", function() {
            var dni = $("#nro_documento").val();
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
                        alertaRegistroCliente.textContent = data.message;
                        alertaRegistroCliente.style.display = 'block';  
                    } else {
                        console.log(data);
                        var nombreCompleto = data.nombres + ' ' + data.apellidoPaterno + ' ' + data.apellidoMaterno;
                        $("#nombre").val(nombreCompleto);
                    }
                }
            });
        });
    }

    // Función para consultar el RUC
    function consultarRUC(tipoUsuario) {
        $("#btn-buscar").off("click").on("click", function() {
            var ruc = $("#nro_documento").val();
            $.ajax({
                type: "POST",
                url: "../../../backend/consultas/API_ruc.php",
                data: {
                    ruc: ruc,
                    tipoUsuario: tipoUsuario
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status === "error") {
                        // Mostrar el span cuando el DNI ya está registrado
                        alertaRegistroCliente.textContent = data.message;
                        alertaRegistroCliente.style.display = 'block';  
                    } else {
                        $('#alertaClienteRegistrado').hide();
                        $("#nombre").val(data.razonSocial);
                        $("#direccion").val(data.direccion);
                        $("#departamento").val(data.departamento);
                    }
                }
            });
        });
    }

</script>

</body>

</html>
