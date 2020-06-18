<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
    die("資料庫連線失敗");
}

// if (isset($_POST['storeNumber'])) {
//     $store = $_POST['storeNumber'];
//     $_SESSION['storeNumber'] = $store;
// } else if ($_SESSION['storeNumber'] != null) {
//     $store = $_SESSION['storeNumber'];
// } else if (isset($_POST['enterStore'])) {
//     // echo '<script>alert("1");</script>';
//     $userName = $_POST['storeNumber'];
//     $cmd = "SELECT * FROM `小農` WHERE `使用者帳號`= '" . $userName . "';";
//     $sqlData = mysqli_query($conn, $cmd);
//     if ($sqlData->num_rows > 0) {
//         $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
//         $store = $sqlArray['賣場編號'];
//         $storeName = $sqlArray['使用者帳號'];
//     }
// } else {
//     echo '<script>alert("取得賣場編號失敗");</script>';
//     // echo "取得賣場編號失敗";
//     sleep(2);
//     echo '<script>document.location.href="index.php"</script>';
//     exit;
// }




$loginStatus = false;
$loginMember = 0;
$infoName = '';
$errorCode = 0;
$storeName = '';
$storeInfo = '';
$storeOrder = 0;
$storeBrowse = 0;

error_reporting(0);

if (isset($_POST['farmIndex'])) {
    $farmIndex = $_POST['farmIndex'];
    $_SESSION['orderUser'] = $farmIndex;
} else if ($_SESSION['orderUser'] != null) {
    $farmIndex = $_SESSION['orderUser'];
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
    echo '<script>document.location.href="storePage.php"</script>';
} else if ($_SESSION['user'] != null) {
    $loginStatus = true;
    $loginMember = $_SESSION['member'];
    $infoName = $_SESSION['name'];
    $userName = $_SESSION['user'];
    $farmStoreNumber = $_SESSION['farmStoreNumber'];
    $errorCode = 0;
} else {


    if (isset($_POST['memberSubmit'])) {
        if (empty($_POST['user']) || empty($_POST['password'])) {
            $errorCode = 1;
        } else {
            $userName = $_POST['user'];
            $passwd = $_POST['password'];
            //$task = $_POST['newTask'];

            $cmd = "SELECT * FROM `消費者` WHERE `使用者帳號`= '" . $userName . "' AND `使用者密碼`='" . $passwd . "';";
            //echo $cmd;
            $sqlData = mysqli_query($conn, $cmd);
            if (mysqli_num_rows($sqlData) > 0) {
                // mysqli_num_rows($sqlData) > 0;
                $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
                $loginStatus = true;
                $loginMember = 1;
                $infoName = $sqlArray['姓名'];
                $_SESSION['user'] = $userName;
                $_SESSION['name'] = $sqlArray['姓名'];
                $_SESSION['member'] = $loginMember;
                $errorCode = 0;
            } else {
                //echo "0筆資料";
                $errorCode = 2;
            }

            // mysqli_close($conn);
            unset($_POST['user']);
            unset($_POST['password']);
        }
    }
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
}

// 點擊數

$cmd = 'UPDATE `小農` SET `瀏覽次數`= `瀏覽次數`+1 WHERE `賣場編號`="' . $store . '";';
SqlCommit($conn, $cmd);

// topDiv info
$cmd = "SELECT * FROM `小農` WHERE `賣場編號`= '" . $store . "'";
$sqlData = mysqli_query($conn, $cmd);
if ($sqlData->num_rows > 0) {
    $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
    $storeInfo = $sqlArray['賣場簡介'];
    $storeOrder = $sqlArray['交易訂單數'];
    $storeBrowse = $sqlArray['瀏覽次數'];
    $storeName = $sqlArray['使用者帳號'];
} else {
    echo '<script>alert("取得賣場資訊時發生錯誤，將返回首頁\n' . $store . '");</script>';
    // echo '取得賣場資訊時發生錯誤，將返回首頁';
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}



?>
<!-- <script>
    var shopCarCount = 0;
</script> -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title id="sql">
        訂單查看頁面
    </title>
