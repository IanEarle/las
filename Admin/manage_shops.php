<?php
session_start();
include '../Partials/db_conn.php';

// ✅ Check if Admin is Logged In
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Fetch Total Shops
$total_shops = 0;
$shop_stmt = $conn->prepare("SELECT COUNT(*) FROM shop_owners");
$shop_stmt->execute();
$shop_stmt->bind_result($total_shops);
$shop_stmt->fetch();
$shop_stmt->close();

// ✅ Fetch All Shops
$all_shops = [];
$shop_stmt = $conn->prepare("SELECT id, shop_name, phone, status, business_doc_path, business_papers, created_at FROM shop_owners ORDER BY created_at DESC");
$shop_stmt->execute();
$result = $shop_stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $all_shops[] = $row;
}
$shop_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shops</title>
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
        <h2>Manage Shops</h2>
        <!-- ✅ Display Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- ✅ Display Error Message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <h4 class="mt-4">All Registered Shops</h4>
        <div class="card">
            <div class="card-body">
                <?php if (count($all_shops) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Shop Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Registered At</th>
                                <th>Files</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_shops as $shop): ?>
                                <tr>
                                    <td><?= htmlspecialchars($shop['id']); ?></td>
                                    <td><?= htmlspecialchars($shop['shop_name']); ?></td>
                                    <td><?= htmlspecialchars($shop['phone']); ?></td>
                                    <td>
                                        <?php if ($shop['status'] === 'pending'): ?>
                                            <span class="status-pending">Pending</span>
                                        <?php elseif ($shop['status'] === 'approved'): ?>
                                            <span class="status-approved">Approved</span>
                                        <?php else: ?>
                                            <span class="status-rejected">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($shop['created_at']); ?></td>
                                    <td>
                                    <td class="file-links">
                                    <?php if (!empty($shop['business_doc_path']) && file_exists($shop['business_doc_path'])): ?>
                                        <p><strong>Doc Type:</strong> <?= !empty($shop['business_papers']) ? htmlspecialchars($shop['business_papers']) : 'Not Specified'; ?></p>
                                        <a href="<?= htmlspecialchars($shop['business_doc_path']); ?>" target="_blank" class="btn btn-info btn-sm">View Document</a>
                                    <?php else: ?>
                                        <span class="text-danger">No Business Document Uploaded</span>
                                    <?php endif; ?>
                                </td>

                                    <td>
                                        <?php if ($shop['status'] === 'pending'): ?>
                                            <form method="POST" action="verify_shop.php" style="display:inline;">
                                            <input type="hidden" name="shop_id" value="<?= $shop['id']; ?>">
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
                    <p>No shops found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
