<?php

require_once 'functions/functions.php';
require_once 'dbconfig.php';

$userCode = ($_GET['userCode']);
$subStatus = ($_GET['subStatus']);
$cycleNo = ($_GET['cycleNo']);
$conn = connection();

    $sql = "UPDATE subscribers SET subStatus = 1 WHERE subscriberID=$userCode AND cycleNo=$cycleNo";
    $conn->query($sql);
    cycleAccountChange($cycleNo);
    echo "<script>location.href='index.php'</script>";


$conn->close();

?>
