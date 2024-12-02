
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
        $('.modal-title').text("REGISTRO DE COMPRA");
        $('#registrar-empleado').val("Crear");
        $('#operacion').val("Crear");
        modalHeader.classList.remove("modal-editar");
        btnRegistrarEmpleado.classList.remove('btn-warning');
        btnRegistrarEmpleado.innerText= "Registrar";
    })
    
    // ! FUNCIONALIDAD DE DATATABLES
    var dataTable = $('#tablaUsuarios').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: '../../../backend/consultas/listas/lista_compras.php',
            type: 'POST',
        },
        "columnDefs":[{
            "targets":[2],
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

    // ! AGREGAR COMPRA
    $(document).on('submit','#formulario-empleado',function(event){
        event.preventDefault();
        
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_compra.php",
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
        
    });

    // ! Genera el Reporte de Venta
    $(document).on('click', '#reporte_compra', function () {
        window.open('../../../backend/consultas/reporte_compra.php', '_blank');
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
            url: "../../../backend/consultas/CRUDS/CRUD_compra.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                desbloquearCamposYBotones();
                // Configurar el proveedor y cargar sus productos
                $('#proveedor').val(data.id_proveedor);
                cargarProductosPorProveedor(data.id_proveedor); // Cargar los productos

                // Esperar a que los productos se carguen y luego asignar el valor
                setTimeout(() => {
                    $('#producto').val(data.id_producto);
                }, 800); // Ajusta el tiempo si es necesario
                if(data.estado == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('#cantidad_compra').val(data.cantidad_compra);
                $('#precio_unitario').val(data.precio_unitario);
                $('#factura').val(data.factura);
                $('#metodo_pago').val(data.metodo_pago);
                $('#pago_total').val(data.pago_total);
                $('#descripcion').val(data.descripcion);
                $('.modal-title').text("EDITAR COMPRA");
                $('#id_usuario').val(id_usuario);
                $('#registrar-empleado').val("Editar");
                $('#operacion').val("Editar");
                
                // Agregar los inputs de serie
                agregarInputsSeries(data.series.length);

                // Asignar los valores de los números de serie a los inputs correspondientes
                data.series.forEach((serie, index) => {
                    $('#serie' + (index + 1)).val(serie);
                });
                $('#inputSeries input').prop('disabled', true);


            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        });
    });

    // ! BORRAR: ELIMINA COMPRA
    $(document).on('click', '.borrar', function(){
        // Extraemos el valor del id de la clase .borrar
        var id_usuario = $(this).attr("id");
        operacion= 'borrar';
        Swal.fire({
            title: "Borrar Registro?",
            text: "Estas seguro de borrar este compra!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#bbb",
            confirmButtonText: "Si, Borrar!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../../backend/consultas/CRUDS/CRUD_compra.php",
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


    // ! EDITAR : MUESTRA TODOS LOS DATOS DE LA COMPRA
    $(document).on('click', '.ver', function(){
        modalHeader.classList.add("modal-ver"); // Cambiamos el color del header del modal 
        var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
        operacion= 'actualizar';
        $('#id_usuario').val(id_usuario);
        console.log(id_usuario);
        $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_compra.php",
            method: "POST",
            data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
            dataType: "json",
            success:function(data){
                $('#exampleModal').modal('show');
                // Configurar el proveedor y cargar sus productos
                $('#proveedor').val(data.id_proveedor);
                cargarProductosPorProveedor(data.id_proveedor); // Cargar los productos

                // Esperar a que los productos se carguen y luego asignar el valor
                setTimeout(() => {
                    $('#producto').val(data.id_producto);
                }, 800); // Ajusta el tiempo si es necesario
                if(data.estado == 1){
                    checkbox.checked = true;
                }else{
                    checkbox.checked = false;
                }
                $('#cantidad_compra').val(data.cantidad_compra);
                $('#precio_unitario').val(data.precio_unitario);
                $('#factura').val(data.factura);
                $('#metodo_pago').val(data.metodo_pago);
                $('#pago_total').val(data.pago_total);
                $('#descripcion').val(data.descripcion);
                $('.modal-title').text("VER COMPRA");
                $('#id_usuario').val(id_usuario);
                
                // Agregar los inputs de serie
                agregarInputsSeries(data.series.length);
                
                // Asignar los valores de los números de serie a los inputs correspondientes
                data.series.forEach((serie, index) => {
                    $('#serie' + (index + 1)).val(serie);
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
    $('#producto, #proveedor, #empleado, #estado, #cantidad_compra, #precio_unitario, #factura, #metodo_pago, #pago_total, #descripcion')
        .prop('disabled', true);
    $('#registrar-empleado').hide();
    $('#inputSeries input').prop('disabled', true);
}

// Función para desbloquear los campos y mostrar los botones
function desbloquearCamposYBotones() {
    $('#producto, #proveedor, #empleado, #estado, #cantidad_compra, #precio_unitario, #factura, #metodo_pago, #pago_total, #descripcion')
        .prop('disabled', false);
    $('#registrar-empleado').show();
}
