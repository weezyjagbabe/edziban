<?php
session_start();
if(!isset($_SESSION['userCode']) && !isset($_SESSION['email']))
{
    echo "<script>location.href='login.php'</script>";
}
else{
    $pageName	=	"Edit Profile";
    $userCode = $_SESSION['userCode'];
    $email = $_SESSION['email'];
    require_once 'dbconfig.php';
    require_once 'functions/functions.php';
?>

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="css/forms.css" rel="stylesheet">

    <?php require_once 'includes/pageHead.php';?>
    <body>
    <?php require_once 'includes/navbar.php'; ?>

    <div class="page-content">
        <div class="row">
            <?php require_once  'includes/pageLeftNav.php'?>
            <div class="col-md-10">
                <div class="row">


                    <div class="col-md-12 ">
                        <div class="content-box-large">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title"><h2>Edit Profile</h2></div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
<!--                            <div class="panel-body">-->
                            <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="tabContainer">

                                        <!-- Begin tab menus -->
                                        <ul class="nav nav-tabs">

                                            <li> <a href="profile.php">Profile</a></li>
                                            <li class="active"><a href="edit-profile.php">Edit Profile</a></li>
                                            <!--					<li><a href="#task-center">Task Center</a></li>-->

                                            <li class="controlButton pull-right"><i class="icon-remove removeElement"></i></li>
                                            <li class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></li>
                                        </ul>
                                        <div class="row-fluid">
                                        <div class="tabContent" id="edit-profile" >


                                                    <?php
                                                    if ( isset( $_POST['addProfile'] ) )
                                                    {

                                                        $memberID             = $_POST['memberID'];
                                                        $home_phone 			= $_POST['homePhone'];
                                                        $moblie_phone 			= $_POST['mobilePhone'];
                                                        $personal_email 			= $_POST['personalEmail'];
                                                        $residential 		= $_POST['residential'];
                                                        $postal 			= $_POST['postal'];

                                                        if (!is_uploaded_file($_FILES['Image']['tmp_name'])){

                                                            $updateMember = updateMemberA ( $memberID, $home_phone, $moblie_phone, $personal_email, $residential, $postal );
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
                                                                    <h4>Ooops!</h4> Something went wrong!!!
                                                                </div>
                                                                <?php
                                                            }
                                                        }else{
                                                        // Grab image details
                                                        $Image 			= $_FILES['Image']['name']; // Grab image name
                                                        $imageLocation 		= $_FILES['Image']['tmp_name']; // Grab image temporal location
                                                        $imageDestination 	= "admin/models/images/employees/"; // Image final destination

                                                        $updateMember = updateMember ( $memberID, $home_phone, $moblie_phone, $personal_email, $residential, $postal, $Image, $imageLocation, $imageDestination );
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
                                                                <h4>Ooops!</h4> Something went wrong!!!
                                                            </div>
                                                            <?php
                                                            }
                                                        }
                                                    } ?>
                                            <div class="floatingBox span12">
                                                <div class="container-fluid">
                                                    <form action="" enctype="multipart/form-data" method="post" data-validate="parsley">
                                                        <?php

                                                        $connection = connection();
                                                        $stmt = $connection->prepare(" SELECT * FROM members WHERE memberID = ? ");
                                                        $stmt->bind_param('i',$userCode);
                                                        $stmt -> execute();
                                                        $stmt -> bind_result( $memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $role, $employment_date, $marital_status, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $image);
                                                        while( $row = $stmt->fetch() ) :
                                                            ?>




                                                            <table border="0" width="100%" cellspacing="0" cellpadding="4">
                                                                <tr class="LightShadedBox">
                                                                    <td>
    <!--                                                                <td width="50%" valign="top" align="center">-->

    <!--                                                                    <div class="LightShadedBox">-->

    <!--                                                                        <table cellspacing="4" cellpadding="0" border="0">-->
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="firstName">First Name *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="hidden" id="memberID" name="memberID" value="<?php echo $memberID; ?>">
                                                                                            <input type="text" value="<?php echo $firstName; ?>" required="" class="form-control" id="firstName" name="firstName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" disabled/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="middleName">Middle Name *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $middleName; ?>" required="" class="form-control" id="middleName" name="middleName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" disabled/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="lastName">Last Name *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $lastName; ?>" required="" class="form-control" id="lastName" name="lastName" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" disabled/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="gender">Gender *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <select id="uniqueSelect" required="" name="gender" class="form-control" data-required="true" data-trigger="change" disabled>
                                                                                                <option id="opt<?php echo $gender ?>" value="<?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT genderName FROM gender WHERE genderID = ? ");
                                                                                                $stmt->bind_param("s", $gender);
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $genderName);
                                                                                                $stmt->fetch(); echo $gender;



                                                                                                ?>"selected="selected"><?php echo $genderName; ?></option>

                                                                                                <!--                                                            <option id="" >Choose Category</option>-->
                                                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT genderID, genderName FROM gender ");
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $genderID, $genderName );
                                                                                                while($row = $stmt->fetch()) :
                                                                                                    ?>



                                                                                                    <option id="opt<?php echo $genderID; ?>" value="<?php echo $genderID; ?>"><?php echo $genderName; ?></option>
                                                                                                <?php  endwhile;  ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="image">Image *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
    <!--                                                                                    <div class="controls">-->
    <!--                                                                                        <input type="file" id="inputFile" name="Image"  style="display: none">-->
    <!--                                                                                        <div class="dummyfile">-->
    <!--                                                                                            <input id="filename" type="text" class="input disabled span10" name="Image" value="--><?php //echo $image ?><!--"   readonly>-->
    <!--                                                                                            <a id="fileselectbutton" class="btn btn-default">Browse</a>-->
    <!--                                                                                        </div>-->
    <!--                                                                                    </div>-->
                                                                                        <div class="col-md-12">
                                                                                            <input type="file" class="btn btn-default" id="inputFile" name="Image" size="20">
