<?php include("../../include/cabecera.php"); ?>
    
    <title>Dashboard -Compufenix</title>
    <link rel="stylesheet" href="../../css/admin/dashboard.css">

<?php include("../../include/sidebar.php"); ?>


<!-- CONTENIDO PRINCIPAL -->       
<main class="main-principal">
    <div class="row">
        <!-- Total de usuarios -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body d-flex justify-content-between align-items-center text-white">
                    <span>Total de usuarios</span>
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <div class="card-footer text-white">
                    <a href="#" class="text-white">Ver detalles</a>
                </div>
            </div>
        </div>

        <!-- Total de pedidos -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body d-flex justify-content-between align-items-center text-white">
                    <span>Total de pedidos</span>
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <div class="card-footer text-white">
                    <a href="#" class="text-white">Ver detalles</a>
                </div>
            </div>
        </div>

        <!-- Total de ventas -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning">
                <div class="card-body d-flex justify-content-between align-items-center text-white">
                    <span>Total de ventas</span>
                    <i class="fas fa-dollar-sign fa-2x"></i>
                </div>
                <div class="card-footer text-white">
                    <a href="#" class="text-white">Ver detalles</a>
                </div>
            </div>
        </div>

        <!-- Total de pendientes -->
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger">
                <div class="card-body d-flex justify-content-between align-items-center text-white">
                    <span>Total de pendientes</span>
                    <i class="fas fa-exclamation-circle fa-2x"></i>
                </div>
                <div class="card-footer text-white">
                    <a href="#" class="text-white">Ver detalles</a>
                </div>
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

<!-- CRUD PROVEEDOR JS -->
<!-- <script src="../../js/admin/CRUD_producto.js"></script> -->

</body>

</html>
