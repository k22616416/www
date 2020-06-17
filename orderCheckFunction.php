<?php

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}

if (isset($_POST['pass'])) {
    $index = $_POST['productIndex'];
    $cmd = 'UPDATE `產品資訊` SET `審核狀態`="1" WHERE `產品編號`="' . $index . '"';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo "error @ 1";
    }
} else if (isset($_POST['block'])) {
    $index = $_POST['productIndex'];
    $cmd = 'UPDATE `產品資訊` SET `審核狀態`="2" WHERE `產品編號`="' . $index . '"';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo "error @ 2";
    }
}
$conn->close();
echo '<script>document.location.href="managementPage.php?method=3";</script>';
