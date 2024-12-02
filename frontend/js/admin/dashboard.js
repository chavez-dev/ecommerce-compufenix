document.addEventListener("DOMContentLoaded", function() {
    const salesChart = document.getElementById("salesChart").getContext("2d");
    const trafficChartCanvas = document.getElementById("trafficChart").getContext("2d");

    // Gráfico de Ventas
    new Chart(salesChart, {
        type: 'line',
        data: {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio"],
            datasets: [{
                label: 'Orders',
                data: [200, 300, 456, 400, 500, 600, 750],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { display: true },
                y: { display: true }
            }
        }
    });

    // Gráfico de Tráfico por Dispositivo (actualizado para datos dinámicos)
    fetch('http://localhost/ecommerce-compufenix/backend/consultas/obtener_ranking_productos.php') // Ajusta la ruta según tu servidor
        .then(response => response.json())
        .then(data => {
            // Extraer los nombres de los productos y los totales vendidos
            const labels = data.map(item => item.nombre_producto); // Ajusta la propiedad si es necesario
            const values = data.map(item => item.total_vendido); // Ajusta la propiedad si es necesario

            // Configuración del gráfico de barras
            new Chart(trafficChartCanvas, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Usuarios',
                        data: values,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)',
                            'rgba(255, 159, 64, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Producto'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Total Vendido'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error al cargar los datos:', error));
        console.log(data);
});
