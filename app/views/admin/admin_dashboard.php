<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .bg-custom {
        background-color: #f9f7f5;
    }
</style>
</head>
<body class="bg-custom">
<div class="container my-5">
    <h1 class="text-center mb-4">Dashboard</h1>
    <div class="row gy-4">
        <!-- Line Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5 class="mb-0">Sales by Date</h5>
                </div>
                <div class="card-body p-0">
                    <canvas id="lineChart" class="w-100" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h5 class="mb-0">Sales by Payment Method</h5>
                </div>
                <div class="card-body p-0">
                    <canvas id="pieChart" class="w-100" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php
    // Prepare data for Line Chart (Revenue by Date)
    $lineLabels = [];
    $lineRevenues = [];
    foreach ($data['revenueByDate'] as $entry) {
        $lineLabels[] = $entry->order_date;
        $lineRevenues[] = $entry->total_revenue;
    }

    // Prepare data for Pie Chart (Revenue by Payment Method)
    $pieLabels = [];
    $pieRevenues = [];
    foreach ($data['revenueByPaymentMethod'] as $entry) {
        $pieLabels[] = $entry->shipping_method;
        $pieRevenues[] = $entry->total_revenue;
    }
    ?>

    <script>
        // Line Chart Data
        const lineLabels = <?php echo json_encode($lineLabels); ?>;
        const lineData = <?php echo json_encode($lineRevenues); ?>;

        // Pie Chart Data
        const pieLabels = <?php echo json_encode($pieLabels); ?>;
        const pieData = <?php echo json_encode($pieRevenues); ?>;

        // Line Chart
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [{
                    label: 'Total Sales by Date',
                    data: lineData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Order Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Sales by Payment Method',
                    data: pieData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
