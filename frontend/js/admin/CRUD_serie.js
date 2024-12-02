$(document).ready(function(){

    var btnReload = document.getElementById('btnReload');
    var btnAgregarEmpleado = document.getElementById('agregarEmpleado');
    var modalHeader = document.getElementById("modal-form-header");
    var btnRegistrarEmpleado = document.getElementById("registrar-empleado");
    var tipoOperacion = document.getElementById("operacion");
    var operacion
    
    $("#agregarEmpleado").click(function(){
        $('#formulario-empleado')[0].reset();
        $('.modal-title').text("REGISTRO DE SERIE");
        $('#registrar-empleado').val("Crear");
        $('#operacion').val("Crear");
        // desbloquearCamposYBotones();
        modalHeader.classList.remove("modal-editar");
        modalHeader.classList.remove("modal-ver");
        btnRegistrarEmpleado.classList.remove('btn-warning');
        btnRegistrarEmpleado.innerText= "Registrar";
    })
    
    // ! FUNCIONALIDAD DE DATATABLES
    var dataTable = $('#tablaUsuarios').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: '../../../backend/consultas/listas/lista_serie.php',
            type: 'POST',
        },
        "columnDefs":[{
            "targets":[3],
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

    // !  AGREGAR SERIE
    $(document).on('submit','#formulario-empleado',function(event){
        event.preventDefault();
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_serie.php",
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

                // Ajustar la tabla al recargar
                // var table = $('#miTabla').DataTable(); // Suponiendo que 'miTabla' es el ID de tu tabla DataTable
                // table.ajax.reload(function(){
                //     table.columns.adjust().draw();
                // });
            }
        });
        
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
        var checkbox = document.getElementById("estado");
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_serie.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                desbloquearCamposYBotones();
                $('#tipo_serie').val(data.tipo_serie);
                $('#serie').val(data.serie);
                $('#correlativo').val(data.correlativo);
                if(data.estado == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('.modal-title').text("EDITAR SERIE");
                $('#registrar-empleado').val("Editar");
                $('#operacion').val("Editar");
                
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

    // ! BORRAR: ELIMINA METODO DE PAGO
    $(document).on('click', '.borrar', function(){
        // Extraemos el valor del id de la clase .borrar
        var id_usuario = $(this).attr("id");
        operacion= 'borrar';
        console.log(id_usuario);
        Swal.fire({
            title: "Borrar Registro?",
            text: "Estas seguro de borrar esta Serie!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#bbb",
            confirmButtonText: "Si, Borrar!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../../backend/consultas/CRUDS/CRUD_serie.php",
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

    // ! VER: MUESTRA TODOS LOS DATOS METODO DE PAGO
    $(document).on('click', '.ver', function(){
        modalHeader.classList.add("modal-ver"); // Cambiamos el color del header del modal 
        var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
        operacion= 'actualizar';
        $('#id_usuario').val(id_usuario);
        var checkbox = document.getElementById("estado");
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_serie.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                $('#tipo_serie').val(data.tipo_serie);
                $('#serie').val(data.serie);
                $('#correlativo').val(data.correlativo);
                if(data.estado == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('.modal-title').text("VER SERIE");
                $('#id_usuario').val(id_usuario);

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
    $('#tipo_serie, #serie, #correlativo')
        .prop('disabled', true);
    $('#registrar-empleado').hide();
    let checkboxEstado = document.getElementById("estado");
    checkboxEstado.disabled = true;
}

// Función para desbloquear los campos y mostrar los botones
function desbloquearCamposYBotones() {
    $('#tipo_serie, #serie, #correlativo')
        .prop('disabled', false);
    $('#registrar-empleado').show();
    let checkboxEstado = document.getElementById("estado");
    checkboxEstado.disabled = false;
}