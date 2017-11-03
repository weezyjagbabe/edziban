<?php
require_once 'models/functions/functions.php';
require_once 'models/configurations/configuration.php';
$cycleID = ($_GET['cycleID']);
$subscribeID = ($_GET['subscribeID']);
$subStatus = ($_GET['subStatus']);
$connection = mysqlconnect();
if ($subStatus == 1)
{
    $sql = "UPDATE subscribers SET subStatus = 0 WHERE subscribeID=$subscribeID";
    $connection->query($sql);
    $connection->close();
    cycleAccountChange($cycleID);
    echo json_encode([
        'code' => 100,
        'status' => 0
    ]);
}
//else{
//    $sql = "UPDATE subscribers SET subStatus = 1 WHERE subscribeID=$subscribeID";
//    $connection->query($sql);
//    $connection->close();
//    cycleAccountChange($cycleID);
//    echo json_encode([
//        'code' => 100,
//        'status' => 1
//    ]);
//}



?>
