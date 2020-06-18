<?php

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}
if (isset($_POST['pass'])) {
    $cmd = 'SELECT * FROM `註冊審核` WHERE `編號` = ' . $_POST['registerIndex'] . ';';
    $sqlData = mysqli_query($conn, $cmd);
    if ($sqlData->num_rows > 0) {
        $sqlArray = mysqli_fetch_array($sqlData);
        if ($sqlArray['註冊身分類別'] == 1) {
            $cmd = 'INSERT INTO `小農`(`使用者帳號`, `姓名`, `使用者密碼`, `地址`, `Email`, `連絡電話`) VALUES ("' . $sqlArray['使用者帳號'] . '","' . $sqlArray['使用者帳號'] . '","' . $sqlArray['使用者密碼'] . '","' . $sqlArray['住址'] . '","' . $sqlArray['Email'] . '","' . $sqlArray['聯絡電話'] . '")';
            $sqlData = mysqli_query($conn, $cmd);
            if (!$sqlData) {
                echo '資料庫存取失敗';
            }
        }
        $cmd = 'INSERT INTO `消費者`(`使用者帳號`, `姓名`, `使用者密碼`, `地址`, `Email`, `連絡電話`) VALUES ("' . $sqlArray['使用者帳號'] . '","' . $sqlArray['使用者帳號'] . '","' . $sqlArray['使用者密碼'] . '","' . $sqlArray['地址'] . '","' . $sqlArray['Email'] . '","' . $sqlArray['聯絡電話'] . '")';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) {
            echo '資料庫存取失敗';
        }
    }
    $cmd = 'UPDATE `註冊審核` SET `審核狀態`="1" WHERE `編號` = ' . $_POST['registerIndex'] . ';';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error';
    }
} else if (isset($_POST['block'])) {
    $cmd = 'UPDATE `註冊審核` SET `審核狀態`="2" WHERE `編號` = ' . $_POST['registerIndex'] . ';';
    $sqlData = mysqli_query($conn, $cmd);
    if (!$sqlData) {
        echo 'error';
    }
}

echo '<script>document.location.href="managementPage.php?method=5";</script>';
