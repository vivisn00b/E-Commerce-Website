<?php
require('connection.inc.php');
require('functions.inc.php');
$email = get_safe_value($con, $_POST['login_email']);
$password = get_safe_value($con, $_POST['login_password']);
$res=mysqli_query($con, "select * from users where email='$email' and password='$password'");
$check_user=mysqli_num_rows($res);
if($check_user>0){
    // echo "Logged In successfully!";
    $row=mysqli_fetch_assoc($res);
    $_SESSION['USER_LOGIN']='yes';
    $_SESSION['USER_ID']=$row['id'];
    $_SESSION['USER_NAME']=$row['name'];
    header("Location: index.php");
} else{
    echo "Please enter valid log in details!";
    echo '<script>setTimeout(function() {
                window.location.href = "login.php";
            }, 3000);</script>';
}
?>
