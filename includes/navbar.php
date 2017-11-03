<?php
/**
 * Created by PhpStorm.
 * User: sbortey
 * Date: 30/07/2017
 * Time: 7:34 AM
 */
?>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <!-- Logo -->
                <div class="logo">
                    <h1><a href="index.php"><?php echo PRODUCTNAME; ?></a></h1>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-lg-12">
<!--                        <div class="input-group form">-->
<!--                            <input type="text" class="form-control" placeholder="Search...">-->
<!--                            <span class="input-group-btn">-->
<!--	                         <button class="btn btn-primary" type="button">Search</button>-->
<!--	                       </span>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="navbar navbar-inverse" role="banner">
                    <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                                <ul class="dropdown-menu animated fadeInUp">
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="passwordChange.php">Change Password</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
