<?php
$pageName = 'Add Subscriber'; // Set the page name
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
        <p><a href="add-subscriber"><button class="btn btn-inverse" type="button">Add New User</button></a></p>

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
                    <i class="icon-ok-sign"></i><h2>Add Subscriber</h2>
                    <div class="controlButton pull-right"><i class="icon-remove removeElement"></i></div>
                    <div class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></div>
                </div>
                <div class="floatingBox">
                    <div class="container-fluid">
                        <?php
                        if ( isset( $_POST['addMember'] ) )
                        {

                            //$memberID             = $_POST['memberID'];
                            $firstName 			= $_POST['firstName'];
                            $middleName 			= $_POST['middleName'];
                            $lastName 			= $_POST['lastName'];
                            $gender 			= $_POST['gender'];
                            $membership_date 		= isset($_REQUEST["membershipDate"]) ? $_REQUEST["membershipDate"] : "";;
                            $classification 			= $_POST['classification'];
                            $department 			= $_POST['department'];
                            $dob 			    = isset($_REQUEST["dob"]) ? $_REQUEST["dob"] : "";
                            $marital_status 			= $_POST['maritalStatus'];
                            $role 			= $_POST['role'];
                            $employment_date 			= isset($_REQUEST["employmentDate"]) ? $_REQUEST["employmentDate"] : "";
                            $home_phone 			= $_POST['homePhone'];
                            $work_phone 			= $_POST['workPhone'];
                            $moblie_phone 			= $_POST['mobilePhone'];
                            $personal_email 			= $_POST['personalEmail'];
                            $work_email 			= $_POST['workEmail'];
                            $residential 		= $_POST['residential'];
                            $postal 			= $_POST['postal'];
                            $defaultPass        =$_POST['defaultPass'];

                            // Grab image details
                            $Image 			= $_FILES['Image']['name']; // Grab image name
                            $imageLocation 		= $_FILES['Image']['tmp_name']; // Grab image temporal location
                            $imageDestination 	= "models/images/employees/"; // Image final destination


                            $createMember = createMember ( $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $marital_status, $role, $employment_date, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $Image, $imageLocation, $imageDestination, $defaultPass );
                            if ($createMember == TRUE) {
                                ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">&times;
                                    </button>
                                    <h4>Well done!</h4> Subscriber created successfully!!!
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
                        } ?>
                        <form class="form-horizontal contentForm" action="" enctype="multipart/form-data" method="post" data-validate="parsley">

                                <table border="0" width="100%" cellspacing="0" cellpadding="4">
                                    <tr>
                                        <td width="50%" valign="top" align="center">

                                            <div class="LightShadedBox">

                                                <table cellspacing="4" cellpadding="0" border="0">
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="firstName">First Name *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
<!--                                                                <input type="hidden" id="memberID" name="memberID" value="--><?php //echo $memberID; ?><!--">-->
                                                                <input type="text" required="" class="span10" id="firstName" name="firstName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="middleName">Middle Name *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="middleName" name="middleName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="lastName">Last Name *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="lastName" name="lastName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="gender">Gender *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <select id="uniqueSelect" required="" name="gender" class="span10" data-required="true" data-trigger="change">

                                                                    <?php
                                                                    $connection = mysqlconnect();
                                                                    $stmt = $connection->prepare(" SELECT genderID, genderName FROM gender ");
                                                                    $stmt -> execute();
                                                                    $stmt -> bind_result( $genderID, $genderName );
                                                                    while($row = $stmt->fetch()) :
                                                                        ?>



                                                                        <option id="opt<?php echo $genderID; ?>" value="<?php echo $genderID; ?>"><?php echo $genderName; ?></option>
                                                                    <?php  endwhile;  ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="image">Image *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="file" id="inputFile" name="Image"  style="display: none">
                                                                <div class="dummyfile">
                                                                    <input id="filename" type="text" class="input disabled span10" name="Image"  style="width: 200px;" readonly>
                                                                    <a id="fileselectbutton" class="btn">Browse</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="dob">Date of Birth *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <!--                                                    <div class="row">-->
                                                            <div class="controls">

                                                                <?php
                                                                $myCalendar = new tc_calendar("dob", true, false);
                                                                $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
                                                                $myCalendar->setDate(date('d'), date('m'), date('Y'));
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

                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="membershipDate">Membership Date *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <!--                                                    <div class="row">-->
                                                            <div class="controls">

                                                                <?php
                                                                $myCalendar = new tc_calendar("membershipDate", true, false);
                                                                $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
                                                                $myCalendar->setDate(date('d'), date('m'), date('Y'));
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

                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="classification">Classification *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <select id="uniqueSelect" required="" name="classification" class="span10" data-required="true" data-trigger="change">

                                                                    <?php
                                                                    $connection = mysqlconnect();
                                                                    $stmt = $connection->prepare(" SELECT classID, className FROM classification ");
                                                                    $stmt -> execute();
                                                                    $stmt -> bind_result( $classID, $className );
                                                                    while($row = $stmt->fetch()) :
                                                                        ?>



                                                                        <option id="opt<?php echo $classID; ?>" value="<?php echo $classID; ?>"><?php echo $className; ?></option>
                                                                    <?php  endwhile;  ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="department">Department *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <select id="uniqueSelect" required="" name="department" class="span10" data-required="true" data-trigger="change">

                                                                    <?php
                                                                    $connection = mysqlconnect();
                                                                    $stmt = $connection->prepare(" SELECT deptID, deptName FROM department ");
                                                                    $stmt -> execute();
                                                                    $stmt -> bind_result( $deptID, $deptName );
                                                                    while($row = $stmt->fetch()) :
                                                                        ?>



                                                                        <option id="opt<?php echo $deptID; ?>" value="<?php echo $deptID; ?>"><?php echo $deptName; ?></option>
                                                                    <?php  endwhile;  ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="maritalStatus">Marital Status *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <select id="uniqueSelect" required="" name="maritalStatus" class="span10" data-required="true" data-trigger="change">

                                                                    <?php
                                                                    $connection = mysqlconnect();
                                                                    $stmt = $connection->prepare(" SELECT maritalID, maritalName FROM maritalstatus ");
                                                                    $stmt -> execute();
                                                                    $stmt -> bind_result( $maritalID, $maritalName );
                                                                    while($row = $stmt->fetch()) :
                                                                        ?>



                                                                        <option id="opt<?php echo $maritalID; ?>" value="<?php echo $maritalID; ?>"><?php echo $maritalName; ?></option>
                                                                    <?php  endwhile;  ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="role">Role *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <select id="uniqueSelect" required="" name="role" class="span10" data-required="true" data-trigger="change">

                                                                    <?php
                                                                    $connection = mysqlconnect();
                                                                    $stmt = $connection->prepare(" SELECT roleID, roleName FROM role ");
                                                                    $stmt -> execute();
                                                                    $stmt -> bind_result( $roleID, $roleName );
                                                                    while($row = $stmt->fetch()) :
                                                                        ?>



                                                                        <option id="opt<?php echo $roleID; ?>" value="<?php echo $roleID; ?>"><?php echo $roleName; ?></option>
                                                                    <?php  endwhile;  ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="employmentDate">Employment Date *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <!--                                                    <div class="row">-->
                                                            <div class="controls">

                                                                <?php
                                                                $myCalendar = new tc_calendar("employmentDate", true, false);
                                                                $myCalendar->setIcon("calendar/calendar/images/iconCalendar.gif");
                                                                $myCalendar->setDate(date('d'), date('m'), date('Y'));
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


                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="homePhone">Home Phone *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="homePhone" name="homePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="workPhone">Work Phone *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="workPhone" name="workPhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="mobilePhone">Mobile Phone *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="mobilePhone" name="mobilePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>


                                            </div>
                                        </td>

                                        <td width="100%" valign="top" align="left">
                                            <div class="LightShadedBox">
                                                <table cellspacing="4" cellpadding="0" border="0">

                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="personalEmail">Personal Email *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="personalEmail" name="personalEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="workEmail">Work Email *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="workEmail" name="workEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="residential">Residential Address *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <textarea class="span10" name="residential" style="height: 200px;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="postal">Postal Address *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <textarea class="span10" name="postal" style="height: 210px;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="control-group">
                                                        <td class="TinyLabelColumn">

                                                            <label class="control-label" for="defaultPass">Default Password *</label>


                                                        </td>
                                                        <td class="TinyTextColumn">
                                                            <div class="controls">
                                                                <input type="text" required="" class="span10" id="defaultPass" name="defaultPass" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            <div class="formFooter">
                                <button type="submit" name="addMember" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn">Reset</button>
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


