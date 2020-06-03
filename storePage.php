<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
if (isset($_POST['storeNumber'])) {
    $store = $_POST['storeNumber'];
} else {
    die("取得賣場編號失敗");
    exit;
}

$loginStatus = false;
$loginMember = 0;
$infoName = '';
$errorCode = 0;
error_reporting(0);
?>
<script>
    var shopCarCount = 0;
</script>

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
            <div class="WebNameDiv">
                小農<br>
                線上市集<br>
            </div>
            <button type="button" style="position: absolute; top:36px;left:210px; background-color:RGBA(255,0,0,0.60);">離開此賣場</button>
            <div class="LoginArea">
                <!-- 判斷有沒有登入 -->
                <?php
                $DBNAME = "小農2";
                $DBUSER = "root";
                $DBHOST = "localhost";
                $conn = mysqli_connect($DBHOST, $DBUSER, '');
                if (empty($conn)) {
                    print mysqli_error($conn);
                    die("資料庫連線失敗");
                    exit;
                }
                if (!mysqli_select_db($conn, $DBNAME)) {
                    die("資料庫連線失敗");
                }
                // mysqli_query($conn, "SET NAMES 'utf8'");
                // $conn = new mysqli('127.0.0.1:3306', 'root', '', '小農2');
                // if (!$conn) {
                //     echo "資料庫連線失敗<br>";
                // } else {
                //     echo "資料庫連線成功<br>";
                // }

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
                            $loginStatus = true;
                            $loginMember = 2;
                            $errorCode = 0;
                            $infoName = $sqlArray['姓名'];
                        } else {
                            $errorCode = 2;
                        }
                        unset($_POST['user']);
                        unset($_POST['password']);
                    }
                }

                ?>
                <!-- 已登入 -->
                <table class="loginTable" style="border-collapse:collapse; border:2px solid #000000; background-color: RGBA(255,255,255,0.50); <?php if (!$loginStatus) echo 'display:none;'; ?>">

                    <tbody>
                        <tr>
                            <td style="border:2px solid #000000; width:150px;">
                                <span style="font-size: 16px;"><?php echo '歡迎' . $infoName; ?>
                            </td>
                            <form method="post" action="storePage.php">
                                <td style="border:2px solid #000000;"><button name="logout" type="submit" class="LoginButton" style=" width: auto; background-color: RGBA(255,0,0,0.70);">登出</button></td>

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
                <!--分割線上方Div-->
                <table class="StoreTopTable">
                    <tbody>
                        <tr>
                            <td rowspan="2" style="width: 100px; height:70px;"><img src="image/user.png"></td>
                            <td rowspan="2">
                                <hr width=" 3px" size=70px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td rowspan="2" style="width:500px" id="sql">賣場資訊</td>
                            <!--賣場資訊-->
                            <td rowspan="2">
                                <hr width=" 3px" size=70px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td style="right:0px; position: relative; width:150px; font-size:14px;">
                                已成交訂單數:<br>
                                <font color="red">000</font>
                            </td>
                        <tr>
                            <td style=" font-size:14px;">
                                瀏覽次數:<br>
                                <font color="red">000</font>
                            </td>
                        </tr>
                        </tr>

                    </tbody>
                </table>
            </div>

            <hr class="TopHr">
            </hr>

            <div class="shopCar" style="display:none;" id="shopCar">
                <form class="shopCarForm" method="post" action="storePage.php">
                    <table style="border-bottom: 5px solid #000000;">
                        <tbody>
                            <tr>
                                <td style="width: 50px;"><img src="image/shopping_cart.png" style="height: 50px; width:50px; margin:0px auto auto 5px;"></td>
                                <td align="center" style="font-size: 30px; font-weight: bolder; width: 150px;">
                                    <span>買菜藍</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        function checkBuyCar() {
                            if (shopCarCount == 0) return;
                            document.getElementById('shopCar').style = "";


                            for (var i = 0; i < shopCarCount; i++) {
                                var a = $_SESSION['commodity' + shopCarCount];
                                console.log("SESSION:" + a);
                                var tmp = document.getElementById('shopCarTableTemplate');
                                var clone = tmp.cloneNode(true);
                                clone.style = "";
                                clone.id = "shopCarTable" + i;
                                tmp.parentNode.appendChild(tmp);

                            }
                        }
                    </script>
                    <table class="shopCarTable" id="shopCarTableTemplate">
                        <tbody>
                            <tr>
                                <td align="left" id="target">123</td>
                                <td align="center">123</td>
                                <td align="center">123</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr id="shopCarHr">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        function buyDone() {
                            for (var i = 0; i < shopCarCount; i++) {
                                unset($_SESSION['commodity' + shopCarCount]);
                            }
                        }
                    </script>
                    <button class="checkoutButton" onclick="buyDone">結帳</button>
                </form>
            </div>
        </div>

        <!--透過SQL增加賣場資訊-->
        <div class="mainDiv">
            <table class="StoreInfoTable" id="storeInfoTemplate">
                <form name="commodity1" action="storePage.php" method="POST" align="center" style="margin:auto auto auto auto;">
                    <input type="text" id="commodity1" value="123" style="display: none;">
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
                                        <td name='CID' value='123456' style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">
                                            品名：</td>
                                        <td>n 元/把</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px;">配銷地點：OO市</td>
                                        <td>運送方式：宅配</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">
                                            剩餘數量：n把</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder; ">
                                <script>
                                    function buy() {
                                        shopCarCount++;
                                        console.log('buy');
                                        checkBuyCar();
                                    }
                                </script>
                                <a onclick="javascript:buy();return false;" href="#">
                                    <font color="blue" align="center">購<br>買</font>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </form>
            </table>

        </div>



    </div>
</body>

</html>