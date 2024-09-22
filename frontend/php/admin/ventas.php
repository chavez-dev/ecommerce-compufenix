<?php include("../../include/cabecera.php"); ?>
    
<title>Ventas - Compufenix</title>
<link rel="stylesheet" href="../../css/admin/ventas.css">

<?php include("../../include/sidebar.php"); ?>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-principal">
    <div class="container-fluid">
        <button type="button" class="btn btn-success empleado-boton-agregar" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat" id="agregarEmpleado">Agregar Venta</button>
    </div>

    <div class="container-fluid" style=" margin-top:20px">
        <div class="row ">
            <div class="col-lg-12 ">
                <table id="tablaUsuarios" class=" table table-striped table-bordered " style="width:100%;">
                    <thead class="text-center" >
                        <!-- <tr> -->
                        <th class="text-center bg-info-subtle">ID</th>
                        <th class="text-center bg-info-subtle">Fecha Registro</th>
                        <th class="text-center bg-info-subtle">Documento Cliente</th>
                        <th class="text-center bg-info-subtle">Nombre de Cliente</th>
                        <th class="text-center bg-info-subtle">Nro Comprobante</th>
                        <th class="text-center bg-info-subtle">Total</th>
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

<!-- CRUD VENTA JS -->
<script src="../../js/admin/CRUD_venta.js"></script>

<!-- <script>
    var inputCantidad = document.querySelector('#cantidad_compra');
    var inputPrecioUnitario = document.querySelector('#precio_unitario');
    var inputPrecioTotal = document.querySelector('#pago_total');
    var precioTotal;

    inputCantidad.addEventListener("input", actualizarPrecioTotal);
    inputPrecioUnitario.addEventListener("input", actualizarPrecioTotal);

    inputCantidad.addEventListener("input", function(){
        var cantidad = parseInt(this.value);
        agregarInputsSeries(cantidad);
    })

    function actualizarPrecioTotal() {
        var cantidad = parseFloat(inputCantidad.value);
        var precioUnitario = parseFloat(inputPrecioUnitario.value);

        if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
            precioTotal = cantidad * precioUnitario;
            inputPrecioTotal.value = precioTotal; // Asignamos el valor al campo de pago_total
            console.log(precioTotal);
        } else {
            inputPrecioTotal.value = ''; // Borramos el valor si no es un número válido
        }
    }

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
    

</script> -->
</body>

</html>