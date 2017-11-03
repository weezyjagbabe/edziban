<?php
$pageName = 'Printout';
require_once 'models/functions/functions.php';
require_once 'models/configurations/configuration.php';
require_once 'includes/pageIncludeFiles.php';
$cycleID = $_GET['cycleID'];

                        echo "<div class=\"content-box-large\">";
                        echo "<div class=\"panel-heading\">";
                        echo "<div class=\"panel-title\"><strong><u><h1>CYCLE-RECONCILIATION</h1></u></strong>";



                        $info = array();
                        $info = cycleInfo($cycleID);
                        $startDate=date_create($info[0]);
                        $endDate = date_create($info[1]);

                        echo "<br><strong><u><h3>SUBSCRIPTIONS FOR ";
                        echo date_format($startDate,"jS F, Y").' to '.date_format($endDate,"jS F, Y");
                        echo "</h3></u></strong></div></div>";
                        echo "<div class=\"panel-body\"> <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"table table-striped table-bordered\" id=\"example\"><thead><tr><th>Name(s)</th>";
                        for($i = 1; $i <= $info[2]; $i++){
                            echo "<th>Day $i</th>";
                        }
                        echo "<th>Total</th>";
                        echo "<th>Signature</th></tr></thead><tbody>";


                        $connection = mysqlconnect();
                        $stmt = $connection->prepare(" SELECT * FROM cycleaccounts a LEFT JOIN cycles c ON a.cycleNo = c.cycleID LEFT JOIN subscribers s ON s.cycleNo = a.cycleNo AND s.subStatus = 1 WHERE a.cycleNo=?" );
                        $stmt->bind_param('i',$cycleID);
                        $stmt -> execute();
                        $stmt -> bind_result( $AccID, $cycleNo, $subs, $nonSubs, $noOfDays, $totalComputed, $cycleID ,$cycleStart, $cycleEnd, $subscribeID, $cycleNoA, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $status);
                        while( $row = $stmt->fetch() ) :
                        echo "<tr><td>$subscriberName</td>";
                            for($i = 1; $i <= $info[2]; $i++){
                                echo "<td>✓</td>";
                            }
                            echo "<td>GHC $amountComputed.00</td>";
                            echo "<td>......................</td></tr>";
                        endwhile;
                        echo "</tbody></table>";
                        echo "<div class=\"panel-title\"><strong><u><h1>TOTAL: GHC $totalComputed.00</h1></u></strong></div>";
                        echo "<button onclick=\"myFunction()\">PRINT PAGE</button>";
                        echo "<button onclick=\"returnNow()\">RETURN</button>";
                        echo "</div></div></div>";
?>
<script>
    function myFunction() {
        window.print();
    }
    function returnNow() {
        location.href=document.referrer;
    }
</script>
