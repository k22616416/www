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

$sql = "SELECT * FROM imgtest WHERE 1";
$result = $conn->query($sql);
$conn->close();

//查詢結果

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $img = $row["img"];
        $logodata = $img;
        echo '<img src="data:' . $row['imgtype'] . ';base64,' . $row["img"] . '" />';
    }
} else {
}
echo $img;
