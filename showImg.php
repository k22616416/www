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
$sql = "SELECT * FROM imgtest WHERE 1";
$result = $conn->query($sql);
$conn->close();

//查詢結果

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $img = $row["img"];
        $logodata = $img;
        echo '<img src="data:' . $row['imgtype'] . ';base64,' . $logodata . '" />';
    }
} else {
}
echo $img;
