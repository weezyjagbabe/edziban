<!DOCTYPE html>
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

	<!-- Begin page header -->
    <head>

		<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->    	
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?php echo $pageTitle; ?></title>
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

        <?php
        	if ( $pageName == 'Dashboard' ) 
        	{
				echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>";
			}
			elseif ( $pageName == 'Calender' ) 
			{
				?>
			        <link href='css/fullcalendar/fullcalendar.css' rel='stylesheet' />
			        <link href='css/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
			        <link rel="stylesheet" href="css/styles.css">
		        <?php
			}
        ?>
        <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="css/styles.css">
<!--        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">-->
<!--        <link href="css/buttons.css" rel="stylesheet">-->
<!--        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
<!--        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->


    </head>
    <!-- End page header -->