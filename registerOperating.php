<?php

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}
if (isset($_POST['pass'])) {
    $cmd = 'UPDATE `註冊審核` SET `審核狀態`="1" WHERE `編號` = ' . $_POST['registerIndex'] . ';';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error';
    }
} else if (isset($_POST['block'])) {
    $cmd = 'UPDATE `註冊審核` SET `審核狀態`="2" WHERE `編號` = ' . $_POST['registerIndex'] . ';';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error';
    }
}

echo '<script>document.location.href="managementPage.php?method=5";</script>';
