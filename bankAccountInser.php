<?php
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}

if (isset($_POST['submitPayment'])) {
    $cmd = 'UPDATE `配銷方式` SET `匯款帳戶`="' . $_POST['payment'] . '" WHERE `訂單編號`="' . $_POST['orderIndex'] . '"';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo "error";
        die();
    }
}

$conn->close();
echo '<script>document.location.href = "farmManagement.php?method=2";</script>';
