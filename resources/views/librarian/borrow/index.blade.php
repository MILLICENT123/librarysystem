@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Librarian Dashboard</h1>

    {{-- Statistics Section --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-lg border-primary mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Total Borrowed Books</h5>
                    <h3 class="display-4 fw-bold">{{ $totalBorrowedBooks }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-success mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Total Returned Books</h5>
                    <h3 class="display-4 fw-bold">{{ $totalReturnedBooks }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-danger mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Total Fines Issued</h5>
                    <h3 class="display-4 fw-bold">${{ number_format($totalFinesIssued, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-lg mb-4">
                <div class="card-body">
                    <h5 class="card-title">Borrowing Trends (Monthly)</h5>
                    <canvas id="borrowingTrendsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg mb-4">
                <div class="card-body">
                    <h5 class="card-title">Fines Collected (Monthly)</h5>
                    <canvas id="finesCollectedChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Borrowing Trends Chart
    const borrowingTrendsCtx = document.getElementById('borrowingTrendsChart').getContext('2d');
    new Chart(borrowingTrendsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($borrowingTrendsLabels) !!},
            datasets: [{
                label: 'Books Borrowed',
                data: {!! json_encode($borrowingTrendsData) !!},
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
            }
        }
    });

    // Fines Collected Chart
    const finesCollectedCtx = document.getElementById('finesCollectedChart').getContext('2d');
    new Chart(finesCollectedCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($finesCollectedLabels) !!},
            datasets: [{
                label: 'Fines Collected ($)',
                data: {!! json_encode($finesCollectedData) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
            }
        }
    });
</script>
@endsection
