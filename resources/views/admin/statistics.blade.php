@extends('layout.master')

@section('title', 'Statistics')

@section('content')
    <div class="container">
        <h1>Statistics</h1>

        @if(count($months) > 0 && count($availableBooks) > 0)
            <div class="row">
                <div class="col-md-12">
                    <canvas id="availabilityChart"></canvas>
                </div>
            </div>

            <script>
                // Get the months and availableBooks data from the server
                const months = @json($months);
                const availableBooks = @json($availableBooks);

                // Create the chart
                var ctx = document.getElementById('availabilityChart').getContext('2d');
                var availabilityChart = new Chart(ctx, {
                    type: 'bar', // Bar chart type
                    data: {
                        labels: months, // Labels for the X-axis (months)
                        datasets: [{
                            label: 'Available Books',
                            data: availableBooks, // Data for the Y-axis (number of available books)
                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // Bar color
                            borderColor: 'rgba(54, 162, 235, 1)', // Border color
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return 'Available: ' + tooltipItem.raw;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @else
            <p>No data available to show.</p>
        @endif
    </div>
@endsection
