<?php

use function PHPSTORM_META\type;

session_start();
$_SESSION['root'] = 1;  /////////////////////for test

function checkRoot()
{
    return $_SESSION['root'];
}
?>
<link href="style.css" rel="stylesheet" type="text/css">

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

$titleStr = '小農線上市集媒合系統';

include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}

// if (isset($_POST['enterStore'])) {

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
// if (!checkRoot()) {
//     echo '<script>document.location.href="index.php"</script>';
// } else
//     echo '測試模式';
//}



error_reporting(0);



?>
<!-- 判斷有沒有登入 -->
<?php
if (isset($_POST['logout'])) {
    unset($_POST['logout']);
    unset($_SESSION['user']);
    unset($_SESSION['name']);
    unset($_SESSION['member']);
    echo '<script>document.location.href="index.php"</script>';
} else if ($_SESSION['user'] != null) {
    $loginStatus = true;
    $loginMember = $_SESSION['member'];
    $infoName = $_SESSION['name'];
    $userName = $_SESSION['user'];
    // $farmStoreNumber = $_SESSION['farmStoreNumber'];
    $errorCode = 0;
}

if ($errorCode != 0 || $loginMember != 3) {

    if (!checkRoot()) {
        echo '<script>alert("取得資訊時發生錯誤，將返回首頁\n' . $store . '");</script>';
        echo '<script>document.location.href="index.php"</script>';
    } else
        echo '<script>console.log("測試模式");</script>';
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
            <div class="titleDiv" id="sql">管理者功能頁</div>
            <div class="WebNameDiv" onclick=goHome()>
                小農<br>
                線上市集<br>
            </div>
            <button type="button" onclick="Javascript:document.location.href='managementPage.php?method=1'" style="position: absolute; top:36px;left:210px; background-color:RGBA(255,0,0,0.60);">回功能首頁</button>
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

                        // if ($loginMember == 2) //小農身分
                        // {
                        //     echo '<tr >';
                        //     echo '<form method="post" action="storePage.php">';
                        //     echo '<td colspan=2><button class="RegisterButton" name="fixed" type="submit">修改個人資料</button></td>';
                        //     echo '</form>';
                        //     echo '</tr>';
                        //     echo '<tr >';
                        //     echo '<form method="post" action="storePage.php">';
                        //     echo '<input type="hidden" name="storeNumber" value="' . $farmStoreNumber . '">';
                        //     echo '<td colspan=2><button class="RegisterButton" name="enterStore" type="submit">進入個人賣場</button></td>';
                        //     echo '</form>';
                        //     echo '</tr>';
                        //     echo '<tr >';
                        //     echo '<form method="post" action="farmManagement.php?method=1">';
                        //     echo '<input type="hidden" name="user" value="' . $userName . '">';
                        //     echo '<td colspan=2><button class="RegisterButton" name="enterStore" >進入農場管理頁面</button></td>';
                        //     echo '</form>';
                        //     echo '</tr>';
                        // } else if ($loginMember == 1) //消費者身分
                        // {
                        //     echo '<tr>';
                        //     echo '<td colspan="2"><button class="RegisterButton" name="logout" type="submit">修改個人資料</button></td>';
                        //     echo '</tr>';
                        // }
                        ?>
                    </tbody>

                </table>

            </div>
            <!-- 未登入 轉跳 -->

            <style>
                .methodTable {
                    height: 70px;
                    width: auto;
                    border-collapse: collapse;
                    margin: 1px 1px 1px 1px;
                }

                .managementMethodDiv {
                    height: 35px;
                    width: 120px;
                }
            </style>
            <div class=" TopDiv">
                <table class="methodTable">
                    <form action="managementPage.php" method="get">
                        <tr>
                            <!--分割線上方Div-->
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="1" <?php if ($_GET['method'] == 1 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>小農清單</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="2" <?php if ($_GET['method'] == 2 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>訂單清單</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="3" <?php if ($_GET['method'] == 3 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>農產上架審核</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" id="orderDetail" style="display:none" ?>>訂單""</button></td>
                        </tr>
                        <tr>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="4" <?php if ($_GET['method'] == 4 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>農場商品設定</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="5" <?php if ($_GET['method'] == 5 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>小農申請清單</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="6" <?php if ($_GET['method'] == 6 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>匯出功能</button></td>
                        </tr>
                    </form>
                </table>
            </div>
            <hr class="TopHr" />

        </div>
        <style>
            .farmMethodItem {
                background-color: #FFFFFF;
                width: 100px;
                height: auto;
                position: absolute;
                top: 10px;
                right: -125px;
                padding: 5 5 5 5;
                border: 1px solid #000000;
            }

            .addCommodity {
                background-color: rgba(0, 255, 0, 0.7);

            }

            .addCommodity:hover {
                background-color: rgba(0, 200, 0, 0.7);
            }

            .addCommodity:active {
                background-color: rgba(0, 255, 0, 0.7);
            }

            .entryStoreButton {
                width: 100px;
                margin: auto auto auto auto;
            }

            .storeCheckbox {
                width: 20px;
                height: 20px;

            }

            .option {
                position: relative;
                top: 40px;

            }
        </style>
        <!--透過SQL增加商品資訊-->
        <div class="mainDiv">
            <div style="display: flex;">

                <table class="StoreInfoTable" rules="all" id="storeInfoTemplate" style="width:550px;">
                    <input type="hidden" name="storeNumber" value="2">
                    <form id="entryStore' . $i . '" method="post" action="storePage.php">
                        <tbody>
                            <tr>
                                <td rowspan="2" style="width:70px;"><img src="image/user.png" /><button class="StoreHrefText">進入此賣場</button></td>
                                <td colspan="2" style="width:auto;">使用者帳號：<b>123</b></td>
                                <td style="width:100px;"><span style="font-size:14px;">瀏覽次數：<br>0</span></td>
                                <td style="width:100px;"><span style="font-size:14px;">已成交訂單數：<br>0</span></td>
                            </tr>
                            <tr>
                                <td colspan="3">農場簡介：</td>
                                <td><button class="entryStoreButton" onclick="if(!storeOrderInfo(1)){return false;}">查看該賣場<br>訂單資訊</button></td>
                            </tr>
                        </tbody>
                    </form>
                </table>

                <div class="option">
                    <input type="checkbox" class="storeCheckbox" value="1" onchange="" />
                </div>

            </div>
            <?php
            if ($_POST["orderIndex"] != null) {
                // echo $_POST["orderIndex"];
                $cmd = 'SELECT * FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE `訂單編號`="' . $_POST["orderIndex"] . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    $orderInfo = "";
                    while (($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) != null) {
                        echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse; ">
                            <form name="orderDetail" id="orderDetail" method="post" action="farmManagement.php?method=2">
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
                                            訂單狀態:<span style="color:red">' . $sqlArray['訂單狀態'] . '</span>
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
                $cmd = 'SELECT `名稱`,`價格`,`願意配銷地點`,`配銷方式`,`剩餘數量`,`產品資訊`.`產品編號`,`產品資訊`.`是否有機`,`產品資訊`.`審核狀態`,`產品資訊`.`示意圖`,`產品資訊`.`圖片編碼格式`
                        FROM (`小農` INNER JOIN `個人賣場2` ON `小農`.`賣場編號`=`個人賣場2`.`賣場編號`)
                        INNER JOIN `產品資訊` ON `個人賣場2`.`產品編號`=`產品資訊`.`產品編號`
                        WHERE `小農`.`賣場編號`="' . $store . '";';
                $index = 0;
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        echo '
                <table class="StoreInfoTable" id="storeInfoTemplate"';
                        if ($sqlArray['審核狀態'] == 0) echo 'style="background-color: #ADADAD;"';
                        echo '>
                <form name="commodity" id="commodity' . $index . '" action="submitStoreFixedInfo.php" Enctype="multipart/form-data" method="post" align="center" style="margin:auto auto auto auto;">
                    <input type="hidden" name="commodityIndex" value="' . $sqlArray['產品編號'] . '"></input>
                    <tbody>
                        <tr>
                            <td rowspan="3" align="center" style="width: 100px; height:100px;">
                            <input style="width:70px;display:none;" type="file" name="imgInput" id="imgInput' . $index . '" targetID="previewImg' . $index . '"" onchange="readURL(this)" accept="image/gif, image/jpeg, image/png" />';

                        if ($sqlArray['示意圖'] != null)
                            echo '<img id="previewImg' . $index . '"src="data:' . $sqlArray['圖片編碼格式'] . ';base64,' . $sqlArray['示意圖'] . '" />';
                        else
                            echo '<img id="previewImg' . $index . '"src="Image/carrot.png" />';
                        echo '
                            <select name="organic" id="organic' . $index . '" disabled = "disabled" style="font-size:smaller;">
                                <option value="1">有機</option>
                                <option value="0">非有機</option>
                            </select>
                            </td>
                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td rowspan="3" id="sql">
                                <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
                                    <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">

                                        <td style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">
                                            品名：<input name="CName" id="CName' . $index . '"disabled = "disabled"  value="' . $sqlArray['名稱'] . '" style="width: 100px;" onkeydown="if(event.keyCode==13){return false;}"/></td>

                                        <td><input name="cash" id="cash' . $index . '"disabled = "disabled" value="' . $sqlArray['價格'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>元/把</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px;">配銷地點：<input name="location" id="location' . $index . '" disabled = "disabled" value="' . $sqlArray['願意配銷地點'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></td>
                                        <td>運送方式：<input name="transport" id="transport' . $index . '" disabled = "disabled"value="' . $sqlArray['配銷方式'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">
                                            剩餘數量：<input name="maxCount" id="maxCount' . $index . '" disabled = "disabled" value="' . $sqlArray['剩餘數量'] . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>

                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder; ">';
                        if ($sqlArray['審核狀態'] == 1)
                            echo '<button type="button" name="fixedButton' . $index . '" id="fixedButton' . $index . '" onclick="if(!fixed(' . $index . ',' . true . ')){return false;}" font color="blue" align="center" style=" font-size:16px; font-weight: bolder; background-color: #BEBEBE;">修<br>改</button>
                                <button type="submit" name="submitButton' . $index . '" id="submitButton' . $index . '"  font color="blue" align="center" style=" font-size:16px; width:40px;font-weight: bolder; background-color: #53FF53;display:none;">提交修改</button>';
                        else
                            echo '<div id="fixedButton' . $index . '"  align="center" style="color:#EEEEEE; font-size:24px; font-weight: bolder; ">審<br>核<br>中</div>';

                        echo '</td>
                        </tr>
                    </tbody>
                </form>
            </table>';

                        $index++;
                        $CommodityIndex++;
                    }
                }
            } else if ($_GET["method"] == 2) {  //訂單資訊
                // echo $storeName;
                $cmd = 'SELECT `訂單編號`, `訂購者帳號`, `訂單日期`, `販售者帳號`, `賣場編號`, `購買清單`, `訂單金額`, `配銷方式`, `訂單狀態` ,`消費者`.`連絡電話`
                FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE `賣場編號`="' . $store . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {

                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse; ">
                            <form name="orderDetail" id="orderDetail" method="post" action="farmManagement.php?method=2">
                                <tbody>
                                    <tr>
                                        <td>
                                            訂購者帳號:' . $sqlArray['訂購者帳號'] . '
                                        </td>
                                        <td>
                                            訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
                                        </td>
                                        <td rowspan="3">
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
                                            訂單狀態:<span style="color:red">' . $sqlArray['訂單狀態'] . '</span>
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
                        "location",
                        "transport",
                        "maxCount",
                        "organic"
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
                    if (document.getElementById("fixedButton" + index).innerHTML == "修<br>改") {
                        document.getElementById("fixedButton" + index).innerHTML = "取<br>消<br>修<br>改";
                        // document.getElementById("fixedButton" + index).onclick = "if(!fixed(' . $index . ',' . false . ')){return false;}";
                    } else {
                        document.getElementById("fixedButton" + index).innerHTML = "修<br>改";

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


                function addNewCommodity() {
                    var template = document.getElementById('storeInfoTemplate');
                    var clone = template.cloneNode(true); // "deep" clone

                    clone.id = "storeInfoDiv" + <?php echo $CommodityIndex; ?>; // there can only be one element with an ID
                    <?php echo $CommodityIndex++; ?>;
                    console.log("clone");
                    template.parentNode.appendChild(clone);
                    // clone.style.display = "block";

                }
            </script>
        </div>
    </div>
</body>

</html>

<script>
    function goHome() {
        document.location.href = "index.php";
    }

    function storeOrderInfo(store) {
        console.log(store);
    }
</script>