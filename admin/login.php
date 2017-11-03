<?php
	require_once 'models/configurations/configuration.php'; // Include the overall Configurations file
	require_once 'models/classes/Session.php'; // Include session class ?>

<!DOCTYPE html>
<html>
  <head>
    <title><?php echo PRODUCTNAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styl.css" rel="stylesheet">



      <!-- Favicons -->
      <link rel="icon" href="images/favicon.png" type="image/x-icon" />
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/img/favicon/favicon-144x144.html">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/img/favicon/favicon-72x72.html">
      <link rel="apple-touch-icon-precomposed" href="images/favicon.png">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
      <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    <![endif]-->
  </head>
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
                      <a class="navbar-brand" href="dashboard">
                         <h1 style="color: white"> <?php echo PRODUCTNAME; ?></h1>
                      </a>

	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="container-fluid">
    <form class="form-signin" action="process.php" method="post">

        <h2 class="form-signin-heading"><strong>EDZIBAN</strong> ADMIN-LOGIN</h2>

        <div class="input-prepend">
            <label for="username" class="label">Username: <?php echo $form -> error( "username" ); ?></label>
            <div class="clearfix"></div>

            <span class="add-on"><i class="icon-user"></i></span>
            <input type="text" name="username" placeholder="Username" value="<?php echo $form -> value( "username" ); ?>" required="">
        </div>

        <div class="input-prepend">
            <label for="username" class="label">Password: <?php echo $form -> error( "password" ); ?></label>
            <div class="clearfix"></div>

            <span class="add-on"><i class="icon-lock"></i></span>
            <input type="password" name="password" placeholder="Password" value="<?php echo $form -> value( "password" ); ?>" required="">
        </div>

        <input type="hidden" name="sublogin" value="1">
        <div class="input-prepend">
            <input type="submit" name="submit" value="LOG IN">
        </div>

    </form>

    <div class="signInRow">
        <div><h1>Sign in</h1></div>
        <div><a href="recover">Lost your password?</a></div>
    </div>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
  </body>
</html>