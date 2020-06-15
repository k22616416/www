<?php
// error_reporting(0);
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}


if (isset($_POST['method'])) {
    $method = $_POST['method'];
    if ($method == 0) {
        $item = explode(",", $_POST['productItem']);
        // $len = count($item);
        for ($i = 0; $i < count($item); $i++) {
            if (!($_POST['productSelect' . $item[$i]])) {
                continue;
            }
            $name = ($_POST['productName' . $item[$i]]);
            $cash = ($_POST['productCash' . $item[$i]]);

            $cmd = 'UPDATE `農產品` 
            SET `名稱`="' . $name . '",`限額公斤價`="' . $cash . '"
            WHERE `產品編號`="' . $item[$i] . '"';
            $sqlData = mysqli_query($conn, $cmd);
            if (!$sqlData) {
                echo "error@" . $i;
            }
        }
    } else if ($method == 1) {
    } else if ($method == 2) {
        $item = explode(",", $_POST['productItem']);
        for ($i = 0; $i < count($item); $i++) {
            $cmd = 'DELETE FROM `農產品`
            WHERE `產品編號`="' . $item[$i] . '"';
            $sqlData = mysqli_query($conn, $cmd);
            if (!$sqlData) {
                echo "error@" . $i;
            }
        }
    }
}

echo '<script>document.location.href = "managementPage.php?method=4";</script>';
