<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9f7f5;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            margin: 20px auto;
            flex-wrap: wrap; /* Wrap charts on smaller screens */
            padding: 20px;
            max-width: 1200px;
        }

        .chart-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            flex: 1 1 500px; /* Flex item with equal size */
            max-width: 500px; /* Maximum width for each chart */
        }

        canvas {
            width: 100% !important; /* Adjust canvas to fit container */
            height: 350px !important; /* Set consistent height */
        }

        h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="chart-container">
            <h3>Sales by Date</h3>
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-container">
            <h3>Sales by Payment Method</h3>
            <canvas id="pieChart"></canvas>
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
</body>
</html>
