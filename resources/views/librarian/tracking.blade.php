<!-- In librarian/tracking.blade.php -->
@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Track Borrowed Books</h1>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">User Borrow Statistics</h5>
                    <canvas id="borrowChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the data passed from the controller
    const userNames = {!! json_encode($userNames) !!};
    const borrowCounts = {!! json_encode($borrowCounts) !!};

    // Chart.js setup
    const ctx = document.getElementById('borrowChart').getContext('2d');
    const borrowChart = new Chart(ctx, {
        type: 'pie', // You can use 'pie' or 'bar' depending on preference
        data: {
            labels: userNames,
            datasets: [{
                label: 'Books Borrowed by User',
                data: borrowCounts,
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'],
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
                            return tooltipItem.label + ': ' + tooltipItem.raw + ' books';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
