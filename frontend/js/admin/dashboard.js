document.addEventListener("DOMContentLoaded", function() {
    const salesChart = document.getElementById("salesChart").getContext("2d");
    const trafficChart = document.getElementById("trafficChart").getContext("2d");

    // Gráfico de Ventas
    new Chart(salesChart, {
        type: 'line',
        data: {
            labels: ["Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [{
                label: 'Orders',
                data: [0, 0, 0, 0, 0, 6, 2],
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

    // Gráfico de Tráfico por Dispositivo
    new Chart(trafficChart, {
        type: 'bar',
        data: {
            labels: ["HP victius", "Asus TUF", "Acer Nitro 5", "Monitor ViewFinity S5", "Laptop Asus Vivobook 16", "Otros"],
            datasets: [{
                label: 'Users',
                data: [2, 1, 1, 1, 1, 1],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)'
                ]
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
});