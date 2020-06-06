<?php
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
//開啟圖片檔
$file = fopen($_FILES["upfile"]["tmp_name"], "rb");
// 讀入圖片檔資料
$fileContents = fread($file, filesize($_FILES["upfile"]["tmp_name"]));
//關閉圖片檔
fclose($file);
//讀取出來的圖片資料必須使用base64_encode()函數加以編碼：圖片檔案資料編碼
$fileContents = base64_encode($fileContents);

//連結MySQL Server
//組合查詢字串
$imgType = $_FILES["upfile"]["type"];
$sql = "INSERT INTO  `imgtest`(`img`, `imgtype`)  VALUES ('$fileContents','$imgType')";

//
if ($conn->query($sql) === TRUE) {
    echo "成功";
} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
    echo "失敗";
}

$conn->close();
