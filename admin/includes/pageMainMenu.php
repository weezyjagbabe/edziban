<div class="mainmenu">
    <div class="container-fluid">
        <ul class="nav pull-right">
            <li class="collapseMenu"><a href="#"><i class="icon-double-angle-left"></i>hide menu<i class="icon-double-angle-right deCollapse"></i></a></li>
            <li class="divider-vertical firstDivider"></li>
            <li class="left-side <?php if( $pageName == 'Dashboard' ) { echo "active"; }else{ echo "inactive";} ?>" id="dashboard"><a href="dashboard"><i class="icon-dashboard"></i> DASHBOARD</a></li>
            <li class="divider-vertical"></li>
            <li style="padding-bottom: 10px" class="dropdown <?php if( $pageName == 'Subscribers' || $pageName == 'Subscription-Cycles' || $pageName == 'Cycle-Reconciliation' || $pageName == 'Food Menu' || $pageName == 'Add Cycle' || $pageName == 'Add Menu') { echo "active"; } else{ echo "inactive";}?>" id="interfaceElements">
                <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-pencil"></i> FOOD MANAGEMENT <span class="label label-pressed">
                        <?php
                        $connection = mysqlconnect();
                        $howmanymenus_query = $connection->query('SELECT COUNT(*)  FROM menumain;');
                        $howmanymenus = $howmanymenus_query->fetch_array(MYSQLI_NUM);
                        echo $howmanymenus[0] + 1;
                        ?></span></a>
                <ul class="dropdown-menu" style="padding-bottom: 10px">
                    <li style="padding-bottom: 10px"><a tabindex="-1" href="foodmenu.php">WEEKLY MENU</a></li>
                    <?php
                    $connection = mysqlconnect();
                    $stmt = $connection->prepare(" SELECT menuID, menuName, menuLink, hasSub FROM menuMain ");
                    $stmt -> execute();
                    $stmt -> bind_result( $menuID, $menuName, $menuLink, $hasSub );
                    while( $row = $stmt->fetch() ) :
                        ?>
                        <li style="padding-bottom: 10px"><a tabindex="-1" href="<?php echo $menuLink; ?>"><?php echo strtoupper( $menuName ); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </li>
            <li class="divider-vertical"></li>
            <li style="padding-bottom: 10px class="dropdown <?php if( $pageName == 'User-Management' || $pageName == 'Add-User' ) { echo "active"; } else{ echo "inactive";}?>" id="interfaceElements">
                <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-pencil"></i> USER MANAGEMENT <span class="label label-pressed">2</span></a>
                <ul class="dropdown-menu" style="padding-bottom: 10px">
                    <li style="padding-bottom: 10px"><a tabindex="-1" href="user-management.php">ALL USERS</a></li>
                    <li style="padding-bottom: 10px"><a tabindex="-1" href="add-user.php">ADD USER</a></li>
                </ul>
            </li>
            <li class="divider-vertical"></li>
            <li <?php if( $pageName == 'Calender' ) { echo "class='active'"; } ?> id="interfaceElements"><a href="calender"><i class="icon-calendar"></i> CALENDER</a></li>
            <li class="divider-vertical"></li>
            <li <?php if( $pageName == 'Help' ) { echo "class='active'"; } ?> ><a href="help" id="help"><i class="icon-play-circle"></i> HELP</a></li>
            <li class="divider-vertical"></li>
            <div class="nav pull-right">
                <div class="input-append">
                    <div class="collapsibleContent">
                        <a href="#profileContent" class="sidebar">
                        <span class="add-on add-on-mini add-on-dark" id="profile">
                            <i class="icon-user"></i>
                            <span class="username">Admin</span>
                        </span>
                        </a>
                    </div>
                    <a href="#collapsedSidebarContent" class="collapseHolder sidebar">
                    <span class="add-on add-on-mini add-on-dark">
                        <i class="icon-sort-down"></i>
                    </span>
                    </a>
                </div>
            </div>
        </ul>
    </div>
</div>
