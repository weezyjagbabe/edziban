<?php


require_once 'models/configurations/configuration.php';

$menuID = ($_GET['menuID']);
$menuStatus = ($_GET['menuStatus']);
$connection = mysqlconnect();
if ($menuStatus == 1)
{
    $sql = "UPDATE weeklymenu SET menuStatus = 0 WHERE menuID=$menuID";
    $connection->query($sql);
    echo json_encode([
        'code' => 100,
        'status' => 0
    ]);
}
else{
    $sql = "UPDATE weeklymenu SET menuStatus = 1 WHERE menuID=$menuID";
    $connection->query($sql);
    echo json_encode([
        'code' => 100,
        'status' => 1
    ]);
}
$connection->close();

?>
