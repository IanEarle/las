<?php
session_start();
include '../Partials/db_conn.php';

// ✅ Check if Admin is Logged In
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Fetch All Users
$all_users = [];
$user_stmt = $conn->prepare("SELECT id, name, email, phone, address, status, gov_id, gov_id_type, created_at FROM users ORDER BY created_at DESC");
$user_stmt->execute();
$result = $user_stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $all_users[] = $row;
}
$user_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
        .status-pending { color: orange; }
        .status-approved { color: green; }
        .status-rejected { color: red; }
        .file-links a {
            display: block;
            margin-bottom: 5px;
        }
        .btn-sm {
            font-size: 12px;
            padding: 5px 5px;
            line-height: 1;
            width: 100px;
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
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Manage Users</h2>
        <!-- ✅ Display Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_message']); ?></div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- ✅ Display Error Message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']); ?></div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        <h4 class="mt-4">All Registered Users</h4>
        <div class="card">
            <div class="card-body">
                <?php if (count($all_users) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Registered At</th>
                                <th>Files</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']); ?></td>
                                    <td><?= htmlspecialchars($user['name']); ?></td>
                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if ($user['status'] === 'pending'): ?>
                                            <span class="status-pending">Pending</span>
                                        <?php elseif ($user['status'] === 'approved'): ?>
                                            <span class="status-approved">Approved</span>
                                        <?php else: ?>
                                            <span class="status-rejected">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($user['created_at']); ?></td> <!-- ✅ Display Registered Time -->
                                    <td class="file-links">
                                        <?php if (!empty($user['gov_id']) && file_exists($user['gov_id'])): ?>
                                            <p><strong>ID Type:</strong> <?= htmlspecialchars($user['gov_id_type']) ?? 'Not Specified'; ?></p>
                                            <a href="<?= htmlspecialchars($user['gov_id']); ?>" target="_blank" class="btn btn-info btn-sm">View  ID</a>
                                        <?php else: ?>
                                            <span class="text-danger">No Government ID Uploaded</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($user['status'] === 'pending'): ?>
                                            <form method="POST" action="verify_user.php" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                                <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                                                <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-secondary">No Action Required</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
