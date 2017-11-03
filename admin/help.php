<?php
	$pageName = 'Help'; // Set the page name
	require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
?>
    
    <!-- Begin page body -->
    <body class="widgets">
    	
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <!-- Begin content file includes -->
		<?php
//			require_once 'includes/pageTopMenu.php'; ?><!----><?php	//		// Include the top menu
			require_once 'includes/pageHiddenContent.php'; 		// Include the hidden conents
			require_once 'includes/pageMainMenu.php'; 			// Include the main menus
			require_once 'includes/pageHiddenMenu.php'; 		// Include the hidden menus
		?>
        <!-- End content file includes -->

        <!-- Begin page content-->
        <div class="content">

            <!-- Begin page headline -->
            <?php
            	require_once 'includes/pageHeadline.php'; 	// Include the page headlines, breadcramp and timer
            ?>
            <!-- End page headline -->
            
            <!-- Begin main content wrapper -->
            <div class="container-fluid">
            	
                <!-- ==================== TAB ROW ==================== -->
                <div class="row-fluid">

                </div>

                
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