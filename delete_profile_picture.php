<?php
require('connection.inc.php');
require('functions.inc.php');

if (isset($_POST['reset'])) {
    $userId = get_safe_value($con,$_POST['user_id']);
    $deleteImageQuery = "UPDATE users SET pfp = NULL WHERE id = ?";
    $stmt = mysqli_prepare($con, $deleteImageQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "Profile picture removed for User ID: ".$userId;
}
?>