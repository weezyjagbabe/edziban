<?php
session_start();
if(!isset($_SESSION['userCode']) && !isset($_SESSION['email']))
{
    echo "<script>location.href='login.php'</script>";
}
else
{
	$pageName	=	"Home";
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
                                <div class="panel-title "><h2>Current Cycle</h2></div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cycles</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>No. of Days</th>
                                            <th>Amount Due</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $conn = connection();
                                    $stmt = $conn->prepare('SELECT cycleNo, startDate, endDate, cycleDuration, amountComputed, subStatus FROM subscribers WHERE subscriberID=? ORDER BY subscribeID DESC LIMIT 1 ');
                                    $stmt->bind_param('i',$userCode);
                                    $stmt->execute();
                                    $stmt->bind_result($cycleNo, $startDate, $endDate, $cycleDuration, $amountComputed, $subStatus);
                                    while( $row = $stmt->fetch() ) :
                                        ?>
                                        <tr>
                                            <td>Cycle <?php echo $cycleNo ?></td>
                                            <td><?php $startDate=date_create($startDate); echo date_format($startDate,"jS F, Y") ?></td>
                                            <td><?php $endDate=date_create($endDate); echo date_format($endDate,"jS F, Y") ?></td>
                                            <td><?php echo $cycleDuration ?> days</td>
                                            <td><?php echo 'GHC '.sprintf("%.2f", $amountComputed); ?></td>
                                            <td><span id="text" <?php if ($subStatus === 0){ ?> class="btn btn-primary btn-xs" style="color: white" <?php ;}else{?> class="btn btn-default btn-xs" disabled <?php ;} ?> >
                                                    <a <?php if($subStatus === 0){ ?> style="color: white" <?php } ?> class="changeStatus" data-cycle-id="<?php echo $cycleNo ?>" data-cycle-status="<?php echo $subStatus ?>" data-user-id="<?php echo $userCode ?>" href="userCycleStatus.php?userCode=<?php echo $userCode ?>&subStatus=<?php echo $subStatus ?>&cycleNo=<?php echo $cycleNo?>"  id="subscribeStatus">
                                                         <?php
                                                         if ($subStatus === 1){
                                                             echo "Subscribed";
                                                         }else{
                                                             echo "Subscribe Now!!!";
                                                         }
                                                         ?>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="content-box-large">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title"><h2>Weekly Menu</h2></div>

                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Days</th>
                                        <th>Menu 1</th>
                                        <th>Menu 2</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $menuStatus = 1;
                                    $conn = connection();
                                    $stmt = $conn->prepare('SELECT menuID, days, choice1, choice2 FROM weeklymenu WHERE menuStatus=?');
                                    $stmt->bind_param('i', $menuStatus);
                                    $stmt->execute();
                                    $stmt->bind_result($menuID, $days, $choice1, $choice2);
                                    while( $row = $stmt->fetch() ) :
                                        ?>






                                        <tr>
                                            <td><?php echo $menuID ?></td>
                                            <td><?php echo $days ?></td>
                                            <td><?php echo $choice1 ?></td>
                                            <td><?php echo $choice2 ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="content-box-large">
                            <div class="content-box-header panel-heading">
                                <div class="panel-title"><h2>Previous Subscriptions</h2></div>


                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                    <a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Cycles</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>No. of Days</th>
                                            <th>Amount Due</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        $max = ('SELECT MAX (cycleNo)');
                                        $subStatus = 1;
                                        $conn = connection();
//                                        $stmt = $conn->prepare('SELECT cycleNo, startDate, endDate, cycleDuration, amountComputed FROM subscribers WHERE subscriberID=? AND subStatus=?  ');
                                        $stmt = $conn->prepare('SELECT cycleNo, startDate, endDate, cycleDuration, amountComputed FROM subscribers WHERE (subscriberID=? AND subStatus=?) AND cycleNo < (SELECT MAX(cycleNo) FROM subscribers) ');
                                        $stmt->bind_param('ii', $userCode, $subStatus );
                                        $stmt->execute();
                                        $stmt->bind_result($cycleNo, $startDate, $endDate, $cycleDuration, $amountComputed);
                                        while( $row = $stmt->fetch() ) :
                                        ?>
                                        <tr>
                                            <td>Cycle <?php echo $cycleNo ?></td>
                                            <td><?php $startDate=date_create($startDate); echo date_format($startDate,"jS F, Y") ?></td>
                                            <td><?php $endDate=date_create($endDate); echo date_format($endDate,"jS F, Y") ?></td>
                                            <td><?php echo $cycleDuration ?> days</td>
                                            <td><?php echo 'GHC '.sprintf("%.2f", $amountComputed); ?></td>

                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
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

    </body>
</html>
<?php } ?>