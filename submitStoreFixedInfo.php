<?php
// error_reporting(0);
$imgInput;   //產品編號
echo $_POST["commodityIndex"];
echo $_POST['CName'];
echo $_POST['cash'];
echo $_POST['location'];
echo $_POST['transport'];
echo $_POST['maxCount'];
exit;

$commodityIndex = $_POST["commodityIndex"];
$CName = $_POST['CName'];
$cash = $_POST['cash'];
$location = $_POST['location'];
$transport = $_POST['transport'];
$maxCount = $_POST['maxCount'];

// $imgInput = $_FILES['imgInput'];
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
echo '<img src="data:' . $imgType . ';base64,' . $fileContents . '" />';

$DBNAME = "小農2";
$DBUSER = "root";
$DBHOST = "localhost";
$conn = mysqli_connect($DBHOST, $DBUSER, '');
if (empty($conn)) {
    print mysqli_error($conn);
    echo ("資料庫連線失敗");
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}
if (!mysqli_select_db($conn, $DBNAME)) {
    echo ("資料庫連線失敗");
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}

echo '1' . $fileContents . '<br>' . $imgType . '<br>' . $cash . '<br>' . $maxCount . '<br>' . $cash . '<br>' . $CName . '<br>' . $commodityIndex;
// $sql = "INSERT INTO  `imgtest`(`img`, `imgtype`)  VALUES ('$fileContents','$imgType')";
// if ($conn->query($sql) === TRUE) {
//     echo "成功";
// } else {
//     //echo "Error: " . $sql . "<br>" . $conn->error;
//     echo "失敗";
// }
$sql = 'UPDATE `產品資訊` 
    SET `示意圖`="' . $fileContents . '",
    `圖片編碼格式`="' . $imgType . '",
    `價格`="' . $cash . '",
    `剩餘數量`="' . $maxCount . '",
    `每公斤單價`="' . $cash . '",
    `名稱`="' . $CName . '",
    `審核狀態`="0" 
    WHERE `產品編號`="' . $commodityIndex . '";';
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("成功");</script>';
} else {
    echo '<script>alert("失敗");</script>';
}
$conn->close();
    // echo '<script>document.location.href="farmManagement.php"</script>';
