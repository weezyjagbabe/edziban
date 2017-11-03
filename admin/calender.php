<?php
	$pageName = 'Calender'; // Set the page name
	require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
?>
    
    <!-- Begin page body -->
    <body class="calender">
    	
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Begin content file includes -->
		<?php
//			require_once 'includes/pageTopMenu.php';?><!-- --><?php	//		// Include the top menu
			require_once 'includes/pageHiddenContent.php'; 		// Include the hidden conents
			require_once 'includes/pageMainMenu.php'; 			// Include the main menus
			require_once 'includes/pageHiddenMenu.php'; 		// Include the hidden menus
		?>
        <!-- End content file includes -->

        <!-- Begin page content-->
        <div class="content">

            <!-- Begin page headline -->
            <?php
            	require_once 'includes/pageHeadline.php'; // Include the page headlines, breadcramp and timer
            ?>
            <!-- End page headline -->

            <!-- Begin main content wrapper -->
            <div class="container-fluid">

                <!-- Begin user profile and recent activity -->
                <div class="row-fluid">

                    <!-- ==================== CALENDAR CONTAINER ==================== -->
                    <div class="span12">
                        <!-- ==================== CALENDAR HEADLINE ==================== -->

                        <!-- ==================== END OF CALENDAR HEADLINE ==================== -->

                        <!-- ==================== CALENDAR FLOATING BOX ==================== -->
                        <div class="floatingBox">
                            <div class="container-fluid">
                                <div class="col-md-12">
                                    <div class="content-box-large">
                                        <div class="content-box-header panel-heading">
                                            <div class="panel-title"><h2>Calendar</h2></div>


<!--                                            <div class="panel-options">-->
<!--                                                <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>-->
<!--                                                <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>-->
<!--                                            </div>-->
                                        </div>
                                        <div class="panel-body">
                                            <div id='calendar'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ==================== END OF CALENDAR FLOATING BOX ==================== -->
                    </div>
                    <!-- ==================== END OF CALENDAR CONTAINER ==================== -->

                </div>
                <!-- ==================== END OF CALENDAR ROW ==================== -->

            </div>
            <!-- End main content wrapper -->
            
        </div>
        <!-- End page content-->
        
        <!-- Begin page scripts -->
		<?php
			require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
		?>
		<!-- Begin page scripts -->
        
    </body>
    <!-- End page body -->
    
</html>