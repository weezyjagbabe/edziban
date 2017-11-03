<?php
session_start();
if(isset($_SESSION)) {
//    session_unset();
//    unset ($_SESSION['userCode']);
//    unset ($_SESSION['email']);
    session_destroy();
    unset($_SESSION['userCode']);
    unset($_SESSION['email']);
//    header("Location: index.php");
    header("Location: login.php");
//    echo "<script>location.href='login.php'</script>";
}else{

    header("Location: login.php");
//        echo "<script>location.href='login.php'</script>";

}