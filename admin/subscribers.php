<?php
$pageName = 'Subscribers'; // Set the page name
require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
?>
<script src="js/vendor/jquery.sparkline.min.js"></script>
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
<!--    <div class="container-fluid">-->

        <!-- Begin page divider -->
<!--        --><?php
//        require_once 'includes/pageDivider.php'; // Include the page divider
//        ?>
        <!-- End page divider -->


        <!-- Begin user profile and recent activity -->
<!--        <div class="row-fluid">-->
<!--        <div class="row-fluid">-->

            <!-- Begin table header -->
<!--            <div class="containerHeadline tableHeadline">-->
<!--                <i class="icon-gift"></i><h2>Subscribers</h2>-->
<!---->
<!--                <!-- Begin table search and controls -->
<!--                <form method="post" action="">-->
<!--                    <div class="input-append">-->
<!--                        <!--                        <input class="span8" type="text" placeholder="search in weekly menu..." id="memberSearch">-->
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
            <!--            <div class="floatingBox table">-->
            <div class="container-fluid">

                <!--                    <div class="col-md-10">-->
                <!--                        <div class="row">-->
                <div class="col-md-12">
                    <div class="content-box-large">
                        <p><a href="add-user"><button class="btn btn-inverse" type="button">Add Subscriber</button></a></p>
                        <div class="content-box-header panel-heading">
                            <div class="panel-title"><h2>Subscribers</h2></div>


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
                            <th data-placeholder="search in cycles...">Cycle</th>
                            <th data-placeholder="search in start date...">Start Date</th>
                            <th data-placeholder="search in end date...">End Date</th>
                            <th data-placeholder="search in names...">Name</th>
                            <th data-placeholder="search in amount...">Amount</th>
                            <th class="actions">Status</th>
                        </tr>
                        </thead>
                        <!-- End table headers -->

                        <!-- Begin table body -->
                        <tbody>
                        <!-- Populate table with data from the blogs table -->
                        <?php
                        $connection = mysqlconnect();
                        $stmt = $connection->prepare("SELECT subscribeID, cycleNo, startDate, endDate, cycleDuration,subscriberID, subscriberName, amountComputed, subStatus FROM subscribers ORDER BY subscribeID DESC" );
                        $stmt -> execute();
                        $stmt -> bind_result( $subscribeID, $cycleNo, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $subStatus);
                        while( $row = $stmt->fetch() ) :
                            ?>
                            <tr>
                                <td><span class="label cyan"><i class="icon-info-sign info"></i></span></td>
                                <td><a href="#" class="username"><?php echo $subscribeID; ?></a></td>
                                <td><a href="#" class="username">Cycle <?php echo $cycleNo; ?></a></td>
                                <td><a href="#" class="username"><?php echo $startDate; ?></a></td>
                                <td><a href="#" class="memberGroup"><?php echo $endDate; ?></a></td>
                                <td><a href="#" class="username"><?php echo $subscriberName; ?></a></td>
                                <td><a href="#" class="memberGroup"><?php if ( $subStatus === 1) echo 'GHC '. sprintf("%.2f",$amountComputed); else echo 'GHC '. sprintf("%.2f", 0); ?></a></td>


                                <td><span id="text<?php echo $subscribeID ?>" <?php if ( $subStatus === 1) { ?> class="label active" <?php ;}else{?> class="label inactive" disabled <?php ;} ?>>
                                                    <a class="changeStatus" data-cycleID="<?php echo $cycleNo?>" data-subscribe-id="<?php echo $subscribeID ?>" data-subscribe-status="<?php echo $subStatus ?>" href="subStatus.php?subscribeID=<?php echo $subscribeID ?>&subStatus=<?php echo $subStatus ?>&cycleID=<?php echo $cycleNo ?>"  id="memberStatus"  >
                                                        <?php
                                                        if ($subStatus === 1){
                                                            echo "Terminate";
                                                        }else{
                                                            echo "Subscribe";
                                                        }
                                                        ?>
                                                    </a>
                                                </span>
                                </td>

                            </tr>
                        <?php endwhile; $stmt->free_result(); ?>
                        </tbody>
                        <!-- End table body -->


                    </table>
                    <!-- End table -->

                    <!-- Begin table pagination -->
<!--                    <div id="pager" class="pager">-->
<!--                        <form>-->
<!--                            <span class="label white first"><i class="icon-double-angle-left"></i> first</span>-->
<!--                            <span class="label white prev"><i class="icon-angle-left"></i> prev</span>-->
<!--                            <span id="pageNumContainers"></span>-->
<!--                            <span class="pagedisplay"></span><!-- this can be any element, including an input -->
<!--                            <span class="label white next">next <i class="icon-angle-right"></i></span>-->
<!--                            <span class="label white last">last <i class="icon-double-angle-right"></i></span>-->
<!--                            <div class="perPageSelect">-->
<!--                                <select class="pagesize inp-mini">-->
<!--                                    <option selected="selected" value="10">10</option>-->
<!--                                    <option value="20">20</option>-->
<!--                                    <option value="30">30</option>-->
<!--                                    <option value="50">50</option>-->
<!--                                </select> records per page-->
<!--                            </div>-->
<!--                        </form>-->
<!--                    </div>-->
                    <!-- End table pagination -->
                    </div>
<!--                </div>-->
            </div>
            <!-- End main table container -->
        </div>
            </div>
<!--        </div>-->
<!--            </div>-->
<!--        </div>-->
        <!-- End user profile and recent activity -->

</div>
    <!-- End main content wrapper -->


<!-- End page content-->

<!-- Begin page scripts -->
<link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<?php
require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
?>

<!-- Begin page scripts -->
<!-- jquery script to change the status of blogs -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!--<script src="js/vendor/jquery-1.9.1.min.js"></script>-->

<script type="text/javascript">
    $( document ).ready(function() {
        $('.changeStatus').on('click', function (e) {
            e.preventDefault();
            var $this = $(this);
            var status = $this.html();
            var subscribeID = $this.attr('data-subscribe-id');
            var subStatus = $this.attr('data-subscribe-status');
            var cycleID = $this.attr('data-cycleID');
            var acolor = $('#text'+subscribeID);
            acolor.toggleClass('label inactive',true);
            //bcolor.toggleClass('label active');
            $.get('/paySwitchAdwane/admin/subStatus.php?subscribeID='+subscribeID+'&subStatus='+subStatus+'&cycleID='+cycleID).then(function (response) {
                var data = $.parseJSON(response);
                $this.attr('data-subscribe-status', data.status);
                $this.html((data.status)? 'Terminate' : 'Subscribe');
            });
        });
    });
</script>

</body>
<!-- End page body -->

</html>