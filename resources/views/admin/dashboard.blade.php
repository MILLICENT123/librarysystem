@extends('layout.master') 

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Admin Dashboard</h1>

    {{-- Statistics Section --}}
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light border-primary mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Total Books</h5>
                    <h3 class="display-4 fw-bold">{{ $totalBooks }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-success mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Available Books</h5>
                    <h3 class="display-4 fw-bold">{{ $availableBooks }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-warning mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">Borrowed Books</h5>
                    <h3 class="display-4 fw-bold">{{ $borrowedBooks }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light border-danger mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Total Borrowed Records</h5>
                    <h3 class="display-4 fw-bold">{{ $totalBorrowedBooks }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Book Availability Trends</h5>
                    <canvas id="availabilityTrendsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const availabilityTrendsCtx = document.getElementById('availabilityTrendsChart').getContext('2d');
    new Chart(availabilityTrendsCtx, {
        type: 'pie',
        data: {
            labels: ['Available Books', 'Borrowed Books'],
            datasets: [{
                data: [{{ $availableBooks }}, {{ $borrowedBooks }}],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
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
