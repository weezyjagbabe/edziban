<?php
$pageName = 'User-Management'; // Set the page name
require_once 'includes/pageIncludeFiles.php'; // Include the neccessary files
require_once('calendar/calendar/classes/tc_calendar.php');

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


        <!-- Begin page divider -->
<!--        --><?php
//        require_once 'includes/pageDivider.php'; // Include the page divider
//        ?>
        <!-- End page divider -->

        <!-- Begin user contents -->

                        <?php

                        $connection = mysqlconnect();
                        $stmt = $connection->prepare(" SELECT * FROM members ");
                        $stmt -> execute();
                        $stmt -> bind_result( $memberID, $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $role, $employment_date, $marital_status, $home_phone, $work_phone, $mobile_phone, $personal_email, $work_email, $residential, $postal, $image);
                        while( $row = $stmt->fetch() ) :
                            echo "<div class=\"container-fluid\">";
                            echo "<div class='row-fluid'>";

                                echo "<div class='floatingBox span12'>";
                                    echo "<div class='container-fluid'>";

                        echo "<table border='0' width='100%' cellspacing='0' cellpadding='4'>";

                                    echo "<tr>";
                                        echo "<td width='25%' valign='top' align='center'>";
                                            echo "<div class='LightShadedBox'>";

                                                echo "<img src='$image' />";

                                            echo "</div>";
                                        echo "</td>";

                                        echo "<td width='75%' valign='top' align='left'>";
                                            echo "<div class='LightShadedBox'>";



                                                echo "<table cellspacing='0' cellpadding='0' border='0' width='100%'>";
                                                    echo "<tr>";
                                                        echo "<td align='center'>";
                                                            echo "<b>GENERAL INFORMATION:</b>";
                                                            echo "<table cellspacing='4' cellpadding='0' border='0'>";
                                                               echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>FirstName:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo $firstName;
                                                                    echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>MiddleName:</td>";
                                                                    echo "<td class='TinyTextColumn'>$middleName</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>LastName:</td>";
                                                                    echo "<td class='TinyTextColumn'>$lastName</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Gender:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo collectGender($gender);




                                                                    echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Age:</td>";
                                                                    echo "<td class='TinyTextColumn'>";

                                                                        $d1 = new DateTime();
                                                                        $d2 = new DateTime($dob);

                                                                        $diff = $d2->diff($d1);

                                                                        echo $diff->y;



                                                                        echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Membership Date</td>";
                                                                    echo "<td class='TinyTextColumn'>$membership_date</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Classification:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo collectClass($classification);




                                                                    echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Department:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo collectDept($department);




                                                                    echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Marital Status:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo collectMstatus($marital_status);



                                                                    echo "</td>";
                                                                echo "</tr>";
                                                            echo "</table>";
                                                        echo "</td>";

                                                        echo "<td align='center'>";
                                                            echo "<b>GENERAL INFORMATION:</b>";
                                                            echo "<table cellspacing='4' cellpadding='0' border='0'>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Role:</td>";
                                                                    echo "<td class='TinyTextColumn'>";
                                                                        echo collectRole($role);




                                                                    echo "</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Employment Date:</td>";
                                                                    echo "<td class='TinyTextColumn'>$employment_date</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Home Phone:</td>";
                                                                    echo "<td class='TinyTextColumn'>$home_phone</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Work Phone:</td>";
                                                                    echo "<td class='TinyTextColumn'>$work_phone</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Mobile Phone:</td>";
                                                                    echo "<td class='TinyTextColumn'>$mobile_phone</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Personal Email:</td>";
                                                                    echo "<td class='TinyTextColumn'>$personal_email</td>";
                                                                echo "</tr>";
                                                               echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Work Email:</td>";
                                                                    echo "<td class='TinyTextColumn'>$work_email</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>Residential Address:</td>";
                                                                    echo "<td class='TinyTextColumn'>$residential</td>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    echo "<td class='TinyLabelColumn'>'Postal Address:'</td>";
                                                                    echo "<td class='TinyTextColumn'>$postal</td>";
                                                                echo "</tr>";
                                                            echo "</table>";
                                                        echo "</td>";
                                                    echo "</tr>";
                                                echo "</table>";
                                            echo "</div>";
                                        echo "</td>";

                                    echo "</tr>";

                                echo "</table>";
                            echo "<div class=\"pull-right center\">
	                                        	<span class=\"label green\">
                                                    <a href=\"user-edit.php?memberID=$memberID \" class=\"glyphicon glyphicon-pencil\" >Edit-Profile
                                                    </a>
                                                </span>";
                            echo"</div>";
                            echo "</div>";

                        echo "</div>";
                    echo "</div>";
                    echo  "</div>";
endwhile; ?>
    </div>
<?php
require_once 'includes/pageScripts.php'; // Include the JavaScript libraries
?>

</body>


