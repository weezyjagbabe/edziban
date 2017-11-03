<?php
session_start();
if(!isset($_SESSION['userCode']) && !isset($_SESSION['email']))
{
    echo "<script>location.href='login.php'</script>";
}
else
{
    $pageName	=	"Profile";
    $userCode = $_SESSION['userCode'];
    $email = $_SESSION['email'];
    require_once 'dbconfig.php';
    require_once 'functions/functions.php';

?>


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
                                <div class="panel-title "><h2>User Details</h2></div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
    <!--                        <div class="panel-body">-->
                                <div class="container-fluid">
                                <div class="row-fluid">
                                    <div class="tabContainer">

                                        <!-- Begin tab menus -->
                                        <ul class="nav nav-tabs">

                                            <li class="active"><a href="profile.php">Profile</a></li>
                                            <li><a href="edit-profile.php">Edit Profile</a></li>
                                            <!--					<li><a href="#task-center">Task Center</a></li>-->

                                            <li class="controlButton pull-right"><i class="icon-remove removeElement"></i></li>
                                            <li class="controlButton pull-right"><i class="icon-caret-down minimizeElement"></i></li>
                                        </ul>

                                        <div class="row-fluid">
                                            <div class="tabContent" id="profile">

                                                <?php

                                                $connection = connection();
                                                $stmt = $connection->prepare(" SELECT * FROM members WHERE memberID = ? ");
                                                $stmt->bind_param('i', $userCode);
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

                                                                        <img src="admin/<?php echo $image; ?>" />

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
                                                                                                $connection = connection();
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
                                                                                                $connection = connection();
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
                                                                                                $connection = connection();
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
                                                                                                $connection = connection();
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
                                                                                                $connection = connection();
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

require_once 'includes/pageScripts.php';

?>

</body>
    <?php require_once 'includes/pageFooter.php'; ?>
</html>
<?php  } ?>