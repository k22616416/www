<?php

function ConnectDB()
{
    $DBNAME = "40643223";
    $DBUSER = "root";
    $DBHOST = "localhost";
    $conn = mysqli_connect($DBHOST, $DBUSER, '', $DBNAME);
    if ($conn->connect_error) {
        print mysqli_error($conn);
        return null;
    }
    mysqli_query($conn, "set character set utf8");
    mysqli_query($conn, "SET CHARACTER_SET_database= utf8");
    mysqli_query($conn, "SET CHARACTER_SET_CLIENT= utf8");
    mysqli_query($conn, "SET CHARACTER_SET_RESULTS= utf8");
    return $conn;
}
function SqlCommit($conn, $cmd)
{
    $sqlData = $conn->query($cmd);
    if ($sqlData->num_rows > 0) {
        return $sqlData;
    } else
        return null;
}
function debug($str)
{
    echo '<script>
    console.log(\'' . $str . '\');
    </script>';
}
