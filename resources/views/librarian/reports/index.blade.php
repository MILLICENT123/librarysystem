@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4 text-center text-primary">Books Reports</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg mb-4">
                <div class="card-body">
                    <h5 class="card-title">Books Status</h5>
                    <canvas id="booksStatusChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('booksStatusChart').getContext('2d');
    var booksStatusChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: @json($bookStatusLabels),
            datasets: [{
                label: 'Books Status',
                data: @json($bookStatusData),
                backgroundColor: ['#36A2EB', '#FFCD56'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 1
            }]
        }
    });
</script>
@endsection
