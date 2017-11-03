<?php
require_once 'functions/functions.php';
require_once 'dbconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
</head>
<body id="login">
<div class="container">
    <form class="form-signin" method="post">
        <?php
            if(isset($_POST['forgotSubmit'])){

                $email = $_POST['email'];

                $passwordReset = passwordReset($email);
                if ($passwordReset == TRUE)
                { ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;
                        </button>
                        <h4>Success!!!</h4> A default password has been emailed to you!!!
                        <?php echo "<script>setTimeout(function(){location.href='login.php';},3000)</script>"; ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;
                        </button>
                        <h4>ERROR !!!</h4> Invalid email address entered!!!
                    </div>
                    <?php
                }
            }
        ?>
        <img src="images/payswitch-crop.jpg"><br><br>
        <h2 class="form-signin-heading">Forgot Password.</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="email" required />
            <div class="send-button">
                <button class="btn btn-large btn-primary" name="forgotSubmit">Reset Password</button>
            </div>
    </form>
</div>
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="assets/scripts.js"></script>
</body>
</html>
