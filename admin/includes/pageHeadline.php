

<div class="titleLine">
    <div class="container-fluid">
        <div class="titleIcon"><i class="icon-dashboard"></i></div>
        <ul class="titleLineHeading">
            <li class="heading"><h1><?php echo $pageName; ?></h1></li><br>
            <li class="subheading">
            	<?php
            		if ( isset( $menuDesc ) ) { echo $menuDesc; }
					else { echo "Your No.1 stop for a balanced diet"; }
            	?>
            </li>
        </ul>
        <ul class="titleLineCharts pull-right">
            <li style="padding-bottom:30px">
                <span class="usersBar">100,235,549,222,639,335,800</span>
                <h2 class="cyanText">
                    <?php
                    $connection = mysqlconnect();
                    $stmt = $connection->prepare(" SELECT COUNT(memberID) FROM members " );
                    $stmt -> execute();
                    $stmt -> bind_result( $loginCount );
                    $stmt->fetch();
                    echo $loginCount;
                    ?>
                    <span class="greyText">Users</span></h2>
            </li>

                    <?php
                    $connection = mysqlconnect();
                    $stmt = $connection->prepare(" SELECT subs, totalComputed FROM cycleaccounts ORDER BY cycleNo DESC LIMIT 1" );
                    $stmt -> execute();
                    $stmt -> bind_result( $subs, $total );
                    $stmt->fetch();
                    ?>
            <li style="padding-bottom:30px">
                <span class="visitsBar">20,35,10,80,52,34,74,99,45,68</span>
                <h2 class="redText"><?php echo $subs ?><span class="greyText">Subscribed</span></h2>
            </li>
            <li style="padding-bottom:30px">
                <span class="ordersBar">254,159,480,531,214,984,671</span>
                <h2 class="greenText">GHC<?php echo $total ?><span class="greyText">Total</span></h2>
            </li>
        </ul>
    </div>
</div>
<div class="col-sm-12">
    <div class="container-fluid">
<ul class="breadcrumb"><br>
    <li><i class="icon-home"></i><a href="#"> Home</a> <span class="divider"><i class="icon-angle-right"></i></span></li>
    <li class="active"><?php echo $pageName; ?></li>
    <li class="moveDown pull-right">
        <span class="time"></span>
        <span class="date"></span>
    </li>    
</ul></div>
</div>

