<?php

use function PHPSTORM_META\type;

session_start();
$_SESSION['root'] = 0;  /////////////////////for test

function checkRoot()
{
    return $_SESSION['root'];
}
?>
<link href="style.css" rel="stylesheet" type="text/css">
<script>
    function goHome() {
        document.location.href = "index.php";
    }
</script>
<?php
$loginStatus = false;
$loginMember = 0;
$infoName = '';
$errorCode = 0;
$storeName = '';
$storeInfo = '';
$storeOrder = 0;
$CommodityIndex = 0;
// $order = $_GET['orderIndex'];
error_reporting(0);
$titleStr = '小農線上市集媒合系統';

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}
// if (isset($_POST['farmNumber'])) {
//     $store = $_POST['farmNumber'];
// } else if (isset($_POST['storeNumber'])) {
//     $store = $_POST['storeNumber'];
//     $_SESSION['storeNumber'] = $store;
// } else if ($_SESSION['storeNumber'] != null) {
//     $store = $_SESSION['storeNumber'];
// } else if (isset($_POST['enterStore'])) {
//     $userName = $_POST['storeNumber'];
//     $cmd = "SELECT * FROM `小農` WHERE `使用者帳號`= '" . $userName . "';";
//     if (($sqlData = SqlCommit($conn, $cmd)) != null) {
//         while ($row = $sqlData->fetch_assoc()) {
//             $store = $sqlArray['賣場編號'];
//             $storeName = $sqlArray['使用者帳號'];
//         }
//     }
// } else {
//     echo '<script>alert("取得賣場編號失敗");</script>';
//     // echo "取得賣場編號失敗";
//     sleep(2);
//     if (!checkRoot()) echo '<script>document.location.href="index.php"</script>';
// }

if (isset($_POST['enterStore'])) {
    $store = $_POST['farmNumber'];
    $_SESSION['storeNumber'] = $store;
} else if ($_SESSION['storeNumber'] != null) {
    $store = $_SESSION['storeNumber'];
}




function orderStatus($x)
{
    switch ($x) {
        case 0:
            return '審核中';
        case 1:
            return '通過';
        case 2:
            return '未通過';
        default:
            return null;
    }
}

