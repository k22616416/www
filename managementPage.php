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

//$order = $_GET['orderIndex'];

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
            <button type="button" onclick="Javascript:document.location.href='managementPage.php?method=1'" style="position: absolute; top:36px;left:210px; background-color:RGBA(255,0,0,1);">回功能首頁</button>
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

                #orderDetail {
                    height: 70px;
                    width: 240px;
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
                            <?php if ($_POST["orderIndex"] != null)
                                echo '<td rowspan="2"><button class="ManagementMethodDiv" id="orderDetail" type="submit" name="method" value="7" style="<?php if ($_GET[\'method\'] == 7 && $_POST["orderIndex"] != null) echo "background-color:rgba(255, 255, 0, 0.9);" ?>">訂單:</button></td>';
                            ?>

                        </tr>
                        <tr>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="4" <?php if ($_GET['method'] == 4 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>農場商品設定</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="5" <?php if ($_GET['method'] == 5 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>會員申請清單</button></td>
                            <td><button class="ManagementMethodDiv" type="submit" name="method" value="6" <?php if ($_GET['method'] == 6 && $_POST["orderIndex"] == null) echo "style=\"background-color:rgba(255, 255, 0, 0.9);\"" ?>>匯出功能</button></td>

                        </tr>
                    </form>
                </table>

            </div>
            <hr class="TopHr" />
            <style>
                .storeMethodDiv,
                .orderMethodDiv,
                .productMethodDiv {
                    width: 200px;
                    height: auto;
                    position: absolute;
                    top: 105%;
                    right: 0px;
                    background-color: rgba(255, 255, 255, 0.7);
                    padding: 2 auto auto auto;

                    /* display: inline-block; */
                }

                .methodButton {
                    margin: 3 3 3 3;
                }

                .passButton {
                    background-color: #00FF00;
                    width: 80px;

                }

                .passButton:hover {
                    background-color: #00DD00;
                }

                .blockButton {
                    background-color: #FF0000;
                    width: 80px;
                    position: relative;
                }

                .blockButton:hover {
                    background-color: #DD0000;
                }
            </style>
            <div class="storeMethodDiv" id="storeMethodDiv" style="display: none;">
                <p>賣場編號</p>
                <input type="hidden" value="123" />
                <button>關閉此賣場</button><br>
                <button>查看此小農的個人資訊</button><br>
                <button>封鎖此小農</button><br>
            </div>
            <div class="orderMethodDiv" id="orderMethodDiv" style="display: none;">
                <p>選取的訂單編號:</p>
                <input type="hidden" value="123" />
                <button onclick="orderListBatch(1)">全部通過</button><button onclick="orderListBatch(2)">全部拒絕</button><br>
                <!--預估做法：
                    1.動態生成許多hidden input 把訂單清單個別埋在裡面 
                    然後建表單送到另一個php內處理
                -->
                <script>
                    function passBatch() {
                        var div = document.getElementById("orderMethodDiv");
                        div.childNodes[1].innerHTML = '賣場編號:' + store;
                        //0617 00:20:要取得已勾選的訂單的編號items


                        var orderList = document.getElementsByClassName("StoreInfoTable");
                        var form1 = document.createElement("form");
                        form1.id = "form1";
                        form1.name = "form1";
                        document.body.appendChild(form1);
                        var input;

                        for (var i = 0; i < orderList.length; i++) {
                            if (document.getElementsByClassName("orderStatus" + i)[0].checked) {
                                input = document.createElement("input");
                                input.type = "hidden";
                                input.name = "method";
                                input.value = document.getElementsByClassName("orderIndex" + i)[0].value;
                                form1.appendChild(input);
                            }

                        }
                    }
                </script>

            </div>
            <div class="productMethodDiv" id="productMethodDiv" style="display: none;">
                <button class="methodButton" onclick="productMethodFunction(0)">儲存已勾選項目</button><br>
                <button class="methodButton" onclick="productMethodFunction(1)">重置已勾選項目</button><br>
                <button class="methodButton" onclick="productMethodFunction(2)">刪除已勾選項目</button><br>
            </div>

        </div>
        <style>

        </style>
        <!--透過SQL增加商品資訊-->
        <div class="mainDiv">

            <?php
            include_once("layoutFunction.php");
            if ($_POST["orderIndex"] != null) { //訂單詳細
                $cmd = 'SELECT * FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE `訂單編號`="' . $_POST["orderIndex"] . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    $orderInfo = "";
                    while (($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) != null) {
                        orderDetailLayout($sqlArray);
                        echo '<script>
                            document.getElementById("orderDetail").innerHTML = "訂單編號<br>\"' . $_POST["orderIndex"] . '\"";
                            document.getElementById("orderDetail").style="background-color:rgba(255, 255, 0, 0.9);";
                            </script>';
                        $orderInfo = json_decode($sqlArray['購買清單']);
                    }
                    echo '';
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
                    echo '</tbody>
                    </table>
                    <form name="orderDetail" id="orderDetail" method="post" action="managementPage.php?method=2">
                        <button type="submit" name="method" value="2" style="width:150px; margin: 20px 10px auto 10px;">返回訂單清單</button>
                    </form>';
                }
            } else if ($_GET["method"] == 1) {  //小農清單
                $cmd = 'SELECT *
                        FROM `小農` INNER JOIN `個人賣場2` ON `小農`.`賣場編號`=`個人賣場2`.`賣場編號`
                        GROUP BY `個人賣場2`.`賣場編號`;';
                $index = 0;
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        ManagementStoreInfoLayout($sqlArray);
                    }
                }
            } else if ($_GET["method"] == 2) {  //訂單清單


                $cmd = 'SELECT *
                FROM `訂單` INNER JOIN `消費者`
                ON `訂單`.`訂購者帳號` = `消費者`.`使用者帳號`
                WHERE 訂單狀態 = "0" ;';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {

                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        orderList($sqlArray);
                    }
                }
            } else if ($_GET["method"] == 3) {  //農產上架審核
                $cmd = 'SELECT * 
                FROM (`產品資訊` INNER JOIN `個人賣場2`
                ON `產品資訊`.`產品編號` = `個人賣場2`.`產品編號`) INNER JOIN `小農`
                ON `個人賣場2`.`賣場編號` = `小農`.`賣場編號`
                WHERE `審核狀態`="0";';
                $index = 0;
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        checkListLayout($sqlArray);
                    }
                }
            } else if ($_GET["method"] == 4) {   //農場產品設定
                checkAddProduct($conn);
                DeleteProduct($conn);
                ProductsLayout1();
                $cmd = 'SELECT * FROM `農產品` WHERE 1 ;';
                $index = 0;
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        ProductsLayout2($sqlArray);
                    }
                }
                ProductsLayout3();
            } else if ($_GET["method"] == 5) {  //小農申請清單
                $cmd = 'SELECT * FROM `註冊審核` WHERE `審核狀態` = 0;';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        registeredLayout($sqlArray);
                    }
                }
            } else if ($_GET["method"] == 6) {   //匯出功能
            }

            ?>



            <!--  -->



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

                function goHome() {
                    document.location.href = "index.php";
                }
                var oldcheck;

                function storeMethod(obj, store) {
                    if (obj.checked) {
                        if (oldcheck != obj && oldcheck != null)
                            oldcheck.checked = false;
                        console.log("on");
                        var div = document.getElementById("storeMethodDiv");
                        // console.log(div.childNodes[1]);
                        div.childNodes[1].innerHTML = '賣場編號:' + store;
                        div.style.display = "";
                        oldcheck = obj;
                    } else {
                        var div = document.getElementById("storeMethodDiv");
                        div.childNodes[1].innerHTML = '賣場編號:' + store;
                        div.style.display = "none";
                    }

                }
                var checkStatus = "";
                var orderList = [];

                function orderMethod(obj) {
                    if (obj.checked) {
                        console.log(obj.value);
                        orderList.push(obj.value);
                        // checkStatus.push(obj);
                    }
                    // if (checkStatus.length != 0) {
                    //     var div = document.getElementById("orderMethodDiv");
                    //     var str = "";

                    //     for (var i = 0; i = checkStatus.length; i++) {
                    //         str += "<br>" + checkStatus[i].value;
                    //     }
                    //     div.childNodes[1].innerHTML = '選取的訂單:<br>' + str;
                    //     div.style.display = "";
                    //     // document.getElementsByClassName("orderMethod");
                    // }
                    var div = document.getElementById("orderMethodDiv");
                    if (obj.checked) {
                        checkStatus += "\n" + obj.value;
                        div.childNodes[1].innerHTML = '選取的訂單:<br>' + checkStatus;
                        div.style.display = "";
                    } else {
                        checkStatus.replace("\n\"" + obj.value + "\"", "");
                        div.childNodes[1].innerHTML = '選取的訂單:<br>' + checkStatus;
                    }
                    if (checkStatus == "") {
                        div.style.display = "none";
                        div.childNodes[1].innerHTML = '選取的訂單:';
                    }


                    // else {
                    //     div.style.display = "none";
                    // }

                }

                function orderListBatch(status) {
                    if (orderList.length < 0)
                        return;
                    var form1 = document.createElement("form");
                    form1.id = "form1";
                    form1.name = "form1";
                    document.body.appendChild(form1);
                    var input;
                    for (var i = 0; i < orderList.length; i++) {
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "orderIndex" + i;
                        input.value = orderList[i];
                        form1.appendChild(input);
                    }

                    input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "orderLength";
                    input.value = orderList.length;
                    form1.appendChild(input);

                    var btn = document.createElement("button");
                    btn.type = "submit";
                    if (status == 1)
                        btn.name = "statusSubmit"
                    else
                        btn.name = "block"
                    form1.appendChild(btn);
                    form1.method = "post";
                    form1.action = "orderOperationg.php";
                    btn.click();
                }

                function productMethod(n, ckobj = null) {
                    document.getElementsByClassName("productMethodDiv")[0].style.display = "";
                    //抓product值 存cookie
                    var obj = [];
                    obj.push(document.getElementsByName("productName" + n)[0]);
                    obj.push(document.getElementsByName("productCash" + n)[0]);
                    obj.push(document.getElementsByName("productSelect" + n)[0]);
                    var str = "productIndex" + ":" + n + "," +
                        obj[0].name + ":" + obj[0].value + "," +
                        obj[1].name + ":" + obj[1].value + "," +
                        obj[2].name + ":" + obj[2].checked + ";";
                    // console.log(obj[2].checked);
                    document.cookie = "productIndex" + n + "=" + str;
                    document.getElementsByName("trbg" + n)[0].style.backgroundColor = "#4DFFFF";
                }

                function chechkProductInfo() {
                    var cookieStr = document.cookie;
                    var productInfo = cookieStr.split(';');

                    for (var i = 0; i < productInfo.length; i++) {
                        if (productInfo[i].indexOf("productIndex") == -1) continue;
                        console.log("check " + i);
                        var tmp = productInfo[i].split(",");
                        // console.log(tmp);
                        var n = tmp[0].substring(tmp[0].indexOf(":") + 1, tmp[0].length);
                        var val = tmp[1].substring(tmp[1].indexOf(":") + 1, tmp[1].length);
                        // console.log(n);
                        document.getElementsByName("productName" + n)[0].value = val;

                        var val = tmp[2].substring(tmp[2].indexOf(":") + 1, tmp[2].length);
                        // console.log(val);
                        document.getElementsByName("productCash" + n)[0].value = val;

                        var val = tmp[3].substring(tmp[3].indexOf(":") + 1, tmp[3].length);
                        document.getElementsByName("productSelect" + n)[0].checked = (val == "true" ? true : false);
                        console.log(val);
                        document.getElementsByName("trbg" + n)[0].style.backgroundColor = "#4DFFFF";

                        // console.log(n);
                        document.getElementsByClassName("productMethodDiv")[0].style.display = "";

                    }
                }

                function addProduct(n) {
                    var form1 = document.createElement('form');
                    form1.name = "tempForm";
                    document.body.appendChild(form1);
                    var input2 = document.createElement("button");
                    input2.type = "hidden";
                    input2.name = "addProduct";
                    input2.value = "1";
                    form1.appendChild(input2);
                    form1.method = "post";
                    form1.action = "managementPage.php?method=4";
                    input2.click();

                }

                function deleteProduct(n) {
                    var form1 = document.createElement('form');
                    form1.name = "tempForm";
                    document.body.appendChild(form1);
                    var input2 = document.createElement("button");
                    input2.type = "hidden";
                    input2.name = "deleteProduct";
                    input2.value = n;
                    form1.appendChild(input2);
                    form1.method = "post";
                    form1.action = "managementPage.php?method=4";
                    input2.click();
                }

                function productMethodFunction(f) {
                    var cookieStr = document.cookie;
                    var productInfo = cookieStr.split(';');
                    if (f == 0) {
                        var form1 = document.createElement("form");
                        form1.id = "form1";
                        form1.name = "form1";
                        document.body.appendChild(form1);
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "method";
                        input.value = f;
                        form1.appendChild(input);
                        var input;
                        var item = [];

                        for (var i = 0; i < productInfo.length; i++) {
                            if (productInfo[i].indexOf("productIndex") == -1) continue;
                            var tmp = productInfo[i].split(",");

                            var n = tmp[0].substring(tmp[0].indexOf(":") + 1, tmp[0].length);
                            input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "productIndex";
                            input.value = n;
                            form1.appendChild(input);

                            var val = tmp[1].substring(tmp[1].indexOf(":") + 1, tmp[1].length);
                            input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "productName" + n;
                            input.value = val;
                            form1.appendChild(input);

                            var val = tmp[2].substring(tmp[2].indexOf(":") + 1, tmp[2].length);
                            input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "productCash" + n;
                            input.value = val;
                            form1.appendChild(input);

                            var val = tmp[3].substring(tmp[3].indexOf(":") + 1, tmp[3].length);
                            input = document.createElement("input");
                            input.type = "hidden";
                            input.name = "productSelect" + n;
                            input.value = val;
                            form1.appendChild(input);
                            item.push(n);


                            if (val == "true") {
                                document.cookie = "productIndex" + n + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                                document.getElementsByName("productSelect" + n)[0].checked = false;
                            } else {

                            }

                        }
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "productItem";
                        input.value = item;
                        form1.appendChild(input);

                        var button = document.createElement("button");
                        button.type = "submit";
                        button.name = "fixed";
                        form1.appendChild(button);
                        form1.method = "post";
                        form1.action = "fixProduct.php";
                        button.click();
                    } else if (f == 1) {
                        for (var i = 0; i < productInfo.length; i++) {
                            // console.log("1");
                            if (productInfo[i].indexOf("productIndex") == -1)
                                continue;
                            var tmp = productInfo[i].split(",");
                            var n = tmp[0].substring(tmp[0].indexOf(":") + 1, tmp[0].length);
                            var val = tmp[3].substring(tmp[3].indexOf(":") + 1, tmp[3].length);
                            if (val == "true") {
                                document.cookie = "productIndex" + n + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                                console.log("clear " + n);
                                document.getElementsByName("productSelect" + n)[0].checked = false;
                                document.getElementsByName("trbg" + n)[0].style.backgroundColor = "";
                            }
                        }
                        document.location.href = document.location;

                    } else if (f == 2) {
                        var form1 = document.createElement("form");
                        form1.id = "form1";
                        form1.name = "form1";
                        document.body.appendChild(form1);
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "method";
                        input.value = f;
                        form1.appendChild(input);
                        var input;
                        var item = [];
                        for (var i = 0; i < productInfo.length; i++) {
                            if (productInfo[i].indexOf("productIndex") == -1) continue;
                            var tmp = productInfo[i].split(",");
                            var n = tmp[0].substring(tmp[0].indexOf(":") + 1, tmp[0].length);
                            var val = tmp[3].substring(tmp[3].indexOf(":") + 1, tmp[3].length);
                            if (val == "true") {
                                document.cookie = "productIndex" + n + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                                document.getElementsByName("productSelect" + n)[0].checked = false;
                                item.push(n);
                            } else {

                            }
                        }
                        input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "productItem";
                        input.value = item;
                        form1.appendChild(input);

                        var button = document.createElement("button");
                        button.type = "submit";
                        button.name = "fixed";
                        form1.appendChild(button);
                        form1.method = "post";
                        form1.action = "fixProduct.php";
                        button.click();
                    }


                }


                chechkProductInfo();
            </script>
        </div>
    </div>

</body>

</html>