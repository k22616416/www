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
        $orderDetail[$list[$i]['seller']][] = array('CID' => $list[$i]['CID'], 'name' => $list[$i]['name'], 'CCash' => $list[$i]['CCash'], 'count' => $list[$i]['count']);
        //0610 21:13
    }
}
echo $_SESSION['user'];

for ($i = 0; $i < count($sellerList); $i++) {
}

// for ($i = 0; $i < count($list, COUNT_NORMAL); $i++) {
//     $cmd = 'INSERT INTO `訂單`
//     (`訂單編號`,
//     `訂購者帳號`,
//     `訂單日期`,
//     `販售者帳號`,
//     `賣場編號`,
//     `購買清單`,
//     `訂單金額`,
//     `配銷方式`,
//     `訂單狀態`)
//     VALUES("",
//     "'..'")';
//     if (($sqlData = SqlCommit($conn, $cmd)) != null) {
//     }
// }




function getSeller($index)
{
    global $conn;
    $result = "";
    $cmd = 'SELECT `小農`.`使用者帳號` FROM `小農` 
            INNER JOIN `個人賣場2` 
            ON `小農`.`賣場編號`=`個人賣場2`.`賣場編號`
            WHERE `個人賣場2`.`產品編號`=' . $index . '';
    if (($sqlData = SqlCommit($conn, $cmd)) != null) {
        $row = $sqlData->fetch_array();
        $result = $row['使用者帳號'];
    } else
        $result = null;
    return $result;
}
