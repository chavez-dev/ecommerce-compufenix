document.addEventListener("DOMContentLoaded", function() {
    const salesChart = document.getElementById("salesChart").getContext("2d");
    const trafficChart = document.getElementById("trafficChart").getContext("2d");

    // Gráfico de Ventas
    new Chart(salesChart, {
        type: 'line',
        data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
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

    // Gráfico de Tráfico por Dispositivo
    new Chart(trafficChart, {
        type: 'bar',
        data: {
            labels: ["Linux", "Mac", "iOS", "Windows", "Android", "Other"],
            datasets: [{
                label: 'Users',
                data: [5000, 8000, 6000, 10000, 7000, 3000],
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
