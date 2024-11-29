

$(document).ready(function(){
    
    
    var btnReload = document.getElementById('btnReload');
    var btnAgregarCompra = document.getElementById('agregar_compra');
    var modalHeader = document.getElementById("modal-form-header");
    var btnRegistrarCompra = document.getElementById("registrar_compra");
    var tipoOperacion = document.getElementById("operacion");
    
    $("#agregar_compra").click(function(){
        $('#formulario-empleado')[0].reset();
        $('.modal-title').text("REGISTRO DE VENTA");
        $('#registrar_compra').val("Crear");
        $('#operacion').val("Crear");
        // modalHeader.classList.remove("modal-editar");
        
        // btnRegistrarCompra.classList.remove('btn-warning');
        // btnRegistrarCompra.innerText= "Registrar";

        const fechaEmisionInput = document.getElementById("fecha_emision");
        if (fechaEmisionInput) {
            const peruDate = new Date().toLocaleDateString('en-CA', { // Formato ISO (YYYY-MM-DD)
                timeZone: 'America/Lima',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
            fechaEmisionInput.value = peruDate;
        }

        
    })
    
    // ! FUNCIONALIDAD DE DATATABLES
    var dataTable = $('#tablaUsuarios').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url: '../../../backend/consultas/listas/lista_ventas.php',
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


    // ! AGREGAR VENTA
    $(document).on('submit','#formulario-empleado',function(event){
        event.preventDefault();

        console.log("Entrando ajax");
        
        
        // Recopilar los datos de los detalles de venta desde la tabla
        let detallesVenta = [];
        $('#tabla_detalle_venta tbody tr').each(function () {
            const producto = $(this).find('td').eq(0).text(); // Producto
            const cantidad = $(this).find('td').eq(1).text(); // Cantidad
            const precio = $(this).find('td').eq(2).text(); // Precio
            const importe = $(this).find('td').eq(3).text(); // Importe

            // Agregar a un array los detalles de la venta
            detallesVenta.push({
                producto: producto,
                cantidad: parseInt(cantidad),
                precio: parseFloat(precio),
                importe: parseFloat(importe),
            });
        });

        console.log(detallesVenta);
        

        // Convertir el array a JSON
        const detallesVentaJSON = JSON.stringify(detallesVenta);

        console.log(detallesVentaJSON);
        

        // Crear un objeto FormData para enviar datos al servidor
        const formData = new FormData(this);
        formData.append('detalles_venta', detallesVentaJSON); // Agregar los detalles de venta como JSON


         $.ajax({
            url: "../../../backend/consultas/CRUDS/CRUD_venta.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#formulario-empleado')[0].reset();
                btnReload.click(); // Cerrar el modal

                // Parsear la respuesta del backend (JSON)
                var response = JSON.parse(data);
        
                if (tipoOperacion.value === "Crear") {
                    Swal.fire({
                        icon: "success",
                        title: "Registro Exitoso!",
                        text: "Se ha registrado correctamente!",
                        showConfirmButton: true, // Mostrar el botón
                        confirmButtonText: 'Ver Comprobante',
                        confirmButtonColor: '#3085d6',
                        // Acción al hacer clic en el botón
                        preConfirm: () => {
                            const idVenta = response.id_venta; ; // Asegurarse de que el ID de la venta esté en la respuesta
                            window.open(`../../../backend/consultas/comprobante/ticket.php?id_venta=${idVenta}`, '_blank'); // Redirigir al comprobante
                        }
                    });
                }
                if (tipoOperacion.value === "Editar") {
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

    $(document).on('click', '.comprobante', function() {
        var idVenta = $(this).attr('id'); // Obtener el id_venta del botón
        // Abrir el comprobante en una nueva ventana
        window.open(`../../../backend/consultas/comprobante/ticket.php?id_venta=${idVenta}`, '_blank');
    });

    // // ! EDITAR: TRAER DATOS DE LA BD
    // $(document).on('click', '.editar', function(){
    //     modalHeader.classList.remove("modal-ver");
    //     modalHeader.classList.add("modal-editar"); // Cambiamos el color del header del modal 
    //     btnRegistrarCompra.innerText= "Editar"; // Cambiamos el texto del boton
    //     btnRegistrarCompra.classList.add('btn-warning'); // Agregamos una clase para cambiar el color del boton
    //     var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
    //     operacion= 'actualizar';
    //     $('#id_usuario').val(id_usuario);
    //     console.log(id_usuario);
    //     $.ajax({
    //         url: "../../../backend/consultas/CRUD_compra.php",
    //         method: "POST",
    //         data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
    //         dataType: "json",
    //         success:function(data){
    //             $('#exampleModal').modal('show');
    //             desbloquearCamposYBotones();
    //             $('#producto').val(data.id_producto);
    //             $('#proveedor').val(data.id_proveedor);
    //             $('#cantidad_compra').val(data.cantidad_compra);
    //             $('#precio_unitario').val(data.precio_unitario);
    //             $('#factura').val(data.factura);
    //             $('#metodo_pago').val(data.metodo_pago);
    //             $('#pago_total').val(data.pago_total);
    //             $('#descripcion').val(data.descripcion);
    //             $('.modal-title').text("EDITAR COMPRA");
    //             $('#id_usuario').val(id_usuario);
    //             $('#registrar-empleado').val("Editar");
    //             $('#operacion').val("Editar");
                
    //             // Agregar los inputs de serie
    //             agregarInputsSeries(data.series.length);

    //             // Asignar los valores de los números de serie a los inputs correspondientes
    //             data.series.forEach((serie, index) => {
    //                 $('#serie' + (index + 1)).val(serie);
    //             });
    //             $('#inputSeries input').prop('disabled', true);


    //         },
    //         error: function(jqXHR, textStatus, errorThrown){
    //             console.log(textStatus, errorThrown);
    //         }
    //     });
    // });

    // ! BORRAR: ELIMINA VENTA
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
                    url: "../../../backend/consultas/CRUDS/CRUD_venta.php",
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


    // // ! EDITAR : MUESTRA TODOS LOS DATOS DE LA COMPRA
    // $(document).on('click', '.ver', function(){
    //     modalHeader.classList.add("modal-ver"); // Cambiamos el color del header del modal 
    //     var id_usuario = $(this).attr("id"); // Obtenemos el id_empleado de la clase .editar
    //     operacion= 'actualizar';
    //     $('#id_usuario').val(id_usuario);
    //     console.log(id_usuario);
    //     $.ajax({
    //         url: "../../../backend/consultas/CRUD_compra.php",
    //         method: "POST",
    //         data:{id_usuario:id_usuario, operacion:operacion}, // Para la imagenes
    //         dataType: "json",
    //         success:function(data){
    //             $('#exampleModal').modal('show');
    //             $('#producto').val(data.id_producto);
    //             $('#proveedor').val(data.id_proveedor);
    //             $('#cantidad_compra').val(data.cantidad_compra);
    //             $('#precio_unitario').val(data.precio_unitario);
    //             $('#factura').val(data.factura);
    //             $('#metodo_pago').val(data.metodo_pago);
    //             $('#pago_total').val(data.pago_total);
    //             $('#descripcion').val(data.descripcion);
    //             $('.modal-title').text("VER COMPRA");
    //             $('#id_usuario').val(id_usuario);
                
    //             // Agregar los inputs de serie
    //             agregarInputsSeries(data.series.length);
                
    //             // Asignar los valores de los números de serie a los inputs correspondientes
    //             data.series.forEach((serie, index) => {
    //                 $('#serie' + (index + 1)).val(serie);
    //             });
    //             bloquearCamposYBotones();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown){
    //             console.log(textStatus, errorThrown);
    //         }
    //     });
    // });

});

// // Función para bloquear los campos y ocultar los botones
// function bloquearCamposYBotones() {
//     $('#producto, #proveedor, #empleado, #cantidad_compra, #precio_unitario, #factura, #metodo_pago, #pago_total, #descripcion')
//         .prop('disabled', true);
//     $('#registrar-empleado').hide();
//     $('#inputSeries input').prop('disabled', true);
// }

// // Función para desbloquear los campos y mostrar los botones
// function desbloquearCamposYBotones() {
//     $('#producto, #proveedor, #empleado, #cantidad_compra, #precio_unitario, #factura, #metodo_pago, #pago_total, #descripcion')
//         .prop('disabled', false);
//     $('#registrar-empleado').show();
// }
