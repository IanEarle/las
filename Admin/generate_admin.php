<?php
$hashed_password = password_hash('adminpassword', PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashed_password;
?>
