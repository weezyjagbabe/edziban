<?php
$pageName = 'Add Menu'; // Set the page name
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
        <p><a href="add-weeklymenu"><button class="btn btn-inverse" type="button">Add New Menu</button></a></p>

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
                    <i class="icon-ok-sign"></i><h2>Create New Menu</h2>
                    <div class="controlButton pull-right"><i class="icon-remove removeElement"></i></div>
                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                </div>
                <div class="floatingBox">
                    <div class="container-fluid">
                        <?php
                        if ( isset( $_POST['addMenu'] ) )
                        {
                            if ( isset($_GET['menuID'])){
                                $menuID             = $_GET['menuID'];
                                $days 			= $_POST['days'];
                                $choice1 			= $_POST['choice1'];
                                $choice2 		= $_POST['choice2'];


                                $updateMenu = updateMenu ( $menuID, $days, $choice1, $choice2 );
                                if ($updateMenu == TRUE) {
                                    ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Well done!</h4> Menu updated successfully!!!
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


                                $days 			= $_POST['days'];
                                $choice1 			= $_POST['choice1'];
                                $choice2 		= $_POST['choice2'];

                                $createMenu = createMenu( $days, $choice1, $choice2 );

                                if ($createMenu == TRUE) {
                                    ?>
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;
                                        </button>
                                        <h4>Well done!</h4> You successfully created a new Menu.
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
                                <label class="control-label" for="days">Day *</label>
                                <div class="controls">
                                    <input type="text" value="<?php if(isset($_GET['menuID'])) echo $_GET['days']; ?>" required="" class="span10" id="days" name="days" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="choice1">Choice 1 *</label>
                                <div class="controls">
                                    <input type="text" value="<?php if(isset($_GET['menuID'])) echo $_GET['choice1']; ?>" required="" class="span10" id="choice1" name="choice1" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="choice2">Choice 2 *</label>
                                <div class="controls">
                                    <input type="text" value="<?php if(isset($_GET['menuID'])) echo $_GET['choice2']; ?>" required="" class="span10" id="choice2" name="choice2" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                </div>
                            </div>

                            <div class="controls">
                            <div class="formFooter">
                                <button type="submit" name="addMenu" class="btn btn-primary">Submit</button>
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


