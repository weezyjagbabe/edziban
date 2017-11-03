<?php
	$pageName = 'Dashboard'; // Set the page name
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
//			require_once 'includes/pageTopMenu.php'; 			// Include the top menu ?>
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
<!--		--><?php
//					require_once 'includes/pageDivider.php'; // Include the page divider
//				?>
		<!-- End page divider -->

		<!-- Begin user contents -->
		<div class="row-fluid">
			<div class="col-md-12 tabContainer">

				<!-- Begin tab menus -->
				<ul class="nav nav-tabs">

					<li class="active"><a href="#profile">Profile</a></li>
					<li><a href="#edit-profile">Edit Profile</a></li>
<!--					<li><a href="#task-center">Task Center</a></li>-->

					<li class="controlButton pull-right"><i class="icon-remove removeElement"></i></li>
					<li class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></li>
				</ul>

                <div class="row-fluid">
                    <div class="tabContent" id="profile">

                        <?php

                        $connection = mysqlconnect();
                        $stmt = $connection->prepare(" SELECT * FROM members WHERE memberID = 1 ");
                        $stmt -> execute();
                        $stmt -> bind_result( $memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $role, $employment_date, $marital_status, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $image);
                        while( $row = $stmt->fetch() ) :
                        ?>



                        <!-- Begin profile image -->
<!--                        <br><br>-->
                        <div class="floatingBox span12">
                            <div class="container-fluid">
                        <table border="0" width="100%" cellspacing="0" cellpadding="4">
                            <tr>
                                <td width="25%" valign="top" align="center">
                                    <div class="LightShadedBox">

                                        <img src="<?php echo $image; ?>" />

                                    </div>
                                </td>

                                <td width="75%" valign="top" align="left">
                                    <div class="LightShadedBox">
                                        <!-- End profile image -->

                                        <!-- Begin profile image -->


                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td align="center">
                                                    <b>GENERAL INFORMATION:</b>
                                                    <table cellspacing="4" cellpadding="0" border="0">
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("FirstName:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php echo $firstName; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("MiddleName:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $middleName; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("LastName:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $lastName; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Gender:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT genderName FROM gender WHERE genderID = ? ");
                                                                $stmt->bind_param("s", $gender);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $genderName);
                                                                $stmt->fetch(); echo $genderName;



                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Age:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php


                                                                $d1 = new DateTime();
                                                                $d2 = new DateTime($dob);

                                                                $diff = $d2->diff($d1);

                                                                echo $diff->y;



                                                                ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Membership Date:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $membership_date; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Classification:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT className FROM classification WHERE classID = ? ");
                                                                $stmt->bind_param("s", $classification);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $className);
                                                                $stmt->fetch(); echo $className;



                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Department:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT deptName FROM department WHERE deptID = ? ");
                                                                $stmt->bind_param("s", $department);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $deptName);
                                                                $stmt->fetch(); echo $deptName;



                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Marital Status:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT maritalName FROM maritalstatus WHERE maritalID = ? ");
                                                                $stmt->bind_param("s", $marital_status);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $maritalName);
                                                                $stmt->fetch(); echo $maritalName;



                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td align="center">
                                                    <b>GENERAL INFORMATION:</b>
                                                    <table cellspacing="4" cellpadding="0" border="0">
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Role:"); ?></td>
                                                            <td class="TinyTextColumn">
                                                                <?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT roleName FROM role WHERE roleID = ? ");
                                                                $stmt->bind_param("s", $role);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $roleName);
                                                                $stmt->fetch(); echo $roleName;



                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Employment Date:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $employment_date; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Home Phone:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $home_phone; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Work Phone:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $work_phone; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Mobile Phone:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $moblie_phone; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Personal Email:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $personal_email; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Work Email:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $work_email; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Residential Address:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $residential; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="TinyLabelColumn"><?php echo gettext("Postal Address:"); ?></td>
                                                            <td class="TinyTextColumn"><?php echo $postal; ?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                            </div>
                        </div>
                                    </div>

                                    <!-- End profile details -->
                                    <?php endwhile; ?>
                    </div>


                    <div class="tabContent" id="edit-profile" style="display: none">
                        <div class="floatingBox span12">
                            <div class="container-fluid">

                                <?php
                                if ( isset( $_POST['addProfile'] ) )
                                {

                                    $memberID             = $_POST['memberID'];
                                    $firstName 			= $_POST['firstName'];
                                    $middleName 			= $_POST['middleName'];
                                    $lastName 			= $_POST['lastName'];
                                    $gender 			= $_POST['gender'];
//                                    $membership_date 		= isset($_REQUEST["membershipDate"]) ? $_REQUEST["membershipDate"] : "";
                                    $membership_date        =isset($_REQUEST["membershipDate"]) ? $_REQUEST["membershipDate"] : "";
                                    $classification 			= $_POST['classification'];
                                    $department 			= $_POST['department'];
                                    $dob 			    = isset($_REQUEST["dob"]) ? $_REQUEST["dob"] : "";
                                    $marital_status 			= $_POST['maritalStatus'];
                                    $role 			= $_POST['role'];
                                    $employment_date 			= isset($_REQUEST["employmentDate"]) ? $_REQUEST["emoloymentDate"] : "";
                                    $home_phone 			= $_POST['homePhone'];
                                    $work_phone 			= $_POST['workPhone'];
                                    $moblie_phone 			= $_POST['mobilePhone'];
                                    $personal_email 			= $_POST['personalEmail'];
                                    $work_email 			= $_POST['workEmail'];
                                    $residential 		= $_POST['residential'];
                                    $postal 			= $_POST['postal'];
                                    print_r($_POST);

                                    if (!is_uploaded_file($_FILES['Image']['tmp_name'])){

                                        $updateMember = updateMemberA ( $memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $marital_status, $role, $employment_date, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal );
                                        if ($updateMember == TRUE) {
                                            ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Well done!</h4> Profile updated successfully!!!
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="alert alert-error">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Ooops!</h4> No Changes made!!!
                                            </div>
                                            <?php
                                        }
                                    }else {

                                        // Grab image details
                                        $Image = $_FILES['Image']['name']; // Grab image name
                                        $imageLocation = $_FILES['Image']['tmp_name']; // Grab image temporal location
                                        $imageDestination = "models/images/employees/"; // Image final destination
                                        //$imageDestination = "C:\wamp64\www\payswitchCurrent\models\images\blog".DIRECTORY_SEPARATOR;

                                        $updateMember = updateMember($memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $marital_status, $role, $employment_date, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $Image, $imageLocation, $imageDestination);
                                        if ($updateMember == TRUE) {
                                            ?>
                                            <div class="alert alert-success">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Well done!</h4> Profile updated successfully!!!
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="alert alert-error">
                                                <button type="button" class="close" data-dismiss="alert">&times;
                                                </button>
                                                <h4>Ooops!</h4> No changes made!!!
                                            </div>
                                            <?php
                                        }
                                    }
                                } ?>
                                <form class="form-horizontal contentForm" action="#edit-profile" enctype="multipart/form-data" method="post" data-validate="parsley" onsubmit="return validateForm()">
                        <?php

                        $connection = mysqlconnect();
                        $stmt = $connection->prepare(" SELECT * FROM members WHERE memberID = 1 ");
                        $stmt -> execute();
                        $stmt -> bind_result( $memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $role, $employment_date, $marital_status, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $image);
                        while( $row = $stmt->fetch() ) :
                        ?>




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
                                                        <input type="hidden" id="memberID" name="memberID" value="<?php echo $memberID; ?>">
                                                        <input type="text" value="<?php echo $firstName; ?>" required="" class="span10" id="firstName" name="firstName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="middleName">Middle Name *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $middleName; ?>" required="" class="span10" id="middleName" name="middleName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="lastName">Last Name *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $lastName; ?>" required="" class="span10" id="lastName" name="lastName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
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
                                                                <option id="opt<?php echo $gender ?>" value="<?php
                                                                $connection = mysqlconnect();
                                                                $stmt = $connection->prepare(" SELECT genderName FROM gender WHERE genderID = ? ");
                                                                $stmt->bind_param("s", $gender);
                                                                $stmt -> execute();
                                                                $stmt -> bind_result( $genderName);
                                                                $stmt->fetch(); echo $gender;



                                                                ?>"selected="selected"><?php echo $genderName; ?></option>

