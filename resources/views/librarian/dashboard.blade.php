@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    {{-- Welcome Section --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-light shadow-lg">
                <div class="card-body text-center">
                    <h4 class="card-title text-primary">Welcome to your Dashboard, Mr.Librarian😊</h4>
                    <p class="lead">Manage the library efficiently, monitor trends, and track performance.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Section --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-light border-primary shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Total Borrowed Books</h5>
                    <h3 class="display-4 fw-bold">{{ number_format($totalBorrowedBooks) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-success shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Total Returned Books</h5>
                    <h3 class="display-4 fw-bold">{{ number_format($totalReturnedBooks) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light border-danger shadow-lg">
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
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Borrowing Trends</h5>
                    <canvas id="borrowingTrendsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Fines Collected</h5>
                    <canvas id="finesCollectedChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Borrow Records --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Recent Borrow Records</h5>
                    @if($borrows->isEmpty())
                        <p class="text-muted">No borrowing records available.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Book Title</th>
                                    <th>Borrowed Date</th>
                                    <th>Due Date</th>
                                    <th>Fine</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrows as $index => $borrow)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $borrow->user->name }}</td>
                                    <td>{{ $borrow->book->title }}</td>
                                    <td>{{ $borrow->borrowed_at->format('d M Y') }}</td>
                                    <td>{{ $borrow->due_date->format('d M Y') }}</td>
                                    <td>${{ number_format($borrow->fine, 2) }}</td>
                                    <td>
                                        @if($borrow->returned_at)
                                            <span class="badge bg-success">Returned</span>
                                        @elseif($borrow->due_date->isPast())
                                            <span class="badge bg-danger">Overdue</span>
                                        @else
                                            <span class="badge bg-warning">Borrowed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });

    // Fines Collected Chart
    const finesCollectedCtx = document.getElementById('finesCollectedChart').getContext('2d');
    new Chart(finesCollectedCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($finesCollectedLabels) !!},
            datasets: [{
                label: 'Fines Collected',
                data: {!! json_encode($finesCollectedData) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
