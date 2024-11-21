<?php
$data['revenues'] = [
    (object) ['revenue_date' => '2024-11-02', 'daily_revenue' => '9600'],
    (object) ['revenue_date' => '2024-11-04', 'daily_revenue' => '144000'],
    (object) ['revenue_date' => '2024-11-05', 'daily_revenue' => '84000'],
    (object) ['revenue_date' => '2024-11-09', 'daily_revenue' => '11864'],
    (object) ['revenue_date' => '2024-11-11', 'daily_revenue' => '7200']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div style="width: 80%; margin: 0 auto;">
        <canvas id="revenueChart"></canvas>
    </div>

    <script>
        // PHP data passed to JavaScript
        const revenueData = <?php echo json_encode($data['revenues']); ?>;

        // Extracting the dates and revenue values from the data
        const labels = revenueData.map(item => item.revenue_date);
        const dataValues = revenueData.map(item => item.daily_revenue);

        // Create the chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'line' for a line chart
            data: {
                labels: labels, // Dates on x-axis
                datasets: [{
                    label: 'Daily Revenue',
                    data: dataValues, // Revenue values on y-axis
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Bar color
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString(); // Format the y-axis labels
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