<!--                                                            <option id="" >Choose Category</option>-->
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
                                                            <input id="filename" type="text" class="input disabled span10" name="Image" value="<?php echo $image ?>"  style="width: 200px;" readonly>
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
                                                        $year = substr($dob,0,4);
                                                        $month = substr($dob,5,2) ;
                                                        $day = substr($dob,8,2) ;

                                                        $myCalendar = new tc_calendar("dob", true, false);
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
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="membershipDate">Membership Date *</label>


                                                </td>
                                                <td class="TinyTextColumn">
<!--                                                    <div class="row">-->
                                                        <div class="controls">
<!--                                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="--><?php //echo $membership_date ?><!--" name="membershipDate" id="membershipDate"></div>-->
                                                            <?php
                                                            $year = substr($membership_date,0,4);
                                                            $month = substr($membership_date,5,2) ;
                                                            $day = substr($membership_date,8,2) ;

                                                            $myCalendar = new tc_calendar("membershipDate", true, false);
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

                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="classification">Classification *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <select id="uniqueSelect" required="" name="classification" class="span10" data-required="true" data-trigger="change">
                                                            <option id="opt<?php echo $classification ?>" value="
                                                            <?php
                                                            $connection = mysqlconnect();
                                                            $stmt = $connection->prepare(" SELECT className FROM classification WHERE classID = ? ");
                                                            $stmt->bind_param("s", $classification);
                                                            $stmt -> execute();
                                                            $stmt -> bind_result( $className);
                                                            $stmt->fetch(); echo $classification;



                                                            ?>"selected="selected"><?php echo $className; ?></option>

                                                            <!--                                                            <option id="" >Choose Category</option>-->
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
                                                            <option id="opt<?php echo $department ?>" value="<?php
                                                            $connection = mysqlconnect();
                                                            $stmt = $connection->prepare(" SELECT deptName FROM department WHERE deptID = ? ");
                                                            $stmt->bind_param("s", $department);
                                                            $stmt -> execute();
                                                            $stmt -> bind_result( $deptName);
                                                            $stmt->fetch(); echo $department;



                                                            ?>"selected="selected"><?php echo $deptName; ?></option>

                                                            <!--                                                            <option id="" >Choose Category</option>-->
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
                                                            <option id="opt<?php echo $marital_status ?>" value="<?php
                                                            $connection = mysqlconnect();
                                                            $stmt = $connection->prepare(" SELECT maritalName FROM maritalstatus WHERE maritalID = ? ");
                                                            $stmt->bind_param("s", $marital_status);
                                                            $stmt -> execute();
                                                            $stmt -> bind_result( $maritalName);
                                                            $stmt->fetch(); echo $marital_status;



                                                            ?>"selected="selected"><?php echo $maritalName; ?></option>

                                                            <!--                                                            <option id="" >Choose Category</option>-->
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
                                                            <option id="opt<?php echo $role ?>" value="<?php
                                                            $connection = mysqlconnect();
                                                            $stmt = $connection->prepare(" SELECT roleName FROM role WHERE roleID = ? ");
                                                            $stmt->bind_param("s", $role);
                                                            $stmt -> execute();
                                                            $stmt -> bind_result( $roleName);
                                                            $stmt->fetch(); echo $role;



                                                            ?>"selected="selected"><?php echo $roleName; ?></option>

                                                            <!--                                                            <option id="" >Choose Category</option>-->
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
<!--                                                        <div class="bfh-datepicker" data-format="y-m-d" data-date="--><?php //echo $employment_date ?><!--" name="employmentDate" id="employmentDate"></div>-->
                                                        <?php
                                                        $year = substr($employment_date,0,4);
                                                        $month = substr($employment_date,5,2) ;
                                                        $day = substr($employment_date,8,2) ;

                                                        $myCalendar = new tc_calendar("employmentDate", true, false);
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
<!---->
<!--                                                    </div>-->


                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="homePhone">Home Phone *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $home_phone; ?>" required="" class="span10" id="homePhone" name="homePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>


                                    </div>
                                </td>

                                <td width="50%" valign="top" align="left">
                                    <div class="LightShadedBox">
                                        <table cellspacing="4" cellpadding="0" border="0">

                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="workPhone">Work Phone *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $work_phone; ?>" required="" class="span10" id="workPhone" name="workPhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="mobilePhone">Mobile Phone *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $moblie_phone; ?>" required="" class="span10" id="mobilePhone" name="mobilePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="personalEmail">Personal Email *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $personal_email; ?>" required="" class="span10" id="personalEmail" name="personalEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="workEmail">Work Email *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <input type="text" value="<?php echo $work_email; ?>" required="" class="span10" id="workEmail" name="workEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="residential">Residential Address *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <textarea required="" class="span10" id="residential" name="residential" style="height: 150px;" ><?php echo $residential; ?></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="control-group">
                                                <td class="TinyLabelColumn">

                                                    <label class="control-label" for="postal">Postal Address *</label>


                                                </td>
                                                <td class="TinyTextColumn">
                                                    <div class="controls">
                                                        <textarea style="height: 150px;" required="" class="span10" id="postal" name="postal"><?php echo $postal; ?></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php endwhile; ?>
                                    <div class="formFooter">
                                        <button type="submit" name="addProfile" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn">Reset</button>
                                    </div>
                                </form>
                                        </div>

                                    </div>

                    </div>
                    </div>
                </div>
            </div>
        </div>

	</div>

</div>

<?php
			require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
		?>
<!--<script src="https://code.jquery.com/jquery.js"></script>-->
<!--<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed
<!--    <script src="bootstrap/js/bootstrap.min.js"></script>
<!---->
<script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>
<!---->
<!--<script src="vendors/select/bootstrap-select.min.js"></script>-->
<!---->
<!--<script src="vendors/tags/js/bootstrap-tags.min.js"></script>-->
<!---->
<script src="vendors/mask/jquery.maskedinput.min.js"></script>
<!---->
<script src="vendors/moment/moment.min.js"></script>
<!---->
<script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

<link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
<script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>


<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<!---->
<script src="js/custom.js"></script>
<script src="js/forms.js"></script>
<script>
function validateForm() {
    $(function() {
        $.datepicker.setDefaults($.extend($.datepicker.regional[""]));
        $("#mydate").datepicker({
            onSelect: function(dateText, inst) {

            }
        });
}

</script>


</body>


