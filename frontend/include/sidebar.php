</head>
<body>
    
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="../admin/dashboard.php" class="brand"><i class="fa-solid fa-store icon"></i>COMPUFENIX</a>
        <ul class="side-menu">
            <li class="divider" data-text="MENU">MENU</li>
            <li>
                <a href="../admin/dashboard.php" class="btn_dashboard">
                    <i class="fa-solid fa-square-poll-horizontal icon"></i>Dashboard
                </a>
            </li>


            <li>
                <a href="../admin/ventas.php" class="btn_ventas">
                    <i class="fa-solid fa-hand-holding-dollar icon"></i>Ventas
                </a>
            </li>
            
            <li>
                <a href="../admin/compras.php" class="btn_compras">
                    <i class="fa-solid fa-cart-arrow-down icon"></i>Compras
                </a>
            </li>

            <!-- <li>
                <a href="../admin/POS.php" class="btn_POS">
                    <i class="fa-solid fa-desktop icon"></i>POS
                </a>
            </li> -->

            <li>
                <a href="#" class="btn_producto">
                    <i class="fa-solid fa-box-archive icon"></i>Productos
                    <i class="fa-solid fa-chevron-down icon-right"></i>
                </a>
                <ul class="side-dropdown list-productos">
                    <li class="centrar-a"><a href="../admin/producto.php" >Lista de Productos</a></li>
                    <li class="centrar-b"><a href="../admin/categoria.php">Lista de Categorias</a></li>
                </ul>
            </li>
            
            <li>
                <a href="../admin/clientes.php" class="btn_clientes">
                    <i class="fa-solid fa-users icon"></i>Clientes
                </a>
            </li>
            <li>
                <a href="../admin/proveedores.php" class="btn_proveedores">
                    <i class="fa-solid fa-user-tie icon"></i>Proveedores
                </a>
            </li>
            <li>
                <a href="../admin/empleados.php" class="btn_empleado">
                    <i class="fa-solid fa-address-card icon"></i>Empleados
                </a>
            </li>

            <li>
                <a href="#" class="btn_recibo">
                    <i class="fa-solid fa-clipboard-list icon"></i>Facturas
                    <i class="fa-solid fa-chevron-down icon-right"></i>
                </a>
                <ul class="side-dropdown list-facturas">
                    <li class="centrar-c"><a href="../admin/recibo.php">Lista de Recibos</a></li>
                    <li class="centrar-d"><a href="../admin/metodo_pago.php">Metodo de Pago</a></li>
                </ul>
            </li>

            <li>
                <a href="#" class="btn_inventario">
                    <i class="fa-solid fa-clipboard-list icon"></i>Inventario
                    <i class="fa-solid fa-chevron-down icon-right"></i>
                </a>
                <ul class="side-dropdown list-inventario">
                    <li class="centrar-e"><a href="../admin/inventario.php">Lista Inventario</a></li>
                    <li class="centrar-f"><a href="../admin/estado.php">Estado</a></li>
                </ul>
            </li>


            <!-- <li class="divider" data-text="Table and forms">Table and forms</li> -->
           

            <li>
                <a href="../admin/reportes.php" class="btn_reportes">
                    <i class="fa-solid fa-flag icon"></i>Reportes
                </a>
            </li>

            <li>
                <a href="../admin/configuracion.php" class="btn_configuracion">
                    <i class="fa-solid fa-gears icon"></i>Configuracion
                </a>
            </li>

        </ul>

        <div class="ads">
            <div class="wrapper">
                <a href="../../../backend/validacion/cerrar_sesion.php" class="btn-upgrade">
                    <i class="fa-solid fa-right-to-bracket icon"></i>Cerrar Sesión
                </a>
            </div>
        </div>
    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav id="navbar">
			<i class='fa-solid fa-bars toggle-sidebar' ></i>
			<form action="#">
				<div class="nav_buscador">
					<!-- <input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i> -->
				</div>
			</form>

            <style>
                .dropdown-alerts {
                    display: none;
                    position: absolute;
                    right: 350px;
                    top: 20px;
                    background-color: #fff;
                    min-width: 300px;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                    z-index: 1;
                }

                .dropdown-alerts .alert {
                    padding: 15px;
                    border-bottom: 1px solid #ddd;
                }

                .dropdown-alerts .alert:last-child {
                    border-bottom: none;
                }

            </style>
			<a href="#" class="nav-link" id="alertas">
                <i class="fa-solid fa-bell icon"></i>
                <span class="badge">0</span>
            </a>
            <div class="dropdown-alerts" id="alertasDropdown">
                <!-- Los mensajes de alerta se cargarán aquí -->
            </div>

            <script >
                function actualizarAlertas() {
                    $.ajax({
                        url: '../../../backend/consultas/obtener_alertas.php',
                        method: 'GET',
                        success: function(response) {
                            var alertas = JSON.parse(response);
                            var numeroAlertas = alertas.length;
                            $('#alertas .badge').text(numeroAlertas);

                            var alertasDropdown = $('#alertasDropdown');
                            alertasDropdown.empty(); // Limpiar el contenido anterior

                            alertas.forEach(function(alerta) {
                                
                                var alertaHtml = `
                                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                    <div class="toast-header">
                                        <strong class="me-auto">Alerta de Stock</strong>
                                        <small>${alerta.registro_mensaje}</small>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        ${alerta.mensaje}
                                    </div>
                                    </div>`;
                                alertasDropdown.append(alertaHtml);
                            });

                            /// Inicializar los toasts
                            $('.toast').each(function() {
                                var toastElement = new bootstrap.Toast(this, {
                                    autohide: false
                                });
                                toastElement.show();
                            });
                        }
                    });
                }

                // Llamar a la función para actualizar las alertas cada 60 segundos
                setInterval(actualizarAlertas, 60000);

                // Llamar a la función inmediatamente cuando se cargue la página
                $(document).ready(function() {
                    actualizarAlertas();

                    // Mostrar u ocultar el menú desplegable de alertas
                    $('#alertas').on('click', function(e) {
                        e.preventDefault();
                        $('#alertasDropdown').toggle();
                    });

                    // Cerrar el menú desplegable si se hace clic fuera de él
                    $(document).on('click', function(e) {
                        if (!$(e.target).closest('#alertas').length) {
                            $('#alertasDropdown').hide();
                        }
                    });
                });
                
            </script>

			<a href="#" class="nav-link" id="notificaciones">
                <i class="fa-solid fa-message icon"></i>
				<span class="badge">8</span>
			</a>
			<span class="divider"></span>
            <p class="text-center pt-3">

                <?php  
                // * Mostrar Nombre de Empleado en el Sistema
                include("../../../backend/config/conexion.php");
                $usuario_login = $_SESSION['usuario']; 
                $consulta = "SELECT * FROM empleado WHERE DNI = $usuario_login ";
                $stmt = $conexion->prepare($consulta);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                    $nombre_empleado = $fila['nombre'];
                    $cadena_formateada_nombre = ucwords(strtolower($nombre_empleado));
                    $apellido_empleado = $fila['apellido'];
                    $cadena_formateada_apellido = ucwords(strtolower($apellido_empleado));
                }
                ?>
                
                <span id="nombreEmpleado"><?php echo $cadena_formateada_nombre ?></span><br>
                <span id="apellidoEmpleado"><?php echo $cadena_formateada_apellido ?></span>
            </p>
			<div class="profile">
                
				<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
				<ul class="profile-link">
					<li><a href="#"><i class="fa-solid fa-circle-user"></i> Perfil</a></li>
					<li><a href="#"><i class="fa-solid fa-gear icon"></i>Configuracion</a></li>
					<li><a href="../../../backend/validacion/cerrar_sesion.php"><i class="fa-solid fa-right-to-bracket"></i> Salir</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->
