<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <p class="card-text fs-4">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Open Tickets</h5>
                    <p class="card-text fs-4">{{ $openTickets }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <p class="card-text fs-4">{{ $inProgressTickets }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Closed Tickets</h5>
                    <p class="card-text fs-4">{{ $closedTickets }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS via CDN (if needed) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
