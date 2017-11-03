<?php
$pageName = 'Food Menu'; // Set the page name
require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
?>

<!-- Begin page body -->

<body class="widgets">

<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<!-- Begin content file includes -->
<?php
//require_once 'includes/pageTopMenu.php'; 			// Include the top menu ?>

<?php
require_once 'includes/pageHiddenContent.php'; 		// Include the hidden cotents
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

        <!-- Begin page divider -->
<!--        --><?php
//        require_once 'includes/pageDivider.php'; // Include the page divider
//        ?>
        <!-- End page divider -->


        <!-- Begin user profile and recent activity -->
        <div class="row-fluid">

            <!-- Begin table header -->
<!--            <div class="containerHeadline tableHeadline">-->
<!--                <i class="icon-gift"></i><h2>Weekly Menu</h2>-->
<!---->
<!--                <!-- Begin table search and controls -->
<!--                <form method="post" action="">-->
<!--                    <div class="input-append">-->
<!---->
<!--                        <span class="add-on add-on-first "><i class="icon-search"></i></span>-->
<!--                        <span class="add-on add-on-middle  tableSettings"><i class="icon-cog"></i></span>-->
<!--                        <span class="add-on add-on-middle  minimizeTable"><i class="icon-arrow-down"></i></span>-->
<!--                        <span class="add-on add-on-last  removeTable"><i class="icon-remove"></i></span>-->
<!--                    </div>-->
<!--                </form>-->
<!--                <!-- End table search and controls-->
<!---->
<!--            </div>-->
            <!-- End table header -->

            <!-- Begin main table container -->

            <div class="container-fluid">

                <div class="col-md-12">
                    <div class="content-box-large">
                        <p><a href="add-weeklymenu"><button class="btn btn-inverse" type="button">Add New Menu</button></a></p>
                        <div class="content-box-header panel-heading">
                            <div class="panel-title"><h2>Weekly Menu</h2></div>


                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <!-- Begin table -->
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">

                        <!-- Begin table headers -->
                        <thead>
                        <tr>
                            <th class="info">Details</th>
                            <th data-placeholder="search in created by...">No.</th>
                            <th data-placeholder="search in created by...">Day</th>
                            <th data-placeholder="search in date...">Choice 1</th>
                            <th data-placeholder="search in title...">Choice 2</th>
                            <th data-placeholder="search in statuses...">Status</th>
                            <th class="actions">Actions</th>
                        </tr>
                        </thead>
                        <!-- End table headers -->

                        <!-- Begin table body -->
                        <tbody>
                        <!-- Populate table with data from the blogs table -->
                        <?php
                        $connection = mysqlconnect();
                        $stmt = $connection->prepare(" SELECT menuID, days, choice1, choice2, menuStatus FROM weeklymenu" );
                        $stmt -> execute();
                        $stmt -> bind_result( $menuID, $days, $choice1, $choice2, $menuStatus);
                        while( $row = $stmt->fetch() ) :
                            ?>
                            <tr class="gradeA">
                                <td><span class="label cyan"><i class="icon-info-sign info"></i></span></td>
                                <td><a href="#" class="username"><?php echo $menuID; ?></a></td>
                                <td><a href="#" class="username"><?php echo $days; ?></a></td>
                                <td><a href="#" class="username"><?php echo $choice1; ?></a></td>
                                <td><a href="#" class="memberGroup"><?php echo $choice2; ?></a></td>


                                <td class="center"><span id="text<?php echo $menuID ?>" <?php if ( $menuStatus === 1) { ?> class="label active" <?php ;}else{?> class="label inactive" <?php ;} ?>>
                                                    <a class="changeStatus" data-menu-id="<?php echo $menuID ?>" data-menu-status="<?php echo $menuStatus ?>" href="menuStatus.php?menuID=<?php echo $menuID ?>&menuStatus=<?php echo $menuStatus ?>"  id="memberStatus"  >
                                                        <?php
                                                        if ($menuStatus === 1){
                                                            echo "Deactivate";
                                                        }else{
                                                            echo "Activate";
                                                        }
                                                        ?>
                                                    </a>
                                                </span>
                                </td>
                                <td class="center">
	                                        	<span class="label green">
                                                    <a href="add-weeklymenu.php?menuID=<?php echo $menuID ?>&days=<?php echo $days ?>&choice1=<?php echo $choice1 ?>&choice2=<?php echo $choice2 ?>" class="glyphicon glyphicon-pencil" >
                                                    </a>
                                                </span>
                                    <span class="label red">
                                                    <i class="glyphicon glyphicon-remove" id ="deleteMenu">
                                                    </i>
                                                </span>
                                </td>
                            </tr>
                        <?php endwhile; $stmt->free_result(); ?>
                        </tbody>
                        <!-- End table body -->


                    </table>
                    <!-- End table -->

                    <!-- Begin table pagination -->

                    <!-- End table pagination -->

                </div>
            </div>
            <!-- End main table container -->
        </div>
        <!-- End user profile and recent activity -->

    </div>
    <!-- End main content wrapper -->

</div>
<!-- End page content-->
        <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<!-- Begin page scripts -->
<?php
require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
?>

<script type="text/javascript">
    $( document ).ready(function() {
        $('.changeStatus').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var status = $this.html();
            var menuID = $this.attr('data-menu-id');
            var menuStatus = $this.attr('data-menu-status');
            var acolor = $('#text'+menuID);
            acolor.toggleClass('label inactive label active');
            //bcolor.toggleClass('label active');
            $.get('/paySwitchEdziban/admin/menuStatus.php?menuID='+menuID+'&menuStatus='+menuStatus).then(function (response) {
                var data = $.parseJSON(response);
                $this.attr('data-menu-status', data.status);
                $this.html((data.status)? 'Deactivate' : 'Activate');
            });
        });
    });
</script>

</body>


</html>