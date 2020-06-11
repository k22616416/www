<?php
session_start();
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
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
    "' . "123" . '",
    "' . "面交" . '",
    "' . "0" . '")';
    echo $cmd;
    if (($sqlData = mysqli_query($conn, $cmd)) != true) {
        $error = true;
        $errorStr += $conn->error . "\n";
    }
}
if ($error) {
    echo $errorStr;
    echo '<script>alert("訂單提交失敗!");</script>';
} else {
    echo '<script>alert("訂單提交成功!");</script>';
    unset($_SESSION['buyCarList']);
}
echo '<script>document.location.href = "index.php";</script>';


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
