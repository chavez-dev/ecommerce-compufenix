$(document).ready(function(){

    var btnReload = document.getElementById('btnReload');
    var btnAgregarEmpleado = document.getElementById('agregarEmpleado');
    var checkbox = document.getElementById("estado");
    var modalHeader = document.getElementById("modal-form-header");
    var btnRegistrarEmpleado = document.getElementById("registrar-empleado");
    var tipoOperacion = document.getElementById("operacion");
    var operacion
    
    $("#agregarEmpleado").click(function(){
        $('#formulario-empleado')[0].reset();
        $('.modal-title').text("REGISTRO DE PROVEEDOR");
        $('#registrar-empleado').val("Crear");
        $('#operacion').val("Crear");
        desbloquearCamposYBotones();
        modalHeader.classList.remove("modal-editar");
        modalHeader.classList.remove("modal-ver");
        btnRegistrarEmpleado.classList.remove('btn-warning');
        btnRegistrarEmpleado.innerText= "Registrar";
        $('#alertaClienteRegistrado').hide();
    })
    
    // ! FUNCIONALIDAD DE DATATABLES
    var dataTable = $('#tablaUsuarios').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: '../../../backend/consultas/listas/lista_proveedores.php',
            type: 'POST',
        },
        "columnDefs":[{
            "targets":[6,4],
            "orderable": false,
            },
        ],
        "language": {
            "decimal": "",
            "emptyTable": "No hay registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous" : "Anterior"
            } 
        }
    });

    // !  AGREGAR PROVEEDOR
    $(document).on('submit','#formulario-empleado',function(event){
        event.preventDefault();
        var nro_documento = $("#nro_documento").val();
        var nombre = $("#nombre").val();

        if (nombre != '' && nro_documento != '') {
            $.ajax({
                url: "../../../backend/consultas/CRUDS/CRUD_proveedor.php",
                method: "POST",
                data: new FormData(this), // Para la imagenes
                contentType: false,
                processData: false,
                success:function(data){
                    $('#formulario-empleado')[0].reset();
                    btnReload.click(); // Para Cerrar el modal
                    if(tipoOperacion.value == "Crear"){
                        Swal.fire({
                            icon: "success",
                            title: "Registro Exitoso!",
                            text: "Se ha registrado correctamente!",
                            timer: 1500,
                        });
                    }
                    if(tipoOperacion.value == "Editar"){
                        Swal.fire({
                            icon: "success",
                            title: "Cambios Guardados!",
                            text: "Se guardaron los cambios correctamente!",
                            timer: 1500,
                        });
                    }
                    dataTable.ajax.reload(); // Recargar la tabla
                }
            });
        }else{
            alert("Algunos campos son obligatorios");
        }
    });

    // ! Genera el Reporte de Venta
    $(document).on('click', '#reporte_proveedor', function () {
        window.open('../../../backend/consultas/reporte_proveedor.php', '_blank');
    });

    // ! EDITAR: TRAER DATOS DE LA BD
    $(document).on('click', '.editar', function(){
        modalHeader.classList.remove("modal-ver");
        modalHeader.classList.add("modal-editar"); // Cambiamos el color del header del modal 
        btnRegistrarEmpleado.innerText= "Editar"; // Cambiamos el texto del boton
        btnRegistrarEmpleado.classList.add('btn-warning'); // Agregamos una clase para cambiar el color del boton
        var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
        operacion= 'actualizar';
        $('#id_usuario').val(id_usuario);
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_proveedor.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                desbloquearCamposYBotones();
                $('#tipo_documento').val(data.tipo_proveedor);
                $('#nro_documento').val(data.nro_documento);
                $('#nombre').val(data.nombre);
                $('#departamento').val(data.departamento);
                $('#nacionalidad').val(data.nacionalidad);
                $('#email').val(data.email);
                $('#celular').val(data.celular);
                $('#direccion').val(data.direccion);
                $('.modal-title').text("EDITAR PROVEEDOR");
                $('#id_usuario').val(id_usuario);
                $('#registrar-empleado').val("Editar");
                $('#operacion').val("Editar");
                
                // Desmarcamos todos los checkboxes antes de marcar los correspondientes
                $('input[type=checkbox]').prop('checked', false);

                // Marcamos los checkboxes correspondientes a las categorías de productos asociadas al proveedor
                // data.categorias_productos.forEach(function(categoria) {
                //     $('#' + categoria).prop('checked', true);
                // });

                data.categorias_productos.forEach(function(id_categoria) {
                    // Seleccionar el checkbox cuyo id es "categoria_ID"
                    $('#categoria_' + id_categoria).prop('checked', true);
                });
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

    // ! BORRAR: ELIMINA PROVEEDOR
    $(document).on('click', '.borrar', function(){
        // Extraemos el valor del id de la clase .borrar
        var id_usuario = $(this).attr("id");
        operacion= 'borrar';
        console.log(id_usuario);
        Swal.fire({
            title: "Borrar Registro?",
            text: "Estas seguro de borrar este empleado!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#bbb",
            confirmButtonText: "Si, Borrar!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../../backend/consultas/CRUDS/CRUD_proveedor.php",
                    method: "POST",
                    data:{id_usuario:id_usuario,operacion: operacion},
                    success:function(data){
                        dataTable.ajax.reload();
                        // Mensaje de eliminacion
                        Swal.fire({
                            title: "Eliminado!",
                            text: "El registro fue eliminado.",
                            icon: "success"
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
                
            }
        });
    })

    // ! VER: MUESTRA TODOS LOS DATOS DEL PROVEEDOR
    $(document).on('click', '.ver', function(){
        modalHeader.classList.add("modal-ver"); // Cambiamos el color del header del modal 
        var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
        operacion= 'actualizar';
        $('#id_usuario').val(id_usuario);
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_proveedor.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                $('#tipo_documento').val(data.tipo_proveedor); 
                $('#nro_documento').val(data.nro_documento); 
                $('#nombre').val(data.nombre); 
                $('#departamento').val(data.departamento); 
                $('#nacionalidad').val(data.nacionalidad); 
                $('#email').val(data.email); 
                $('#celular').val(data.celular); 
                $('#direccion').val(data.direccion); 
                $('.modal-title').text("VER PROVEEDOR");
                $('#id_usuario').val(id_usuario);

                // Desmarcamos todos los checkboxes antes de marcar los correspondientes
                $('input[type=checkbox]').prop('checked', false);

                // Marcamos los checkboxes correspondientes a las categorías de productos asociadas al proveedor
                data.categorias_productos.forEach(function(id_categoria) {
                    // Seleccionar el checkbox cuyo id es "categoria_ID"
                    $('#categoria_' + id_categoria).prop('checked', true);
                });

                bloquearCamposYBotones();
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

});

// Función para bloquear los campos y ocultar los botones
function bloquearCamposYBotones() {
    $('#tipo_documento, #nro_documento, #nombre, #departamento, #nacionalidad, #email, #celular, #direccion')
        .prop('disabled', true);
    $('#registrar-empleado, #btn-buscar').hide();
    $('input[type=checkbox]').prop('disabled', true);
}

// Función para desbloquear los campos y mostrar los botones
function desbloquearCamposYBotones() {
    $('#tipo_documento, #nro_documento, #nombre, #departamento, #nacionalidad, #email, #celular, #direccion')
        .prop('disabled', false);
    $('#registrar-empleado, #btn-buscar').show();
    $('input[type=checkbox]').prop('disabled', false);
}