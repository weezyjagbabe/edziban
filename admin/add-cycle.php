<?php
$pageName = 'Add Cycle'; // Set the page name
require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
require_once('calendar/calendar/classes/tc_calendar.php');

?>

<link href="calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar/calendar/calendar.js"></script>
<style type="text/css">
    body, input, select { font-size: 13px; font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", "Verdana", sans-serif; }

    pre { font-size: 13px; font-family: "Consolas", "Menlo", "Monaco", "Lucida Console", "Liberation Mono", "DejaVu Sans Mono", "Bitstream Vera Sans Mono", "Courier New", monospace, serif; background-color: #FFFFCC; padding: 5px 5px 5px 5px; }
    pre .comment { color: #008000; }
    pre .builtin { color: #FF0000; }
</style>


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
        <p><a href="add-cycle"><button class="btn btn-inverse" type="button">Add New Cycle</button></a></p>

        <!-- Begin page divider -->
        <?php
        require_once 'includes/pageDivider.php'; // Include the page divider
        ?>
        <!-- End page divider -->

        <!-- Begin user contents -->
        <div class="row-fluid">

            <!-- Begin form wrapper -->
            <div class="span12">

                <!-- Begin form header -->
                <div class="containerHeadline">
                    <i class="icon-ok-sign"></i><h2>Create New Cycle</h2>
                    <div class="controlButton pull-right"><i class="icon-remove removeElement"></i></div>
                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                </div>
                <div class="floatingBox">
                    <div class="container-fluid">
                        <?php
                        if ( isset( $_POST['addCycle'] ) )
                        {
                            if ( isset($_GET['cycleID'])){
                                $cycleID             = $_GET['cycleID'];
                                $cycleStart 		=isset($_REQUEST["cycleStart"]) ? $_REQUEST["cycleStart"] : "";
                                $cycleEnd 			=isset($_REQUEST["cycleEnd"]) ? $_REQUEST["cycleEnd"] : "";



                                $updateCycle = updateCycle ( $cycleID, $cycleStart, $cycleEnd );
                                if ($updateCycle == TRUE) {
                                    ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Well done!</h4> Cycle updated successfully!!!
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Ooops!</h4> Something went wrong!!!
                                    </div>
                                    <?php
                                }
                            }else {


                                $cycleStart 			=isset($_REQUEST["cycleStart"]) ? $_REQUEST["cycleStart"] : "";
                                $cycleEnd 			    =isset($_REQUEST["cycleEnd"]) ? $_REQUEST["cycleEnd"] : "";


                                $createCycle = createCycle( $cycleStart, $cycleEnd );

                                if ($createCycle == TRUE) {
                                    ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Well done!</h4> You successfully created a new Cycle.
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Ooops!</h4> Something went wrong!!!
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>

                        <form class="form-horizontal contentForm" action=""  method="post" data-validate="parsley">

                            <div class="control-group">
                                <label class="control-label" for="cycleStart">Start Date *</label>
                                <div class="controls">

                                    <?php
                                    $cycleStart = $_GET['cycleStart'];
                                    $year = substr($cycleStart,0,4);
                                    $month = substr($cycleStart,5,2) ;
                                    $day = substr($cycleStart,8,2) ;

                                    $myCalendar = new tc_calendar("cycleStart", true, false);
                                    $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
                                    $myCalendar->setDate(date($day), date($month), date($year));
                                    $myCalendar->setPath("calendar/calendar/");
                                    $myCalendar->setYearInterval(1900, 2017);
                                    $myCalendar->dateAllow('1900-05-13', '2025-03-01');
                                    $myCalendar->setDateFormat('j F Y');
                                    $myCalendar->setAlignment('left', 'bottom');
                                    $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
                                    $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
                                    $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
                                    $myCalendar->writeScript();
                                    ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="cycleEnd">End Date *</label>
                                <div class="controls">

                                    <?php
                                    $cycleEnd = $_GET['cycleEnd'];
                                    $year = substr($cycleEnd,0,4);
                                    $month = substr($cycleEnd,5,2) ;
                                    $day = substr($cycleEnd,8,2) ;

                                    $myCalendar = new tc_calendar("cycleEnd", true, false);
                                    $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
                                    $myCalendar->setDate(date($day), date($month), date($year));
                                    $myCalendar->setPath("calendar/calendar/");
                                    $myCalendar->setYearInterval(1900, 2017);
                                    $myCalendar->dateAllow('1900-05-13', '2025-03-01');
                                    $myCalendar->setDateFormat('j F Y');
                                    $myCalendar->setAlignment('left', 'bottom');
                                    $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
                                    $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
                                    $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
                                    $myCalendar->writeScript();
                                    ?>
                                </div>
                            </div>


                            <div class="controls">
                                <div class="formFooter">
                                    <button type="submit" name="addCycle" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn">Reset</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- End form contents -->

            </div>

        </div>
    </div>
</div>

<?php
require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
?>

</body>


