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
    <h2>Total de ventas</h2>
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
            <h2>chavez se la come doblada</h2>
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
        <div class="traffic-chart">
            <h2>Traffic by Device</h2>
            <canvas id="trafficChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Tablas de ventas y compras recientes -->
    <div class="tables-section">
        <div class="recent-sales">
            <h2>Ventas Recientes</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Detail</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>2018/10/02 10:57:46</td>
                    <td>Producto A</td>
                    <td>S/ 3500</td>
                </tr>
                <tr>
                    <td>2018/10/10 10:57:46</td>
                    <td>Producto C</td>
                    <td>S/ 4000</td>
                </tr>
            </table>
        </div>
        <div class="recent-purchases">
            <h2>Compras Recientes</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Detail</th>
                    <th>Price</th>
                </tr>
                <tr>
                    <td>2018/10/10 10:57:46</td>
                    <td>Producto A</td>
                    <td>S/ 200</td>
                </tr>
                <tr>
                    <td>2018/10/23 10:57:46</td>
                    <td>Producto D</td>
                    <td>S/ 1500</td>
                </tr>
            </table>
        </div>
    </div>
</div>
</main>
<!-- FIN DEL CONTENIDO PRINCIPAL -->

<!-- Llamada AJAX para actualizar estadísticas -->

<script>
    //Obterner total de usuarios

document.addEventListener("DOMContentLoaded", function() {
    fetch('../../../consultas/obtener_cliente_d.php')
    .then(response => {
        console.log("Estado de la respuesta:", response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        console.log("Datos recibidos:", data);
        if (data.totalClientes !== undefined) {
            document.querySelector("#total-clientes").innerText = data.totalClientes;
        } else {
            console.error("Error en los datos recibidos:", data);
        }
    })
    .catch(error => console.error("Error al obtener el total de clientes:", error));
});

   // obtener ganancias totales
   document.addEventListener("DOMContentLoaded", function() {
    // Actualizar total de clientes
    fetch('../../../backend/consultas/obtener_cliente_d.php')
        .then(response => response.json())
        .then(data => {
            if (data.totalClientes !== undefined) {
                document.querySelector("#total-clientes").innerText = data.totalClientes;
            }
        })
        .catch(error => console.error("Error al obtener el total de clientes:", error));

    // Actualizar total de ganancias
    fetch('../../../backend/consultas/obtener_ganancias_d.php')
        .then(response => response.json())
        .then(data => {
            if (data.totalGanancias !== undefined) {
                document.querySelector("#total-ganancias").innerText = `$${data.totalGanancias}`;
            }
        })
        .catch(error => console.error("Error al obtener el total de ganancias:", error));
});

// obtener productos

document.addEventListener("DOMContentLoaded", function() {
    // Llamada AJAX para obtener el total de productos
    fetch('../../../backend/consultas/obtener_productos_d.php')
    .then(response => {
        console.log("Estado de la respuesta:", response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        console.log("Datos recibidos:", data);
        if (data.totalProductos !== undefined) {
            document.querySelector("#total-productos").innerText = data.totalProductos;
        } else {
            console.error("Error en los datos recibidos:", data);
        }
    })
    .catch(error => console.error("Error al obtener el total de productos:", error));
});

// obtener total de ventas
document.addEventListener("DOMContentLoaded", function() {
    // Llamada AJAX para obtener el total de ventas
    fetch('../../../backend/consultas/obtener_vendidos_d.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta de la red');
        }
        return response.json();
    })
    .then(data => {
        if (data.totalVentas !== undefined) {
            // Actualiza el elemento con el total de ventas
            document.querySelector("#total-ventas").innerText = data.totalVentas;
        } else {
            console.error("Error en los datos recibidos:", data);
        }
    })
    .catch(error => console.error("Error al obtener el total de ventas:", error));
});


</script>

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
