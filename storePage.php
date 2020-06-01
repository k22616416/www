<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
$store = 'user';
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
                $conn = new mysqli('127.0.0.1:3306', 'root', '', '小農2');
                if (!$conn) {
                    //echo "資料庫連線失敗<br>";
                } else {
                    //echo "資料庫連線成功<br>";
                }

                if (isset($_POST['submit'])) {
                    if (empty($_POST['user']) || empty($_POST['password'])) {
                        //echo 'userName empty';
                    } else {
                        $userName = $_POST['user'];
                        $passwd = $_POST['password'];
                        //$task = $_POST['newTask'];

                        // $insertQuery = "SELECT * FROM `消費者` WHERE `使用者帳號`=$userName AND `使用者密碼`=$passwd;";
                        $insertQuery = "SELECT * FROM `消費者`";
                        //echo $task;
                        $sqlData = $conn->query($insertQuery);
                        if ($sqlData->num_rows > 0) {
                            while ($row = $sqlData->fetch_assoc()) {
                                //echo $row['使用者帳號'] . "<br>" . $row['姓名'] . "<br>" . $row['Email'] . "<br>" . $row['連絡電話'];
                            }
                            unset($_POST['user']);
                            unset($_POST['password']);
                        } else {
                            //echo "0筆資料";
                        }
                        $conn->close();
                        // header('localhost: index.php');
                    }
                }
                ?>
                <!-- 已登入 -->
                <table class="loginTable" style="border-collapse:collapse; border:2px solid #000000; background-color: RGBA(255,255,255,0.50); display:none;">
                    <tbody>
                        <tr>
                            <td style="border:2px solid #000000; width:150px;">
                                <span style="font-size: 16px;">123456789
                            </td>
                            <td style="border:2px solid #000000;"><button class="LoginButton" style=" width: auto; background-color: RGBA(255,0,0,0.70);">登出</button></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button class="RegisterButton">修改個人資料</button></td>
                        </tr>
                    </tbody>
                </table>

                <!-- 未登入 -->
                <table class="loginTable" cellpadding="0">
                    <form class="title-add" method="post" action="storePage.php">
                        <tbody>
                            <tr>
                                <td><input type="text" class="inputText" placeholder="帳號" name="user"></td>
                                <td><button name="submit" type="submit" class="LoginButton" style="background-color: #C4E1FF;">會員登入</button></td>
                            </tr>
                            <tr>
                                <td><input type="password" class="inputText" placeholder="密碼" name="password"></td>
                                <td><button name="submit" type="submit" class="LoginButton" style="background-color: #FFD306;">小農登入</button></td>
                            </tr>
                        </tbody>
                    </form>
                </table>
                <button type="button" class="RegisterButton" style="display: none;">註冊成為新的小農或會員</button>
            </div>

            <div class="TopDiv">
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
                                <td align="center" style="font-size: 30px; font-weight: bolder; width: 150px;"><span>買菜藍</span></td>
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
        <button id="button" style="position: fixed;bottom:0px;">Click me</button>
        <!--透過SQL增加賣場資訊-->
        <div class="mainDiv">


            <table class="StoreInfoTable" id="storeInfoTemplate">
                <form name="commodity1" action="storePage.php" method="POST" align="center" style="margin:auto auto auto auto;">
                    <input type="text" id="commodity1" value="123" style="display: none;">
                    <tbody>
                        <tr>
                            <td rowspan="3" align="center" style="width: 100px; height:100px;"><img src="image/carrot.png" alt="123"><span id="sql" style="font-size:smaller;">有機</span></td>
                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td rowspan="3" id="sql">
                                <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
                                    <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">
                                        <td name='CID' value='123456' style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">品名：</td>
                                        <td>n 元/把</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px;">配銷地點：OO市</td>
                                        <td>運送方式：宅配</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">剩餘數量：n把</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                            <!--賣場資訊-->
                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder; ">
                                <!-- <form name="commodity" action="storePage.php" method="POST" align="center" style="margin:auto auto auto auto;"> -->
                                <script>
                                    function buy() {
                                        shopCarCount++;

                                        // $.cookie('commodity' + shopCarCount, document.getElementsByName(commodity1).values);
                                        //alert(document.cookie);
                                        console.log('buy');
                                        checkBuyCar();
                                    }
                                </script>
                                <!-- <input type="text" name="buyCar" /> -->
                                <a onclick="javascript:buy();return false;" href="#">
                                    <font color="blue" align="center">購<br>買</font>
                                </a>
                                <!-- </form> -->
                            </td>
                        </tr>
                    </tbody>
                </form>
            </table>

        </div>



    </div>
</body>

</html>