</head>

<body>

    <div class="WebLayout">
        <div class="topArea">
            <div class="titleDiv" id="sql">訂單查看頁面</div>
            <div class="WebNameDiv" onclick=goHome()>
                小農<br>
                線上市集<br>
            </div>

            <button type="button" onclick="goHome()" style="position: absolute; top:36px;left:210px; background-color:RGBA(255,0,0,0.60);">回賣場首頁</button>
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
                            echo '<tr >';
                            echo '<form method="post" action="storePage.php">';
                            echo '<td colspan=2><button class="RegisterButton" name="fixed" type="submit">修改個人資料</button></td>';
                            echo '</form>';
                            echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="storePage.php">';
                            echo '<input type="hidden" name="storeNumber" value="' . $farmStoreNumber . '">';
                            echo '<td colspan=2><button class="RegisterButton" name="enterStore" type="submit">進入個人賣場</button></td>';
                            echo '</form>';
                            echo '</tr>';
                            echo '<tr >';
                            echo '<form method="post" action="farmManagement.php?method=1">';
                            echo '<input type="hidden" name="farmIndex" value="' . $userName . '">';
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

                <!-- 未登入 -->


                <table class="loginTable" cellpadding="0" <?php if ($loginStatus) echo 'style="display:none;"'; ?>>
                    <form id="login" class="title-add" method="post" action="storePage.php">
                        <tbody>
                            <tr>
                                <td><input type="text" class="inputText" placeholder="帳號" name="user"></td>
                                <td><button name="memberSubmit" type="submit" class="LoginButton" style="background-color: #C4E1FF;">會員登入</button></td>
                            </tr>
                            <tr>
                                <td><input type="password" class="inputText" placeholder="密碼" name="password"></td>
                                <td><button name="farmerSubmit" type="submit" class="LoginButton" style="background-color: #FFD306;">小農登入</button></td>
                            </tr>
                        </tbody>
                    </form>
                </table>
                <script>
                    function goRegister() {
                        document.location.href = "registerPage.php";
                    }
                </script>
                <button onclick=goRegister() type="button" class="RegisterButton" <?php if ($loginStatus) echo 'style="display:none;"'; ?>>
                    註冊成為新的小農或會員
                </button>
                <div class="LoginErrorDiv">
                    <?php
                    if (isset($_POST['memberSubmit']) || isset($_POST['farmerSubmit'])) {
                        switch ($errorCode) {
                            case 1:
                                echo "請輸入帳號與密碼";
                                break;
                            case 2:
                                echo "帳號或密碼錯誤";
                                break;
                            case 0:
                                break;
                            default:
                                echo "發生未知錯誤";
                        }
                    }
                    ?>
                </div>
            </div>

            <div class=" TopDiv">

                <!--分割線上方Div-->

            </div>

            <hr class="TopHr">
            </hr>

        </div>

        <!--透過SQL增加商品資訊-->
        <div class="mainDiv">
            <?php
            if ($_POST["orderIndex"] != null) {
                // echo $_POST["orderIndex"];
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
                                            匯款帳戶: <b>';
                        if ($sqlArray['匯款帳戶'] == null) {
                            echo '賣家尚未提供';
                        } else {
                            echo $sqlArray['匯款帳戶'];
                        }
                        echo '</b>
                                            <input type="hidden" name="orderIndex" value="' . $sqlArray['訂單編號'] . '" />
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
            } else {
                $cmd = 'SELECT *
                    FROM `訂單` INNER JOIN `小農`
                    ON `訂單`.`訂購者帳號` = `小農`.`使用者帳號`
                    WHERE `使用者帳號`="' . $farmIndex . '"';
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {

                    while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                        echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse;">
            <form name="orderDetail" id="orderDetail" method="post" action="userOrderList.php">
                <tbody>
                    <tr>
                        <td>
                            販售者帳號:' . $sqlArray['販售者帳號'] . '
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
                            販售者聯絡電話:' . $sqlArray['連絡電話'] . '
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


        </div>



    </div>
</body>

</html>