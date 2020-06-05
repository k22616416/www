<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';

$DBNAME = "小農2";
$DBUSER = "root";
$DBHOST = "localhost";
$conn = mysqli_connect($DBHOST, $DBUSER, '');
if (empty($conn)) {
    print mysqli_error($conn);
    echo ("資料庫連線失敗");
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}
if (!mysqli_select_db($conn, $DBNAME)) {
    echo ("資料庫連線失敗");
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
}

if (isset($_POST['storeNumber'])) {
    $store = $_POST['storeNumber'];
    $_SESSION['storeNumber'] = $store;
} else if ($_SESSION['storeNumber'] != null) {
    $store = $_SESSION['storeNumber'];
} else {
    echo "取得賣場編號失敗";
    sleep(2);
    echo '<script>document.location.href="index.php"</script>';
    exit;
}

$loginStatus = false;
$loginMember = 0;
$infoName = '';
$errorCode = 0;
$storeInfo = '';
$storeOrder = 0;
$storeBrowse = 0;

error_reporting(0);

function debug($str)
{
    echo '<script>
    console.log(\'' . $str . '\');
    </script>';
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
        <?php echo $store ?>的農場
    </title>
</head>

<body>

    <div class="WebLayout">
        <div class="topArea">
            <div class="titleDiv" id="sql"><?php echo $store ?>的農場</div>
            <div class="WebNameDiv" onclick=goHome()>
                小農<br>
                線上市集<br>
            </div>

            <button type="button" onclick="goHome()" style="position: absolute; top:36px;left:210px; background-color:RGBA(255,0,0,0.60);">離開此賣場</button>
            <div class="LoginArea">
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
                    $infoName = $_SESSION['姓名'];
                    $userName = $_SESSION['user'];
                    $errorCode = 0;

                    echo '<script>console.log("' . $loginMember . '")</script>';
                    echo '<script>console.log("' . $infoName . '")</script>';
                    echo '<script>console.log("' . $userName . '")</script>';
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

                ?>
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
                            echo '<input type="hidden" name="user" value="' . $userName . '">';
                            echo '<td colspan=2><button class="RegisterButton">進入個人賣場</button></td>';
                            echo '</form>';
                            echo '</tr>';
                        } else if ($loginMember == 1) //消費者身分
                        {
                            echo '<tr>';
                            echo '<td colspan="2"><button class="RegisterButton" name="logout" type="submit">修改個人資料</button></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>

                </table>

                <!-- 未登入 -->


                <table class="loginTable" cellpadding="0" style="<?php if ($loginStatus) echo 'display:none;'; ?>">
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
                <button onclick=goRegister() type="button" class="RegisterButton" style="<?php if ($loginStatus) echo 'display:none;'; ?>">
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
                <?php
                $cmd = "SELECT * FROM `小農` WHERE `賣場編號`= '" . $store . "'";
                $sqlData = mysqli_query($conn, $cmd);
                if ($sqlData->num_rows > 0) {
                    $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
                    $storeInfo = $sqlArray['賣場簡介'];
                    $storeOrder = $sqlArray['交易訂單數'];
                    $storeBrowse = $sqlArray['瀏覽次數'];
                } else {
                    echo '取得賣場資訊時發生錯誤，將返回首頁';
                    sleep(2);
                    echo '<script>document.location.href="index.php"</script>';
                }

                ?>
                <!--分割線上方Div-->
                <table class="StoreTopTable">
                    <tbody>
                        <tr>
                            <td rowspan="2" style="width: 100px; height:70px;"><img src="image/user.png"></td>
                            <td rowspan="2">
                                <hr width=" 3px" size=70px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td rowspan="2" style="width:500px" id="sql"><?php echo $storeInfo; ?></td>
                            <!--賣場資訊-->
                            <td rowspan="2">
                                <hr width=" 3px" size=70px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td style="right:0px; position: relative; width:150px; font-size:14px;">
                                已成交訂單數:<br>
                                <font color="red" style="font-weight: bolder;"><?php echo $storeOrder; ?></font>
                            </td>
                        <tr>
                            <td style=" font-size:14px;">
                                瀏覽次數:<br>
                                <font color="red" style="font-weight: bolder;"><?php echo $storeBrowse; ?></font>
                            </td>
                        </tr>
                        </tr>

                    </tbody>
                </table>
            </div>

            <hr class="TopHr">
            </hr>

            <div class="shopCar" id="shopCar" style="display:none;">
                <!-- <form class="shopCarForm" method="post" action="storePage.php"> -->
                <table style="border-bottom: 5px solid #000000;">
                    <tbody>
                        <tr>
                            <td style="width: 50px;"><img src="image/shopping_cart.png" style="height: 50px; width:50px; margin:0px auto auto 5px;"></td>
                            <td align="center" style="font-size: 30px; font-weight: bolder; width: 150px;">
                                <span>買菜藍</span></td>
                        </tr>
                    </tbody>
                </table>

                <?php
                function creatByuCar($name, $CID, $CCash, $count)
                {
                    echo '<script>document.getElementById(\'shopCar\').style = "overflow: auto;";</script>';
                    if ($name != null) {

                        if (isset($_SESSION['buyCarList'])) {
                            // $list[] = array('CID' => $CID, 'name' => $name, 'CCash' => $CCash, 'count' => $count);
                            $list = unserialize($_SESSION['buyCarList']);
                            $r = false;
                            for ($i = 0; $i < count($list, COUNT_NORMAL); $i++) {
                                if ($list[$i]['CID'] == $CID) {
                                    $list[$i]['CCash'] = $CCash;
                                    $list[$i]['count'] = $count;
                                    $r = true;
                                    break;
                                }
                            }
                            if (!$r) {
                                $list[] = array('CID' => $CID, 'name' => $name, 'CCash' => $CCash, 'count' => $count);
                                // $list[] = array('CID' => $CID, 'name' => $name, 'CCash' => $CCash, 'count' => $count);
                                // debug('List Lenght:' . count($list, COUNT_NORMAL));

                                // print_r($list);
                            }
                            $_SESSION['buyCarList'] = serialize($list);

                            // print_r($list);
                        } else {
                            $list[] = array('CID' => $CID, 'name' => $name, 'CCash' => $CCash, 'count' => $count);
                            $_SESSION['buyCarList'] = serialize($list);
                        }
                        debug(print_r($list, true));

                        $_SESSION['buyCarList'] = serialize($list);
                        if (!isset($_SESSION['buyCarList']))  //購物車資訊存到cookie
                        {
                            die("SESSION儲存失敗");
                        } else {
                            // print($_SESSION['buyCarList']);
                        }
                        $str = print_r($list, true);
                        debug($_SESSION['buyCarList']);
                    } else {
                        $list = unserialize($_SESSION['buyCarList']);
                    }
                    $index = 0;
                    // 建立購物車內容
                    // foreach ($list as $i => $val) {
                    for ($i = 0; $i < count($list, COUNT_NORMAL); $i++) {
                        // if (!is_array($list[$i])) continue;
                        echo '
                        <table class="shopCarTable" id="shopCarTableTemplate' . $i . '">
                            <form name="shopCarTable" method="post" action="storePage.php" >
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="commodityIndex" value="' . $list[$i]['CID'] . '"></input>
                                        <td align="left" id="target">' . $list[$i]['name'] . '</td>
                                        <script>
                                            function cashTotal' . $i . '(cash, count) {
                                                document.getElementById("cashTotal' . $i . '").innerHTML = "小計:"+(cash * count);
                                            }
                                        </script>
                                        <td align="left" id="cashTotal' . $i . '">小計:' . $list[$i]['CCash'] * $list[$i]['count'] . '</td>
                                        <td align="center"><input type="count" onkeydown="if(event.keyCode==13){return false;}" onchange="cashTotal' . $i . '(' . $list[$i]['CCash'] . ',this.value,' . $i . ')" value="' . $list[$i]['count'] . '" style="width:20px; text-align:center;"></input></td>
        
                                        <td><input type="submit"  name="cancel" style="background-color:rgba(0,0,0,0); ;background-image:url(Image/cancel.png); width:32px; height:32px; border:0px; padding:0 0 0 0;" value=""></input> </td>
                                        
        
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <hr id="shopCarHr">
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>';
                    }
                }

                if (isset($_POST['buyButton'])) {   //如果有東西加到購物車內
                    // $commodityIndex = $_POST['commodityIndex'];
                    // $buyCount = $_POST['buyCount'];
                    // $commodityName = $_POST['CName'];
                    // $cash = $_POST['cash'];
                    unset($_POST['buyButton']);
                    creatByuCar($_POST['CName'], $_POST['commodityIndex'], $_POST['cash'], $_POST['buyCount']);
                } else if (isset($_POST['cancel'])) {
                    $oldlist = unserialize($_SESSION['buyCarList']);

                    for ($i = 0; $i < count($oldlist, COUNT_NORMAL); $i++) {
                        if ($oldlist[$i]['CID'] != $_POST['commodityIndex']) {
                            $list[] = array('CID' => $oldlist[$i]['CID'], 'name' => $oldlist[$i]['name'], 'CCash' => $oldlist[$i]['CCash'], 'count' => $oldlist[$i]['count']);
                            debug('set:' . $i);
                            // unset($oldlist[$i]['CID']);
                            // unset($oldlist[$i]['name']);
                            // unset($oldlist[$i]['CCash']);
                            // unset($oldlist[$i]['count']);
                            // unset($oldlist[$i]);
                            // print_r($list);

                            // break;
                        }
                    }
                    if (count($list, COUNT_NORMAL) == 0)  unset($_SESSION['buyCarList']);
                    else {

                        $_SESSION['buyCarList'] = serialize($list);
                        debug("listIndex:" . count($list, COUNT_NORMAL));
                        debug($_SESSION['buyCarList']);
                        creatByuCar(null, null, null, null);
                    }

                    // session_destroy();
                } else if (isset($_SESSION['buyCarList'])) {
                    creatByuCar(null, null, null, null);
                }

                ?>

                <button class="checkoutButton" onclick="buyDone">結帳</button>
            </div>
        </div>

        <!--透過SQL增加商品資訊-->
        <div class="mainDiv">
            <?php
            $cmd = 'SELECT `名稱`,`價格`,`願意配銷地點`,`配銷方式`,`剩餘數量`,`產品資訊`.`產品編號`
            FROM (`小農` INNER JOIN `個人賣場2` ON `小農`.`賣場編號`=`個人賣場2`.`賣場編號`)
            INNER JOIN `產品資訊` ON `個人賣場2`.`產品編號`=`產品資訊`.`產品編號`
            WHERE `小農`.`賣場編號`="' . $store . '";';
            $sqlData = mysqli_query($conn, $cmd);
            if ($sqlData->num_rows > 0) {
                while ($sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC)) {
                    echo '
                    <table class="StoreInfoTable" id="storeInfoTemplate">
                        <form name="commodity" id="commodity" action="storePage.php" method="post" align="center" style="margin:auto auto auto auto;">
                            <input type="hidden" name="commodityIndex" value="' . $sqlArray['產品編號'] . '"></input>
                            <tbody>
                                <tr>
                                    <td rowspan="3" align="center" style="width: 100px; height:100px;"><img src="image/carrot.png" alt="123"><span id="sql" style="font-size:smaller;">有機</span>
                                    </td>
                                    <td rowspan="3">
                                        <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                                    </td>
                                    <td rowspan="3" id="sql">
                                        <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
                                            <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">
                                            <input type="hidden" name="CName" value="' . $sqlArray['名稱'] . '"></input>
                                                <td  style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">
                                                    品名：' . $sqlArray['名稱'] . '</td>
                                                    <input type="hidden" name="cash" value="' . $sqlArray['價格'] . '"></input>
                                                <td>' . $sqlArray['價格'] . ' 元/把</td>
                                            </tr>
                                            <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
                                                <td style="border: 3px solid #000000; border-left:0px;">配銷地點：' . $sqlArray['願意配銷地點'] . '</td>
                                                <td>運送方式：' . $sqlArray['配銷方式'] . '</td>
                                            </tr>
                                            <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
                                                <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">
                                                    剩餘數量：' . $sqlArray['剩餘數量'] . '</td>
                                                <td>購買數量 <input type="text" name="buyCount" style="width:50px;" onkeydown="if(event.keyCode==13){return false;}" value=1></input></td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td rowspan="3">
                                        <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                                    </td>
                                    <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder; ">
                                        <button type="submit" name="buyButton" font color="blue" align="center" style=" font-size:24px; font-weight: bolder; background-color: #FFFFFF;">購<br>買</button>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    </table>
                    ';
                }
            } else {
                echo '資料取得失敗';
            }

            ?>


        </div>



    </div>
</body>

</html>