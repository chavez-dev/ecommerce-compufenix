<?php include("../../include/cabecera.php"); ?>
<title>Dashboard - conpufenix</title>
<link rel="stylesheet" href="../../css/admin/dashboard.css">
<link rel="stylesheet" href="../../css/admin/dash.css">

<!-- Incluye Bootstrap desde un CDN -->

<?php include("../../include/sidebar.php"); ?>

<body>

<!-- CONTENIDO PRINCIPAL -->

<main class="main-principal">
           
    <div class="dashboard">

    <!-- Total de clientes -->
    <div class="stats">
        <div class="stat-item">
            <div class="dashboard-icon">
                <!-- Ícono SVG de usuario -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                    <path d="M12 12c2.67 0 4.84-2.17 4.84-4.84S14.67 2.32 12 2.32 7.16 4.5 7.16 7.16 9.33 12 12 12zm0 2.32c-2.86 0-8.68 1.43-8.68 4.28v2.32h17.36v-2.32c0-2.85-5.82-4.28-8.68-4.28z"/>
                </svg>
            </div>
            <h2>Total Clientes</h2>
            <p id="total-clientes"></p> <!-- Este valor se actualizará dinámicamente -->
            <span><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="green" viewBox="0 0 24 24"><path d="M12 2l10 9h-7v11h-6v-11h-7z"/></svg> 8.5% Up from yesterday</span>
        </div>
    
        <!-- Total de productos -->

        <div class="stat-item">
    <div class="dashboard-icon">
        <!-- Ícono SVG de caja para representar productos -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
            <path d="M21 8h-18v14h18v-14zm-9 10h-6v-6h6v6zm2-6h6v6h-6v-6zm-5-8h4l1.2 4h-6.4l1.2-4zm8.56 1l-.56-1h-14l-.56 1h-3.44v2h22v-2h-3.44z"/>
        </svg>
    </div>
    <h2>Total de Productos</h2>
    <p id="total-productos"></p> <!-- Este valor se actualizará dinámicamente -->
    <span><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="green" viewBox="0 0 24 24"><path d="M12 2l10 9h-7v11h-6v-11h-7z"/></svg> Up from yesterday</span>
</div>



   <!-- Total de ganancias -->
<div class="stat-item">
    <div class="dashboard-icon">
        <!-- Ícono SVG de gráfico -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
            <path d="M12 3l7.76 7.76-1.41 1.42L12 6.84l-6.35 6.34-1.41-1.41L12 3zm0 6.92l6.36 6.36-1.41 1.41L12 11.75 7.05 16.7 5.64 15.29 12 9.92zm0 6.92l5.65 5.65-1.41 1.41L12 16.25 6.76 21.5l-1.41-1.41L12 16.84z"/>
        </svg>
    </div>
    <h2>Total Ganancias</h2>
    <p id="total-ganancias"></p> <!-- Este valor se actualizará dinámicamente -->
    <span><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="red" viewBox="0 0 24 24"><path d="M12 22l-10-9h7v-11h6v11h7z"/></svg> 4.3% Down from yesterday</span>
</div>

    <!-- Total de ventas -->
        <div class="stat-item">
            <div class="dashboard-icon">
                <!-- Ícono SVG de reloj -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                    <path d="M12 2c-5.53 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10zm1 13h-2v-6h2v6zm0-8h-2v-2h2v2z"/>
                </svg>
            </div>
            <h2>Total de ventas</h2>
            <p id="total-ventas"></p> <!-- Este valor se actualizará dinámicamente -->
            <span><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="green" viewBox="0 0 24 24"><path d="M12 2l10 9h-7v11h-6v-11h-7z"/></svg> 1.8% Up from yesterday</span>
        </div>
    </div>

   <!-- Sección de gráficos -->
   <div class="chart-section">
        <div class="sales-chart">
            <h2><center>Ventas</h2>
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
        <div class="traffic-chart">
            <h2><center></center>Productos mas vendidos</h2>
            <canvas id="trafficChart" width="400" height="200"></canvas>
        </div>
    </div>

<br>
<!-- Tablas de ventas y compras recientes -->


<div class="tables-section">
    <div class="recent-sales">
        <h2>Ventas Recientes</h2>
        <table id="ventas-table" class="display">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Incluir la conexión
                include("../../../backend/config/conexion.php");

                try {
                    // Configurar la conexión con atributos de error
                    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Realizar la consulta
                    $query = "SELECT fecha_hora_registro, cliente, pago_total FROM lista_ventas ORDER BY fecha_hora_registro  LIMIT 4";




                    $stmt = $conexion->query($query);

                    // Iterar sobre los resultados y generar las filas
                    if ($stmt->rowCount() > 0) {
                        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila['fecha_hora_registro']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['cliente']) . "</td>";
                            echo "<td>$" . number_format($fila['pago_total'], 2) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Mostrar mensaje si no hay datos
                        echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
                    }
                } catch (PDOException $e) {
                    // Manejo de errores
                    echo "<tr><td colspan='3'>Error al obtener los datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>



    <div class="recent-purchases">
    <h2>Compras Recientes</h2>
    <?php
    include("../../../backend/config/conexion.php");

    try {
        // Configurar la conexión con atributos de error
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Realizar la consulta para las 3 últimas compras
        $query = "SELECT fecha_hora_registro, detalle_producto, precio_total 
          FROM lista_compras 
          ORDER BY fecha_hora_registro DESC 
          LIMIT 4";
        $stmt = $conexion->query($query);

        // Contar filas obtenidas
        $totalFilas = $stmt->rowCount();

    ?>
    <table id="compras-table" class="display">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Detalle</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterar sobre los resultados y generar las filas
            if ($totalFilas > 0) {
                while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($fila['fecha_hora_registro']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['detalle_producto']) . "</td>";
                    echo "<td>$" . number_format($fila['precio_total'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                // Mostrar mensaje si no hay datos
                echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
    } catch (PDOException $e) {
        // Manejo de errores
        echo "<p>Error al obtener los datos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
    ?>
</div>

</div>

</main>
<!-- FIN DEL CONTENIDO PRINCIPAL -->

<!-- Llamada AJAX para actualizar estadísticas -->

<script>
    // Función genérica para obtener datos y actualizar elementos
    function obtenerDatos(url, selector, campo) {
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta de la red');
                }
                return response.json();
            })
            .then(data => {
                if (data[campo] !== undefined) {
                    document.querySelector(selector).innerText = data[campo];
                } else {
                    console.error("Error en los datos recibidos:", data);
                }
            })
            .catch(error => console.error(`Error al obtener datos de ${campo}:`, error));
    }

    // Ejecutar las llamadas al cargar la página
    document.addEventListener("DOMContentLoaded", function() {
        // Llamadas a la función con las URLs, selectores y campos necesarios
        obtenerDatos('../../../backend/consultas/obtener_cliente_d.php', '#total-clientes', 'totalClientes');
        obtenerDatos('../../../backend/consultas/obtener_ganancias_d.php', '#total-ganancias', 'totalGanancias');
        obtenerDatos('../../../backend/consultas/obtener_productos_d.php', '#total-productos', 'totalProductos');
        obtenerDatos('../../../backend/consultas/obtener_vendidos_d.php', '#total-ventas', 'totalVentas');
    });
</script>


<!-- no mover desde aca-->







<!-- Llamada AJAX para actualizar estadísticas -->

<!-- Librerías externas -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Bootstrap JS desde CDN para resolver el error de ruta -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Scripts personalizados -->
<script src="../../js/admin/dashboard.js"></script>
<script src="../../js/admin/sidebar.js"></script>

</body>
</html>
