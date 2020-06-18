<?php
session_start();
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}


function getStoreIndex($user)
{
    echo $user;
    global $conn;
    $result = "";
    $cmd = 'SELECT * FROM `小農` 
            WHERE `使用者帳號`="' . $user . '"';
    if (($sqlData = SqlCommit($conn, $cmd)) != null) {
        $row = $sqlData->fetch_array();
        $result = $row['賣場編號'];
    } else {
        $result = null;
    }
    return $result;
}

function getOrderIndex()
{
    global $conn;
    $cmd = 'SELECT MAX(`訂單編號`) as `訂單編號` FROM `訂單` WHERE `訂購者帳號`="' . $_SESSION['user'] . '" ;';
    $sqlData = mysqli_query($conn, $cmd);
    if ($sqlData->num_rows > 0) {
        $sqlArray = mysqli_fetch_assoc($sqlData);
        return $sqlArray['訂單編號'];
    }
    return null;
}



$list = unserialize($_SESSION['buyCarList']);
$lastSSeller = '';
$nowSeller = '';
// $sellerList;
$sellerCount = 0;

for ($i = 0; $i < count($list); $i++) {
    if (!in_array($list[$i]['seller'], $sellerList)) {
        $sellerList[] = $list[$i]['seller'];
        $sellerCount++;
        $orderDetail[$list[$i]['seller']][] = array('CID' => $list[$i]['CID'], 'name' => urlencode($list[$i]['name']), 'CCash' => $list[$i]['CCash'], 'count' => $list[$i]['count']);
    } else {
        // array_search($list[$i]['seller'], $sellerList);
        $orderDetail[$list[$i]['seller']][] = array('CID' => $list[$i]['CID'], 'name' => urlencode($list[$i]['name']), 'CCash' => $list[$i]['CCash'], 'count' => $list[$i]['count']);
    }
    // print_r("<pre>");
    // print_r($orderDetail);
    // echo count($orderDetail);
}
// print_r("<pre>");
// print_r(json_encode($orderDetail['qaz']));
// print_r(json_decode(json_encode($orderDetail['qaz'])));
// for ($i = 0; $i < count($orderDetail); $i++) {
//     foreach ($orderDetail[$sellerList[$i]] as $index => $var) {
//         echo $index . "=>" . $var["CID"] . "<br>";
//     }
// }

date_default_timezone_set("Asia/Taipei");
$error = false;
$errorStr = "";
for ($i = 0; $i < count($orderDetail); $i++) {
    // $total = 0;
    // for ($k = 0; $k < count($orderDetail[$sellerList[$i]]); $k++)
    //     $totla += $orderDetail[$sellerList[$i]]["count"] * $orderDetail[$sellerList[$i]]["CCash"];
    // echo $total;
    $storeIndex = getStoreIndex($sellerList[$i]);
    $cmd = 'INSERT INTO `訂單`
    (`訂單編號`,
    `訂購者帳號`,
    `訂單日期`,
    `販售者帳號`,
    `賣場編號`,
    `購買清單`,
    `訂單金額`,
    `配銷方式`,
    `訂單狀態`)
    VALUES("",
    "' . $_SESSION['user'] . '",
    "' . date("Y/m/d H:i:s") . '",
    "' . $sellerList[$i] . '",
    "' . $storeIndex . '",
    \'' . json_encode($orderDetail[$sellerList[$i]]) . '\',
    "' . $_POST['totalCash'] . '",
    "' . $_POST['transport'] . '",
    "' . "0" . '")';
    // echo $cmd;
    if (($sqlData = mysqli_query($conn, $cmd)) != true) {
        $error = true;
        $errorStr = $errorStr . $conn->error . "<br>";
    }
    $cmd = 'UPDATE `配銷方式` SET `配銷地址`="' . $_POST['position'] . '",`配銷方式`="' . $_POST['transport'] . '" WHERE `訂單編號`="' . getOrderIndex() . '" ;';
    // $cmd = 'INSERT INTO `配銷方式`(`訂單編號`, `付款方式`, `配銷地址`, `匯款帳戶`) VALUES ("' . getOrderIndex() . '","","' . $_POST['transport'] . '","' . $_POST['position'] . '")';
    if (($sqlData = mysqli_query($conn, $cmd)) != true) {
        $error = true;
        $errorStr = $error . $conn->error . "<br>";
    }
}
if ($error) {
    echo $errorStr;
    echo '<script>alert("訂單提交失敗!");</script>';
} else {
    echo '<script>alert("訂單提交成功!");</script>';
    unset($_SESSION['buyCarList']);
}
$conn->close();
if (!$error) echo '<script>document.location.href = "index.php";</script>';
