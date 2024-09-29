$(document).ready(function(){

    var btnReload = document.getElementById('btnReload');
    var btnAgregarEmpleado = document.getElementById('agregarEmpleado');
    var checkbox = document.getElementById("status");
    var modalHeader = document.getElementById("modal-form-header");
    var btnRegistrarEmpleado = document.getElementById("registrar-empleado");
    var tipoOperacion = document.getElementById("operacion");
    var inputStock = document.getElementById("stock");
    var operacion
    
    $("#agregarEmpleado").click(function(){
        $('#formulario-empleado')[0].reset();
        $('.modal-title').text("REGISTRO DE PRODUCTO");
        $('#registrar-empleado').val("Crear");
        $('#operacion').val("Crear");
        $('#imagen_subida').html("");
        desbloquearCamposYBotones();
        $('#stock').prop('disabled', true);
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
            url: '../../../backend/consultas/lista_producto.php',
            type: 'POST',
        },
        "columnDefs":[{
            "targets":[1,6,7,8],
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

    // !  AGREGAR PRODUCTO
    $(document).on('submit','#formulario-empleado',function(event){
        event.preventDefault();
        var extension = $("#imagen_producto").val().split('.').pop().toLowerCase();
        if (extension != '') {
            if (jQuery.inArray(extension, ['png','jpg','jpeg','gif','webp','avif']) == -1) {
                alert("Formato de imagen invalido");
                $('#imagen_producto').val('');
                return false;
            }
        }
        
        $.ajax({
            url: "../../../backend/consultas/CRUD_producto.php",
            method: "POST",
            data: new FormData(this), // Para la imagenes
            contentType: false,
            processData: false,
            success:function(data){
                console.log(data); // Verifica qué datos devuelve el servidor
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la llamada AJAX: ", textStatus, errorThrown);
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
        $.ajax({
            url: "../../../backend/consultas/CRUD_producto.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                desbloquearCamposYBotones();
                $('#nombre_producto').val(data.nombre_producto);
                $('#imagen_subida').html(data.imagen_producto);
                console.log(data.imagen_producto);
                console.log("adasd");
                // $('#imagen_producto').val(data.imagen_producto);
                $('#modelo').val(data.modelo);
                $('#categoria').val(data.categoria);
                var precioUnitario = data.precio_unitario.toString().replace('.00', '');
                $('#precio_unitario').val(precioUnitario);

                if(data.status == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('#stock_minimo').val(data.stock_minimo);
                $('#stock').val(data.stock);
                $('#descripcion').val(data.descripcion);
                $('#codigo_producto').val(id_usuario);
                $('.modal-title').text("EDITAR EMPLEADO");
                $('#id_usuario').val(id_usuario);
                $('#registrar-empleado').val("Editar");
                $('#operacion').val("Editar");

            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

    // ! BORRAR: ELIMINA PRODUCTO
    $(document).on('click', '.borrar', function(){
        // Extraemos el valor del id de la clase .borrar
        var id_usuario = $(this).attr("id");
        operacion= 'borrar';
        console.log(id_usuario);
        Swal.fire({
            title: "Borrar Registro?",
            text: "Estas seguro de borrar este Producto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#bbb",
            confirmButtonText: "Si, Borrar!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../../backend/consultas/CRUD_producto.php",
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

    // ! VER: MUESTRA TODOS LOS DATOS DEL PRODUCTO
    $(document).on('click', '.ver', function(){
        modalHeader.classList.add("modal-ver"); // Cambiamos el color del header del modal 
        var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
        operacion= 'actualizar';
        $('#id_usuario').val(id_usuario);
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUD_producto.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                $('#nombre_producto').val(data.nombre_producto);
                // $('#imagen_producto').val(data.imagen_producto);
                $('#imagen_subida').html(data.imagen_producto);
                $('#modelo').val(data.modelo);
                $('#categoria').val(data.categoria);
                var precioUnitario = data.precio_unitario.toString().replace('.00', '');
                $('#precio_unitario').val(precioUnitario);
                if(data.status == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('#stock_minimo').val(data.stock_minimo);
                $('#stock').val(data.stock);
                $('#descripcion').val(data.descripcion);
                $('#codigo_producto').val(id_usuario); 
                $('.modal-title').text("VER PRODUCTO");
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
    $('#codigo_producto, #nombre_producto, #modelo, #categoria, #imagen_producto, #precio_unitario, #status, #stock, #stock_minimo, #descripcion ')
        .prop('disabled', true);
    $('#registrar-empleado, #btn-buscar , #imagen_producto').hide();
}

// Función para desbloquear los campos y mostrar los botones
function desbloquearCamposYBotones() {
    $('#codigo_producto, #nombre_producto, #modelo, #categoria, #imagen_producto,#precio_unitario, #status, #stock, #stock_minimo, #descripcion ')
        .prop('disabled', false);
    $('#registrar-empleado, #btn-buscar ,#imagen_producto').show();
}