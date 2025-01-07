<?php
session_start();
include '../Partials/db_conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Correct Path to Autoload
require __DIR__ . '/../Partials/vendor/autoload.php';

// ✅ Check if Admin is Logged In
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Verify Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['action'])) {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'];

    // ✅ Fetch User Data
    $stmt = $conn->prepare("SELECT email, name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "User not found!";
        header("Location: manage_users.php");
        exit;
    }

    $user = $result->fetch_assoc();
    $email = $user['email'];
    $name = $user['name'];
    $stmt->close();

    // ✅ Initialize PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lasmailtest1221@gmail.com'; // Replace with your Gmail
        $mail->Password = 'kzmw zvos idhc lfqn'; // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // ✅ SSL Verification Options
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom('your_email@gmail.com', 'Admin Panel');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);

        if ($action === 'approve') {
            // ✅ Approve User
            $stmt = $conn->prepare("UPDATE users SET status = 'approved' WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // ✅ Approval Email
            $mail->Subject = 'Account Approved';
            $mail->Body = "
                <p>Dear <strong>$name</strong>,</p>
                <p>Your account has been <strong>approved</strong> by the admin. You can now log in and access all features.</p>
                <p><a href='http://localhost/LaundryShop/login.php'>Login Now</a></p>
                <p>Thank you!</p>";

            $_SESSION['success_message'] = "User approved and email notification sent.";
        } elseif ($action === 'reject') {
            // ✅ Reject User
            $stmt = $conn->prepare("UPDATE users SET status = 'rejected' WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            // ✅ Rejection Email
            $mail->Subject = 'Account Rejected';
            $mail->Body = "
                <p>Dear <strong>$name</strong>,</p>
                <p>We regret to inform you that your account has been <strong>rejected</strong> by the admin.</p>
                <p>If you have any questions, feel free to contact support.</p>
                <p>Thank you!</p>
            ";

            $_SESSION['success_message'] = "User rejected and email notification sent.";
        } else {
            $_SESSION['error_message'] = "Invalid action!";
            header("Location: manage_users.php");
            exit;
        }

        // ✅ Send Email
        $mail->send();
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Action completed, but email could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    $_SESSION['error_message'] = "Invalid request!";
}

// ✅ Redirect Back to Manage Users
header("Location: manage_users.php");
exit;
?>
