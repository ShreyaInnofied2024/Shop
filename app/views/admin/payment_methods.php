<style>
    #paymentPieChart {
    max-width: 1000px;  /* Set max width for the chart */
    max-height: 1000px; /* Set max height for the chart */
    margin: 0 auto;    /* Center the chart */
}
</style>

<div class="container my-5">
    <h3 class="text-center">Payment Methods Distribution</h3>
    <!-- Adjust width and height for a smaller size -->
    <canvas id="paymentPieChart" width="100" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('paymentPieChart').getContext('2d');
    const data = <?= json_encode($data['methods']); ?>;
    const labels = data.map(method => method.payment_method);
    const values = data.map(method => method.method_count);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>
