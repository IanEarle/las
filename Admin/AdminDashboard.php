<?php
session_start();
include '../Partials/db_conn.php';

// ✅ Check if Admin is Logged In
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Fetch Total Users and Shops
$total_users = 0;
$total_shops = 0;

$user_stmt = $conn->prepare("SELECT COUNT(*) FROM users");
$user_stmt->execute();
$user_stmt->bind_result($total_users);
$user_stmt->fetch();
$user_stmt->close();

$shop_stmt = $conn->prepare("SELECT COUNT(*) FROM shop_owners");
$shop_stmt->execute();
$shop_stmt->bind_result($total_shops);
$shop_stmt->fetch();
$shop_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 50px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white">Admin Panel</h4>
        <a href="AdminDashboard.php">Dashboard</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_shops.php">Manage Shops</a>
        <a class="nav-link" href="../login.php"><i class="fas fa-sign-in-alt"></i> Log out</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, Admin!</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $total_users; ?></h4>
                        <p class="card-text">Registered users in the system.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Shops</div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $total_shops; ?></h4>
                        <p class="card-text">Registered shops in the system.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
