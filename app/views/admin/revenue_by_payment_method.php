<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue by Payment Method</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Revenue by Payment Method</h1>

        <div class="card mt-4">
            <div class="card-body">
                <canvas id="paymentMethodChart"></canvas>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('paymentMethodChart').getContext('2d');
            var paymentMethodChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode(array_column($data, 'payment_method')); ?>,
                    datasets: [{
                        data: <?php echo json_encode(array_column($data, 'total_revenue')); ?>,
                        backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1'],
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>
    </div>
</body>
</html>
