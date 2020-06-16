<?php

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}
if (isset($_POST['statusSubmit'])) {
    $len = $_POST['orderLength'];
    for ($i = 0; $i < $len; $i++) {
        $cmd = 'UPDATE `訂單` SET `訂單狀態`= "1" WHERE `訂單編號` =' . $_POST['orderIndex' . $i] . ';';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) {
            echo 'error @ ' . $i;
        }
    }
} else if (isset($_POST['block'])) {
    $len = $_POST['orderLength'];
    for ($i = 0; $i < $len; $i++) {
        $cmd = 'UPDATE `訂單` SET `訂單狀態`= "2" WHERE `訂單編號` =' . $_POST['orderIndex' . $i] . ';';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) {
            echo 'error @ ' . $i;
        }
    }
}
// echo '<script>document.location.href="managementPage.php?method=7";</script>';
