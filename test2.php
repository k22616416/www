<?php
date_default_timezone_set("Asia/Taipei");
echo date("Y/m/d H:i:s");
// $DBNAME = "test2";
// $DBUSER = "root";
// $DBHOST = "localhost";
// $conn = mysqli_connect($DBHOST, $DBUSER, '', $DBNAME);
// if ($conn->connect_error) {
//     print mysqli_error($conn);
//     echo ("資料庫連線失敗");
// }

// mysqli_query($conn, "set character set utf8");
// mysqli_query($conn, "SET CHARACTER_SET_database= utf8");
// mysqli_query($conn, "SET CHARACTER_SET_CLIENT= utf8");
// mysqli_query($conn, "SET CHARACTER_SET_RESULTS= utf8");
// $cmd = "SELECT * FROM `測試` WHERE 1;";
// $sqlData = $conn->query($cmd);
// if ($sqlData->num_rows > 0) {
//     while ($row = $sqlData->fetch_assoc()) {
//         echo $row['名稱'];
//     }
// }