?>
<!-- 判斷有沒有登入 -->
<?php
if (isset($_POST['logout'])) {
    unset($_POST['logout']);
    unset($_SESSION['user']);
    unset($_SESSION['name']);
    unset($_SESSION['member']);
} else if ($_SESSION['user'] != null) {
    $loginStatus = true;
    $loginMember = $_SESSION['member'];
    $infoName = $_SESSION['name'];
    $userName = $_SESSION['user'];
    $farmStoreNumber = $_SESSION['farmStoreNumber'];
    $errorCode = 0;
} else {
    if (isset($_POST['farmerSubmit'])) {
        if (empty($_POST['user']) || empty($_POST['password'])) {
            $errorCode = 1;
        } else {
            $userName = $_POST['user'];
            $passwd = $_POST['password'];

            $cmd = "SELECT * FROM `小農` WHERE `使用者帳號`= '" . $userName . "' AND `使用者密碼`='" . $passwd . "';";
            $sqlData = mysqli_query($conn, $cmd);
            if ($sqlData->num_rows > 0) {
                $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
                $loginStatus = true;
                $loginMember = 2;
                $errorCode = 0;
                $infoName = $sqlArray['姓名'];
                $_SESSION['user'] = $userName;
                $_SESSION['name'] = $sqlArray['姓名'];
                $_SESSION['member'] = $loginMember;
            } else {
                $errorCode = 2;
            }
            unset($_POST['user']);
            unset($_POST['password']);
        }
    }

    if ($errorCode != 0) {
        echo '<script>alert("取得資訊時發生錯誤，將返回首頁\n' . $store . '");</script>';
        sleep(2);
        if (!checkRoot()) echo '<script>document.location.href="index.php"</script>';
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <script src="jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <title id="sql">
        農場管理頁面
    </title>
</head>

<body>

    <div class="WebLayout">
        <div class="topArea">
            <div class="titleDiv" id="sql">農場管理頁面</div>
            <div class="WebNameDiv" onclick="goHome()">
                小農<br>
                線上市集<br>
            </div>

            <div class="LoginArea">

                <!-- 已登入 -->
                <table class="loginTable" style="border-collapse:collapse; border:2px solid #000000; background-color: RGBA(255,255,255,0.50); <?php if (!$loginStatus) echo 'display:none;'; ?>">

                    <tbody>
                        <tr>
                            <td style="border:2px solid #000000; width:150px;">
                                <span style="font-size: 16px;"><?php echo '歡迎:' . $infoName; ?>
                            </td>
                            <form method="post" action="storePage.php">
                                <td style="border:2px solid #000000;"><button name="logout" type="submit" class="LoginButton" style=" position:relative ;right:0px;top:0px; width: 48px; height:25px; background-color: RGBA(255,0,0,0.70);">登出</button></td>

                            </form>
                        </tr>
                        <?php
                        if ($loginMember == 2) //小農身分
                        {
                            // echo '<tr >';
                            // echo '<form method="post" action="storePage.php">';
                            // echo '<td colspan=2><button class="RegisterButton" name="fixed" type="submit">修改個人資料</button></td>';
                            // echo '</form>';
                            // echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="storePage.php">';
                            echo '<input type="hidden" name="storeNumber" value="' . $farmStoreNumber . '">';
                            echo '<td colspan=2><button class="RegisterButton" name="enterStore" type="submit">進入個人賣場</button></td>';
                            echo '</form>';
                            echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="farmManagement.php?method=1">';
                            echo '<input type="hidden" name="farmNumber" value="' . $farmStoreNumber . '">';
                            echo '<td colspan=2><button class="RegisterButton" name="enterStore" >進入農場管理頁面</button></td>';
                            echo '</form>';
                            echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="userOrderList.php">';
                            echo '<input type="hidden" name="farmIndex" value="' . $userName . '">';
                            echo '<td colspan=2><button class="RegisterButton" name="enterStore" >查看已購買訂單</button></td>';
                            echo '</form>';
                            echo '</tr>';
                        } else if ($loginMember == 1) //消費者身分
                        {
                            echo '<tr>';
                            echo '<td colspan="2"><button class="RegisterButton" name="logout" type="submit">修改個人資料</button></td>';
                            echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="userOrderList.php">';
                            echo '<input type="hidden" name="farmIndex" value="' . $userName . '">';
                            echo '<td colspan=2><button class="RegisterButton" name="enterStore" >查看已購買訂單</button></td>';
                            echo '</form>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>

                </table>

            </div>
            <!-- 未登入 轉跳 -->


            <div class=" TopDiv">
                <form action="farmManagement.php" method="get">
                    <!--分割線上方Div-->
                    <button class="ManagementMethodDiv" type="submit" name="method" value="1" <?php if ($_GET['method'] == 1 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>商品清單</button>
                    <button class="ManagementMethodDiv" type="submit" name="method" value="2" <?php if ($_GET['method'] == 2 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>訂單清單</button>
                    <button class="ManagementMethodDiv" type="submit" name="method" id="orderDetail" style="display:none" ?>>訂單""</button>
                </form>
            </div>
            <hr class="TopHr">
            </hr>
        </div>
        <style>
            .farmMethodItem {
                background-color: rgba(255, 255, 255, 0.6);
                width: 100px;
                height: auto;
                position: absolute;

                top: 10px;
                right: -125px;
                padding: 5 5 5 5;
                border: 1px solid #000000;
            }
        </style>
        <!--透過SQL增加商品資訊-->
        <div class="mainDiv">
            <div class="farmMethodItem" align="center">
                <button class="addCommodity" onclick="addNewCommodity(1,'<?php echo $store; ?>')">新增產品</button>
                <button class="delCommodity" onclick="addNewCommodity(0,'<?php echo $store; ?>')" style="display: none;">刪除產品</button>
            </div>
            <?php

            function organicStatus($n)
            {
                switch ($n) {
                    case 0:
                        return '非有機';
                    case 1:
                        return '有機';
                    default:
                        return null;
                }
            }

            if (isset($_POST["orderIndex"])) {
                // echo $_POST["orderIndex"];
                debug("orderDetail");
                $cmd = 'SELECT * 
                FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE `訂單編號`="' . $_POST["orderIndex"] . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    $orderInfo = "";
                    while (($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) != null) {
                        echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse; ">
                                <tbody>
                                    <tr>
                                        <td style="width:295px;">
                                            訂購者帳號:' . $sqlArray['訂購者帳號'] . '
                                        </td>
                                        <td>
                                            訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:295px;">
                                            訂單編號:' . $sqlArray['訂單編號'] . '
                                        </td>
                                        <td>
                                            訂單建立日期:' . $sqlArray['訂單日期'] . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:295px;">
                                            購買者聯絡電話:' . $sqlArray['連絡電話'] . '
                                        </td>
                                        <td>
                                            訂單審核狀態:<span style="color:red">' . orderStatus($sqlArray['訂單狀態']) . '</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <form name="orderDetail" id="orderDetail" method="post" action="bankAccountInser.php">
                                    <td style="width:295px;">
                                        配送方式: ' . $sqlArray["配銷方式"] . '
                                    </td>
                                    <td>
                                        運送地址:' . $sqlArray["配銷地址"] . '
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            匯款帳戶: ';
                        if ($sqlArray["匯款帳戶"] == null) {
                            echo '<input type="text" name="payment" value="" placeholder="請輸入銀行帳戶" ' . ($sqlArray['訂單狀態'] != 1 ? 'disabled = "disabled"' : '') . '>';
                        } else {
                            echo $sqlArray["匯款帳戶"];
                        }
                        echo '
                                            <input type="hidden" name="orderIndex" value="' . $sqlArray['訂單編號'] . '" />
                                            <button name="submitPayment" style="height:25px;">送出</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>';

                        echo '<script>
                            document.getElementById("orderDetail").innerHTML = "訂單編號<br>\"' . $_POST["orderIndex"] . '\"";
                            document.getElementById("orderDetail").style="background-color:rgba(255, 255, 0, 0.9);";
                            </script>';
                        $orderInfo = json_decode($sqlArray['購買清單']);
                        // print_r("<pre>");
                        // print_r($orderInfo);
                    }
                    echo '
                    <table class="buyCarResultTable" rules="all" cellpadding="5">
                        <tbody>
                            <tr>
                                <td bgcolor="#FFC8B4" width="140" high="50" align="center" valign="center">
                                    <p align="center"><b>品項名稱</b></p>
                                </td>
                                <td bgcolor="#FFC8B4" width="140" high="50" align="center" valign="center">
                                    <p align="center"><b>單價</b></p>
                                </td>
                                <td bgcolor="#FFC8B4" width="140" high="50" align="center" valign="center">
                                    <p align="center"><b>數量</b></p>
                                </td>
                                <td bgcolor="#FFC8B4" width="140" high="50" align="center" valign="center">
                                    <p align="center"><b>小計</b></p>
                                </td>
                            </tr>
                        ';
                    $total = 0;
                    for ($i = 0; $i < count($orderInfo); $i++) {
                        echo '
                        <tr>
                            <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                                <p align="center"><b>' . urldecode($orderInfo[$i]->name) . '</b></p>
                            </td>
                            <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                                <p align="center"><b>' . $orderInfo[$i]->CCash . '</b></p>
                            </td>
                            <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                                <p align="center"><b>' . $orderInfo[$i]->count . '</b></p>
                            </td>
                            <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                                <p align="center"><b>' . $orderInfo[$i]->CCash * $orderInfo[$i]->count . '</b></p>
                            </td>
                        </tr>';
                        $total += $orderInfo[$i]->CCash * $orderInfo[$i]->count;
                    }
                    echo '<tr>
                    <td bgcolor="#FFFF33" colspan="1" width="140">
                      <p align="center"><b>總金額</b></p>
                    </td>
                    <td bgcolor="#FFFF33" colspan="2" width="270">
                    </td>
                    <td bgcolor="#FFFF33" colspan="1" width="140">
                      <p align="center"><b>' . $total . '</b></p>
                    </td>
                    </tr>';
                    echo '
                    
                        </tbody>
                    </table>
                    <form name="orderDetail" id="orderDetail" method="post" action="farmManagement.php?method=2">
                            <button type="submit" name="method" value="2" style="width:150px; margin: 20px 10px auto 10px;">返回訂單清單</button>
                    </form>
                    ';
                }
            } else if ($_GET["method"] == 1) {
                debug($store);

                $cmd = 'SELECT *
                        FROM (`小農` INNER JOIN `個人賣場2` ON `小農`.`賣場編號`=`個人賣場2`.`賣場編號`)
                        INNER JOIN `產品資訊` ON `個人賣場2`.`產品編號`=`產品資訊`.`產品編號`
                        WHERE `小農`.`賣場編號`="' . $store . '";';

                $index = 0;
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    debug($sqlData->num_rows);
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {


                        echo '
    <div style="display: flex;">
                <table class="StoreInfoTable" id="storeInfoTemplate" rules="all" style="width:550px;';
                        if ($sqlArray['審核狀態'] == 0) echo 'background-color: #ADADAD;';
                        echo '">
                    <form name="commodity" action="submitStoreFixedInfo.php" Enctype="multipart/form-data" method="post" align="center" style="margin:auto auto auto auto;">
                        <tbody>
                            <tr>
                                <input type="hidden" name="seller" value="' . $sqlArray['使用者帳號'] . '"/>
                                <input type="hidden" name="commodityIndex" value="' . $sqlArray['產品編號'] . '"/>
                                <td align="center" rowspan="5" style="width: 100px;color:#FF0000;padding:10 0 0 0 ;">
                                <input style="width:70px;display:none;" type="file" name="imgInput" id="imgInput' . $index . '" targetID="previewImg' . $index . '"" onchange="readURL(this)" accept="image/gif, image/jpeg, image/png" />';
                        if ($sqlArray['示意圖'] != null)
                            echo '<img id="previewImg" src="data:' . $sqlArray['圖片編碼格式'] . ';base64,' . $sqlArray['圖片'] . '" />';
                        else echo '
                                    <img id="previewImg' . $index . '" src="Image/carrot.png" />
                                    <br>
                                    <select name="organic" id="organic' . $index . '" disabled = "disabled" style="font-size:smaller;">
                                        <option value="' . $sqlArray['是否有機'] . '">' . organicStatus($sqlArray['是否有機']) . '</option>
                                        <option value="1">有機</option>
                                        <option value="0">非有機</option>
                                    </select>
                                </td>
                                <td width="245" bgcolor="#FFE153">
                                    <input type="hidden" name="CName" value="' . $sqlArray['名稱'] . '"></input>
                                    產品名稱:<b><input name="CName" id="CName' . $index . '"disabled = "disabled"  value="' . $sqlArray['名稱'] . '" style="width: 100px;" onkeydown="if(event.keyCode==13){return false;}"/></b>
                                </td>
                                <td bgcolor="#FFE153">
                                    <input type="hidden" name="cash" value="' . $sqlArray['價格'] . '"></input>
                                    販售價格:<b><input name="cash" id="cash' . $index . '"disabled = "disabled" value="' . $sqlArray['價格'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input> 元 / 
                                    <input name="base" id="base' . $index . '"disabled = "disabled" value="' . $sqlArray['單位'] . '" style="width: 30px;" onkeydown="if(event.keyCode==13){return false;}"></input></b>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    物種:<input name="item" id="item' . $index . '"disabled = "disabled" value="' . $sqlArray['物種'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                                <td>
                                    產地:<input name="origin" id="origin' . $index . '"disabled = "disabled" value="' . $sqlArray['產地'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    收成時間:<input name="time" id="time' . $index . '"disabled = "disabled" value="' . $sqlArray['收成時間'] . '" style="width: 100px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                                <td>
                                    剩餘數量:<input name="maxCount" id="maxCount' . $index . '" disabled = "disabled" value="' . $sqlArray['剩餘數量'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    可配送方式:<input name="transport" id="transport' . $index . '"disabled = "disabled" value="' . $sqlArray['願意配送方式'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                備註:<input name="remark" id="remark' . $index . '"disabled = "disabled" value="' . $sqlArray['產品註明'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>
                                </td>
                                <td colspan="1" align="right">
                                    <button type="button" name="fixedButton' . $index . '" id="fixedButton' . $index . '" onclick="if(!fixed(' . $index . ',' . true . ')){return false;}" font color="blue" align="center" ' . ($sqlArray['審核狀態'] == 0 ? 'disabled="disabled"' : "") . ' style=" font-size:16px; font-weight: bolder; background-color: #BEBEBE;">修改</button>
                                    <button type="submit" name="submitButton' . $index . '" id="submitButton' . $index . '"  font color="blue" align="center" style=" font-size:16px; font-weight: bolder; background-color: #53FF53;display:none;">提交修改</button>
                                </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
                <div class="option">
                ';
                        if ($sqlArray['審核狀態'] == 1)
                            echo '<input type="checkbox" class="orderCheckbox" onclick="showDelMathod(' . $sqlArray['產品編號'] . ')"  value="' . $index . '"/></div>';
                        else
                            echo '<div style="font-size:18px">審<br>核<br>中</div></div>';
                        echo '</div>';
                        $index++;
                        $CommodityIndex++;
                    }
                } else {
                    debug("Store Empty.");
                }
            } else if ($_GET["method"] == 2) {  //訂單資訊
                // echo $storeName;
                debug("2");
                $cmd = 'SELECT `訂單編號`, `訂購者帳號`, `訂單日期`, `販售者帳號`, `賣場編號`, `購買清單`, `訂單金額`, `配銷方式`, `訂單狀態` ,`消費者`.`連絡電話`
                FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE `賣場編號`="' . $store . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {

                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse;">
                            <form name="orderDetail" id="orderDetail" method="post" action="farmManagement.php?method=2">
                                <tbody>
                                    <tr>
                                        <td>
                                            訂購者帳號:' . $sqlArray['訂購者帳號'] . '
                                        </td>
                                        <td>
                                            訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
                                        </td>
                                        <td rowspan="2">
                                            <input type="hidden" name="orderIndex" value="' . $sqlArray['訂單編號'] . '" />
                                            <p style="text-align:center; width:50px; margin:auto auto auto auto;"><button class="detailButton" type="submit">詳<br>細<br>資<br>訊</button></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            訂單編號:' . $sqlArray['訂單編號'] . '
                                        </td>
                                        <td>
                                            訂單建立日期:' . $sqlArray['訂單日期'] . '
                                        </td>
            
                                    </tr>
                                    <tr>
                                        <td>
                                            購買者聯絡電話:' . $sqlArray['連絡電話'] . '
                                        </td>
                                        <td>
                                            訂單狀態:<span style="color:red">' . orderStatus($sqlArray['訂單狀態']) . '</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>';
                    }
                }
            }

            ?>

            <script>
                function fixed(index, status) {
                    var n = false;
                    var idStr = [
                        "CName",
                        "cash",
                        "item",
                        "origin",
                        "time",
                        "transport",
                        "maxCount",
                        "organic",
                        "remark",
                        "base",
                    ];
                    for (var i = 0; i < idStr.length; i++) {
                        if (idStr[i] == "imgInput") continue;
                        if (!document.getElementById(idStr[i] + index).disabled == "")
                            document.getElementById(idStr[i] + index).disabled = "";
                        else
                            document.getElementById(idStr[i] + index).disabled = "disabled";
                    }

                    if (document.getElementById("imgInput" + index).style.display == "") {
                        document.getElementById("imgInput" + index).style.display = "none";
                        // document.getElementById("organic" + index).style.display = "none";

                    } else {
                        document.getElementById("imgInput" + index).style.display = "";
                        // document.getElementById("organic" + index).style.display = "";


                    }
                    if (document.getElementById("submitButton" + index).style.display == "") {
                        document.getElementById("submitButton" + index).style.display = "none";
                    } else {
                        document.getElementById("submitButton" + index).style.display = "";
                    }
                    if (document.getElementById("fixedButton" + index).innerHTML == "修改") {
                        document.getElementById("fixedButton" + index).innerHTML = "取消修改";
                        // document.getElementById("fixedButton" + index).onclick = "if(!fixed(' . $index . ',' . false . ')){return false;}";
                    } else {
                        document.getElementById("fixedButton" + index).innerHTML = "修改";
                        document.location.href = document.location;

                    }
                }

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var imageTagID = input.getAttribute("targetID");
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var img = document.getElementById(imageTagID);
                            img.setAttribute("src", e.target.result)
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function orderJump(index) {
                    document.getElementById("orderDetail").submit();
                }
                var delList = [];

                function showDelMathod(index) {
                    if (delList.length == 0) {
                        document.getElementsByClassName('delCommodity')[0].style.display = "";
                    }
                    if (delList.indexOf(index) < 0)
                        delList.push(index);
                    else
                        delList.splice(delList.indexOf(index), 1);
                    if (delList.length == 0) {
                        document.getElementsByClassName('delCommodity')[0].style.display = "none";
                    }
                }

                function addNewCommodity(type, index) {
                    var form1 = document.createElement("form");
                    form1.id = "form1";
                    form1.name = "form1";
                    document.body.appendChild(form1);
                    input = document.createElement("input");
                    input.type = "hidden";
                    if (type == 1) {
                        input.name = "add";
                    } else {
                        input.name = "del";
                    }
                    input.value = 1;
                    form1.appendChild(input);
                    if (type == 1) {
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "storeIndex";
                        input.value = index;
                        form1.appendChild(input);
                    } else {
                        for (var i = 0; i < delList.length; i++) {
                            input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "productIndex" + i;
                            input.value = delList[i];
                            form1.appendChild(input);
                        }
                    }
                    input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "length";
                    input.value = delList.length;
                    form1.appendChild(input);
                    var btn = document.createElement("button");
                    btn.type = "submit";
                    btn.name = "submit";
                    form1.appendChild(btn);
                    form1.method = "post";
                    form1.action = "StoreProductFunctions.php";
                    btn.click();
                }
            </script>
        </div>
    </div>

</body>

</html>

<?php
// echo '<div style="display: flex;">
//                 <table class="StoreInfoTable" id="storeInfoTemplate" style="width:550px;';
// if ($sqlArray['審核狀態'] == 0) echo 'background-color: #ADADAD;';

// echo '">
//                 <form name="commodity" id="commodity' . $index . '" action="submitStoreFixedInfo.php" Enctype="multipart/form-data" method="post" align="center" style="margin:auto auto auto auto;">
//                     <input type="hidden" name="commodityIndex" value="' . $sqlArray['產品編號'] . '"></input>
//                     <tbody>
//                         <tr>
//                             <td rowspan="3" align="center" style="width: 100px; height:100px;">
//                             <input style="width:70px;display:none;" type="file" name="imgInput" id="imgInput' . $index . '" targetID="previewImg' . $index . '"" onchange="readURL(this)" accept="image/gif, image/jpeg, image/png" />';

// if ($sqlArray['示意圖'] != null)
//     echo '<img id="previewImg' . $index . '"src="data:' . $sqlArray['圖片編碼格式'] . ';base64,' . $sqlArray['示意圖'] . '" />';
// else
//     echo '<img id="previewImg' . $index . '"src="Image/carrot.png" />';
// echo '
//                             <select name="organic" id="organic' . $index . '" disabled = "disabled" style="font-size:smaller;">
//                                 <option value="1">有機</option>
//                                 <option value="0">非有機</option>
//                             </select>
//                             </td>
//                             <td rowspan="3">
//                                 <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
//                             </td>
//                             <td rowspan="3" id="sql">
//                                 <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
//                                     <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">

//                                         <td style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">
//                                             品名：<input name="CName" id="CName' . $index . '"disabled = "disabled"  value="' . $sqlArray['名稱'] . '" style="width: 100px;" onkeydown="if(event.keyCode==13){return false;}"/></td>

//                                         <td style="width:120px;"><input name="cash" id="cash' . $index . '"disabled = "disabled" value="' . $sqlArray['價格'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>元</td>
//                                     </tr>
//                                     <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
//                                         <td style="border: 3px solid #000000; border-left:0px;">配銷地點：<input name="location" id="location' . $index . '" disabled = "disabled" value="' . $sqlArray['願意配銷地點'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></td>
//                                         <td >運送方式：<input name="transport" id="transport' . $index . '" disabled = "disabled"value="' . $sqlArray['配銷方式'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
//                                     </tr>
//                                     <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
//                                         <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">
//                                             剩餘數量：<input name="maxCount" id="maxCount' . $index . '" disabled = "disabled" value="' . $sqlArray['剩餘數量'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
//                                         <td></td>
//                                     </tr>
//                                 </table>
//                             </td>

//                             <td rowspan="3">
//                                 <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
//                             </td>
//                             <td align="center" style="right:0px; position: relative; width: 180px; font-size:24px; font-weight: bolder; ">';
// if ($sqlArray['審核狀態'] == 1)
//     echo '<button type="button" name="fixedButton' . $index . '" id="fixedButton' . $index . '" onclick="if(!fixed(' . $index . ',' . true . ')){return false;}" font color="blue" align="center" style=" font-size:16px; font-weight: bolder; background-color: #BEBEBE;">修<br>改</button>
//                                 <button type="submit" name="submitButton' . $index . '" id="submitButton' . $index . '"  font color="blue" align="center" style=" font-size:16px; font-weight: bolder; background-color: #53FF53;display:none;">提<br>交<br>修<br>改</button>';
// else
//     echo '<div id="fixedButton' . $index . '"  align="center" style="color:#EEEEEE; font-size:24px; font-weight: bolder; ">審<br>核<br>中</div>';

// echo '</td>
//                         </tr>
//                     </tbody>
//                 </form>
//             </table>
//             <div class="option">
//             <input type="checkbox" class="orderCheckbox" onclick="showDelMathod(' . $sqlArray['產品編號'] . ')"  value="' . $index . '"/>
//             </div>
//             </div>';

?>