<?php
$DBNAME = "imgtest";
$DBUSER = "root";
$DBHOST = "localhost";
$conn = mysqli_connect($DBHOST, $DBUSER, '', $DBNAME);
if ($conn->connect_error) {
    print mysqli_error($conn);
    die('連線失敗');
}
mysqli_query($conn, "set character set utf8");
mysqli_query($conn, "SET CHARACTER_SET_database= utf8");
mysqli_query($conn, "SET CHARACTER_SET_CLIENT= utf8");
mysqli_query($conn, "SET CHARACTER_SET_RESULTS= utf8");

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
