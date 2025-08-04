<?php
session_start();
include('connection.inc.php');
include('functions.inc.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = get_safe_value($con, $_POST["name"]);
    $email = get_safe_value($con, $_POST["email"]);
    $mobile = get_safe_value($con, $_POST["mobile"]);
    $comment = get_safe_value($con, $_POST["message"]);
    $added_on=date('Y-m-d h:i:s');

    $sql = "INSERT INTO contact_us(name, email, mobile, comment, added_on) VALUES ('$name','$email','$mobile','$comment','$added_on')";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $mobile, $comment, $added_on);

    if ($stmt->execute()) {
        // Data successfully inserted
        echo "Data has been stored in the database.";
    } else {
        // An error occurred
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $con->close();
}
?>
