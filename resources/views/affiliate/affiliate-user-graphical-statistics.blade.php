<x-welcome-layout>
<div>

    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Affiliate links performance overview (graphical) for affiliate account owner {{ $user->name }}</h1>

    <div class="mt-16">
        <canvas id="chart-click-count-comparison"></canvas>
    </div>

     <div class="mt-16">
        <canvas id="chart-conversion-count-comparison"></canvas>
     </div>

     <div class="mt-16">
        <canvas id="chart-conversion-ratio-comparison"></canvas>
     </div>


    <script>
        const click_count_comparison_chart_canvas = document.getElementById('chart-click-count-comparison');
        const conversion_count_comparison_chart_canvas = document.getElementById('chart-conversion-count-comparison');
        const conversion_ratio_comparison_chart_canvas = document.getElementById('chart-conversion-ratio-comparison');

        const click_count_comparison_chart = new Chart(click_count_comparison_chart_canvas, {
            type: 'bar',
            options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: @json($statistics['chart-click-count-comparison']['title']),
                        font: {
                            size: 20,
                        }
                    }
                }
            },
            data: {
                labels: @json($statistics['labels']),
                datasets: [{
                    data: @json($statistics['chart-click-count-comparison']['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });

        const conversion_count_comparison_chart = new Chart(conversion_count_comparison_chart_canvas, {
            type: 'bar',
            options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: @json($statistics['chart-conversion-count-comparison']['title']),
                        font: {
                            size: 20,
                        }
                    }
                }
            },
            data: {
                labels: @json($statistics['labels']),
                datasets: [{
                    data: @json($statistics['chart-conversion-count-comparison']['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });

        const conversion_ratio_comparison_chart = new Chart(conversion_ratio_comparison_chart_canvas, {
            type: 'bar',
            options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: @json($statistics['chart-conversion-ratio-comparison']['title']),
                        font: {
                            size: 20,
                        }
                    }
                }
            },
            data: {
                labels: @json($statistics['labels']),
                datasets: [{
                    data: @json($statistics['chart-conversion-ratio-comparison']['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
        });
    </script>
</div>
</x-welcome-layout>
