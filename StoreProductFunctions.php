<?php
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}
date_default_timezone_set('Asia/Taipei');
if (isset($_POST["add"])) {
    $cmd = 'SELECT MAX(`項目`) AS "數量" FROM `個人賣場2` WHERE 1';
    $sqlData = mysqli_query($conn, $cmd);
    if ($sqlData->num_rows > 0)
        $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
    if ($sqlArray == null) echo 'error';
    else $len = $sqlArray['數量'];
    $len++;
    $cmd = '
    INSERT INTO `產品資訊`
    (`產品編號`,`示意圖`, 
    `圖片編碼格式`, `價格`, 
    `剩餘數量`, `是否有機`, 
    `物種`, `每公斤單價`, 
    `收成時間`,`名稱`, 
    `產地`, `產品註明`,
    `上架日期`,`審核狀態`) 
    VALUES ("' . $len . '","",
    "","0",
    "0","0",
    "","0",
    "","產品名稱",
    "","",
    "' . date("Y-m-d H:i:s") . '","1");';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error @ add 1:<br>';
        echo $conn->error . "<br>";
    } else {
        $cmd = '
INSERT INTO `個人賣場2`
        (`項目`, `賣場編號`, 
        `產品編號`, `產品資訊`, 
        `願意配銷地點`, `配銷方式`) 
VALUES ("","' . $_POST['storeIndex'] . '",
        ' . $len . ',"",
        "","")';
    }
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error @ add 2<br>';
        echo $conn->error . "<br>";
    }
} else if (isset($_POST['del'])) {
    $len = $_POST['length'];
    for ($i = 0; $i < $len; $i++) {
        $cmd = 'DELETE FROM `個人賣場2` WHERE `產品編號`="' . $_POST['productIndex' . $i] . '";';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) {
            echo 'error @ del 1<br>';
            echo $conn->error . "<br>";
            die();
        }
        $cmd = 'DELETE FROM `產品資訊` WHERE `產品編號`="' . $_POST['productIndex' . $i] . '";';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) {
            echo 'error @ del 1<br>';
            echo $conn->error . "<br>";
            die();
        }
    }
}
$conn->close();
echo '<script>document.location.href="farmManagement.php?method=1";</script>';