<!--                                                                                                <img src="--><?php //echo $image; ?><!--" alt="" />-->
<!--                                                                                            --><?php //$_SESSION['image'] = $image; ?>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="dob">Date of Birth *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <!--                                                    <div class="row">-->
                                                                                        <div class="controls">
                                                                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="<?php echo $dob ?>" name="dob" id="dob" disabled></div>
    <!--                                                                                        --><?php
    //                                                                                        $myCalendar = new tc_calendar("dob", true, false);
    //                                                                                        $myCalendar->setIcon("admin/calendar/calendar/images/iconCalendar.gif");
    //                                                                                        $myCalendar->setDate(date('d'), date('m'), date('Y'));
    //                                                                                        $myCalendar->setPath("admin/calendar/calendar/");
    //                                                                                        $myCalendar->setYearInterval(1900, 2017);
    //                                                                                        $myCalendar->dateAllow('1900-05-13', '2025-03-01');
    //                                                                                        $myCalendar->setDateFormat('j F Y');
    //                                                                                        $myCalendar->setAlignment('left', 'bottom');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
    //                                                                                        $myCalendar->writeScript();
    //                                                                                        ?>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="membershipDate">Membership Date *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <!--                                                    <div class="row">-->
                                                                                        <div class="controls">
                                                                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="<?php echo $membership_date ?>" name="membershipDate" id="membershipDate" disabled></div>
    <!--                                                                                        --><?php
    //                                                                                        $myCalendar = new tc_calendar("membershipDate", true, false);
    //                                                                                        $myCalendar->setIcon("admin/calendar/calendar/images/iconCalendar.gif");
    //                                                                                        $myCalendar->setDate(date('d'), date('m'), date('Y'));
    //                                                                                        $myCalendar->setPath("admin/calendar/calendar/");
    //                                                                                        $myCalendar->setYearInterval(1900, 2017);
    //                                                                                        $myCalendar->dateAllow('1900-05-13', '2025-03-01');
    //                                                                                        $myCalendar->setDateFormat('j F Y');
    //                                                                                        $myCalendar->setAlignment('left', 'bottom');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
    //                                                                                        $myCalendar->writeScript();
    //                                                                                        ?>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="classification">Classification *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <select id="uniqueSelect" required="" name="classification" class="form-control" data-required="true" data-trigger="change" disabled>
                                                                                                <option id="opt<?php echo $classification ?>" value="
                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT className FROM classification WHERE classID = ? ");
                                                                                                $stmt->bind_param("s", $classification);
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $className);
                                                                                                $stmt->fetch(); echo $classification;



                                                                                                ?>"selected="selected"><?php echo $className; ?></option>

                                                                                                <!--                                                            <option id="" >Choose Category</option>-->
                                                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT classID, className FROM classification ");
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $classID, $className );
                                                                                                while($row = $stmt->fetch()) :
                                                                                                    ?>



                                                                                                    <option id="opt<?php echo $classID; ?>" value="<?php echo $classID; ?>"><?php echo $className; ?></option>
                                                                                                <?php  endwhile;  ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="department">Department *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <select id="uniqueSelect" required="" name="department" class="form-control" data-required="true" data-trigger="change" disabled>
                                                                                                <option id="opt<?php echo $department ?>" value="<?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT deptName FROM department WHERE deptID = ? ");
                                                                                                $stmt->bind_param("s", $department);
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $deptName);
                                                                                                $stmt->fetch(); echo $department;



                                                                                                ?>"selected="selected"><?php echo $deptName; ?></option>

                                                                                                <!--                                                            <option id="" >Choose Category</option>-->
                                                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT deptID, deptName FROM department ");
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $deptID, $deptName );
                                                                                                while($row = $stmt->fetch()) :
                                                                                                    ?>



                                                                                                    <option id="opt<?php echo $deptID; ?>" value="<?php echo $deptID; ?>"><?php echo $deptName; ?></option>
                                                                                                <?php  endwhile;  ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="maritalStatus">Marital Status *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <select id="uniqueSelect" required="" name="maritalStatus" class="form-control" data-required="true" data-trigger="change" disabled>
                                                                                                <option id="opt<?php echo $marital_status ?>" value="<?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT maritalName FROM maritalstatus WHERE maritalID = ? ");
                                                                                                $stmt->bind_param("s", $marital_status);
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $maritalName);
                                                                                                $stmt->fetch(); echo $marital_status;



                                                                                                ?>"selected="selected"><?php echo $maritalName; ?></option>

                                                                                                <!--                                                            <option id="" >Choose Category</option>-->
                                                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT maritalID, maritalName FROM maritalstatus ");
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $maritalID, $maritalName );
                                                                                                while($row = $stmt->fetch()) :
                                                                                                    ?>



                                                                                                    <option id="opt<?php echo $maritalID; ?>" value="<?php echo $maritalID; ?>"><?php echo $maritalName; ?></option>
                                                                                                <?php  endwhile;  ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="role">Role *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <select id="uniqueSelect" required="" name="role" class="form-control" data-required="true" data-trigger="change" disabled>
                                                                                                <option id="opt<?php echo $role ?>" value="<?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT roleName FROM role WHERE roleID = ? ");
                                                                                                $stmt->bind_param("s", $role);
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $roleName);
                                                                                                $stmt->fetch(); echo $role;



                                                                                                ?>"selected="selected"><?php echo $roleName; ?></option>

                                                                                                <!--                                                            <option id="" >Choose Category</option>-->
                                                                                                <?php
                                                                                                $connection = connection();
                                                                                                $stmt = $connection->prepare(" SELECT roleID, roleName FROM role ");
                                                                                                $stmt -> execute();
                                                                                                $stmt -> bind_result( $roleID, $roleName );
                                                                                                while($row = $stmt->fetch()) :
                                                                                                    ?>



                                                                                                    <option id="opt<?php echo $roleID; ?>" value="<?php echo $roleID; ?>"><?php echo $roleName; ?></option>
                                                                                                <?php  endwhile;  ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                    </td>          </div>
                                                                </tr>
                                                                <tr class="LightShadedBox">
                                                                    <td>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="employmentDate">Employment Date *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <!--                                                    <div class="row">-->
                                                                                        <div class="controls">
                                                                                            <div class="bfh-datepicker" data-format="y-m-d" data-date="<?php echo $employment_date ?>" name="employmentDate" id="employmentDate" disabled></div>
    <!--                                                                                        --><?php
    //                                                                                        $myCalendar = new tc_calendar("employmentDate", true, false);
    //                                                                                        $myCalendar->setIcon("admin/calendar/calendar/images/iconCalendar.gif");
    //                                                                                        $myCalendar->setDate(date('d'), date('m'), date('Y'));
    //                                                                                        $myCalendar->setPath("admin/calendar/calendar/");
    //                                                                                        $myCalendar->setYearInterval(1900, 2017);
    //                                                                                        $myCalendar->dateAllow('1900-05-13', '2025-03-01');
    //                                                                                        $myCalendar->setDateFormat('j F Y');
    //                                                                                        $myCalendar->setAlignment('left', 'bottom');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-04-10", "2011-04-14"), 0, 'month');
    //                                                                                        $myCalendar->setSpecificDate(array("2011-06-01"), 0, '');
    //                                                                                        $myCalendar->writeScript();
    //                                                                                        ?>

                                                                                        </div>


                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="homePhone">Home Phone *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $home_phone; ?>" required="" class="form-control" id="homePhone" name="homePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="workPhone">Work Phone *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $work_phone; ?>" required="" class="form-control" id="workPhone" name="workPhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" disabled/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="mobilePhone">Mobile Phone *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $moblie_phone; ?>" required="" class="form-control" id="mobilePhone" name="mobilePhone" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="personalEmail">Personal Email *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $personal_email; ?>" required="" class="form-control" id="personalEmail" name="personalEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="workEmail">Work Email *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <input type="text" value="<?php echo $work_email; ?>" required="" class="form-control" id="workEmail" name="workEmail" data-validation-minlength="0" data-trigger="change" data-required="true" data-minlength="4" disabled/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="residential">Residential Address *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <textarea required="" class="form-control" id="residential" name="residential" style="height: 150px;" ><?php echo $residential; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="TinyLabelColumn">

                                                                                        <label class="control-label" for="postal">Postal Address *</label>


                                                                                    </div>
                                                                                    <div class="TinyTextColumn">
                                                                                        <div class="controls">
                                                                                            <textarea style="height: 150px;" required="" class="form-control" id="postal" name="postal" ><?php echo $postal; ?></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>


                                                                    </td>
                                                                    </tr>
                                                            </table>
    <!--                                                        </table>-->
                                                        <?php endwhile; ?>
                                                        <div class="formFooter">
                                                            <button type="submit" name="addProfile" class="btn btn-primary">Submit</button>
    <!--                                                        <button type="reset" class="btn">Reset</button>-->
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
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once 'includes/pageFooter.php';
    require_once 'includes/pageScripts.php';

    ?>
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<!--    <script src="bootstrap/js/bootstrap.min.js"></script>-->

    <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>

    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

    // bootstrap-datetimepicker
    <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
    <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>


    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>

    </body>
</html>
<?php } ?>