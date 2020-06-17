<?php
include_once("sqlConnectAPI.php");
// error_reporting(0);

$commodityIndex;
$CName;
$cash;
$location;
$transport;
$maxCount;
$imgType;
$commodityIndex = $_POST['commodityIndex'];
$CName = $_POST['CName'];
$cash = $_POST['cash'];
$location = $_POST['location'];
$transport = $_POST['transport'];
$maxCount = $_POST['maxCount'];
$item = $_POST["item"];
$orgin = $_POST["origin"];
$time = $_POST["time"];
$organic = $_POST["organic"];
$remark = $_POST["remark"];
$base = $_POST['base'];

$imgEmpty = false;

if (!empty($_FILES["imgInput"])) {
    //開啟圖片檔
    $file = fopen($_FILES["imgInput"]["tmp_name"], "rb");
    // 讀入圖片檔資料
    $fileContents = fread($file, filesize($_FILES["imgInput"]["tmp_name"]));
    //關閉圖片檔
    fclose($file);
    //讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
    $fileContents = base64_encode($fileContents);
    //組合查詢字串
    $imgType = $_FILES["imgInput"]["type"];
} else
    $imgEmpty = true;

$conn = ConnectDB();
if ($conn == null) {
    print mysqli_error($conn);
    echo ("資料庫連線失敗");
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}
if (!$imgEmpty) {
    $sql = 'UPDATE `產品資訊` 
    SET `示意圖`="' . $fileContents . '",
    `圖片編碼格式`="' . $imgType . '",
    `單位`="' . $base . '",
    `價格`="' . $cash . '",
    `剩餘數量`="' . $maxCount . '",
    `是否有機`="' . $organic . '",
    `物種`="' . $item . '",
    `每公斤單價`="' . $cash . '",
    `收成時間`="' . $time . '",
    `名稱`="' . $CName . '",
    `產地`="' . $orgin . '",
    `產品註明`="' . $remark . '",
    `審核狀態`="' . '0' . '" 
    WHERE `產品編號`="' . $commodityIndex . '";';
} else {
    $sql = 'UPDATE `產品資訊` 
    SET `單位`="' . $base . '",
    `價格`="' . $cash . '",
    `剩餘數量`="' . $maxCount . '",
    `是否有機`="' . $organic . '",
    `物種`="' . $item . '",
    `每公斤單價`="' . $cash . '",
    `收成時間`="' . $time . '",
    `名稱`="' . $CName . '",
    `產地`="' . $orgin . '",
    `產品註明`="' . $remark . '",
    `審核狀態`="' . '0' . '" 
    WHERE `產品編號`="' . $commodityIndex . '";';
}

if ($conn->query($sql) == false) {
    echo $conn->error;
    $error = true;
}
$sql = '
    UPDATE `個人賣場2` 
    SET`配銷方式`="' . $transport . '" 
    WHERE `產品編號`="' . $commodityIndex . '";';

if ($conn->query($sql) == false) {
    echo $conn->error;

    $error = true;
}
if ($error) {
    echo '<script>alert("失敗");</script>';
    die();
}

$conn->close();
echo '<script>document.location.href="farmManagement.php?method=1"</script>';
