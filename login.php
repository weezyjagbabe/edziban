<?php
session_start();
require_once 'classes/user.php';
$user_login = new USER();

if($user_login->is_logged_in())
{
    $user_login->redirect('index.php');
}

if(isset($_POST['btn-login']))
{
    $email = trim($_POST['email']);
    $password = ($_POST['password']);


    $data = $user_login->login($email,$password);
    if($data[0] != 0)
    {
        $_SESSION["email"] = $email;
        $_SESSION["userCode"] = $data[0];
        if($data[1] === 0){
            $user_login->redirect('passwordChange.php');
        }else {
            $user_login->redirect('index.php');
        }
    }else{
        $user_login->redirect('login.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo PRODUCTNAME; ?></title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body id="login">
<div class="container">

    <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
        {
            ?>
            <div class='alert alert-success'>
                <button class='close' data-dismiss='alert'>&times;</button>
                <strong>Wrong Details!</strong>
            </div>
            <?php
        }
        ?>
        <img src="images/crop.jpg"><br><br>

        <h2 class="form-signin-heading">Sign In.</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="email" required />
        <input type="password" class="input-block-level" placeholder="Password" name="password" required />
        <hr />

        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>

        <a href="fpass.php">Forgot Password ? </a>
    </form>

</div> <!-- /container -->
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="assets/scripts.js"></script>
</body>
</html>