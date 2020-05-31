<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
$store = 'user';
?>

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
                    <tbody>
                        <tr>
                            <td><input type="text" class="inputText" placeholder="帳號" name="user"></td>
                            <td><button type="button" class="LoginButton" style="background-color: #C4E1FF;">會員登入</button></td>
                        </tr>
                        <tr>
                            <td><input type="password" class="inputText" placeholder="密碼" name="password"></td>
                            <td><button type="button" class="LoginButton" style="background-color: #FFD306;">小農登入</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="RegisterButton" style="display: none;">註冊成為新的小農或會員</button>
            </div>

            <div class="TopDiv">
                <!--分割線上方Div-->
                <table class="StoreTopTable">
                    <tbody>
                        <tr>
                            <td rowspan="2" style="width: 100px; height:70px;"><img src="image/user.png" alt="123"></td>
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
        </div>
        <button id="button" style="position: fixed;bottom:0px;">Click me</button>
        <!--透過SQL增加賣場資訊-->
        <div class="mainDiv">
            <table class="StoreInfoTable" id="storeInfoTemplate">
                <tbody>
                    <tr>
                        <td rowspan="3" align="center" style="width: 100px; height:100px;"><img src="image/carrot.png" alt="123"><span id="sql" style="font-size:smaller;">有機</span></td>
                        <td rowspan="3">
                            <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                        </td>
                        <td rowspan="3" id="sql">
                            <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
                                <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">
                                    <td style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">品名：</td>
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
                        <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder;">
                            <a href="">
                                <font color="blue">購<br>買</font>
                            </a>
                        </td>



                    </tr>

                </tbody>
            </table>

        </div>


    </div>
</body>

</html>