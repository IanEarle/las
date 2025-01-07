<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/Dashboard.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-circle"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            <a class="nav-link" href="#"><i class="fas fa-calendar-check"></i><span>Bookings</span></a>
            <a class="nav-link" href="#"><i class="fas fa-user"></i><span>Users</span></a>
            <a class="nav-link" href="#"><i class="fas fa-store"></i><span>Shops</span></a>
        </nav>
    </div>

    <div class="content">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <p>Welcome back, Admin! Here's a quick overview of your laundry services.</p>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text">1,234</p>
                        </div>
                        <i class="fas fa-users card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Total Shops</h5>
                            <p class="card-text">567</p>
                        </div>
                        <i class="fas fa-shopping-cart card-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title">Booking Appointment</h5>
                            <p class="card-text">89</p>
                        </div>
                        <i class="fas fa-clipboard-list card-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Growth</h5>
                        <div class="chart-container">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Shop Growth</h5>
                        <div class="chart-container">
                            <canvas id="shopGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="Assets/js/Dashboard.js"></script>
</body>
</html>
