<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
error_reporting(0);
if (isset($_POST['memberInput']))
    $member = $_POST['memberInput'];
else
    $member = 0;

if ($member == 0) $titleStr = '會員註冊頁面';
else $titleStr = '小農註冊頁面';



$user = "";
$passwd = "";
$passwdConfirm = "";
$email = "";
$phone = "";
$address = "";
$gMap = "";
if (isset($_POST['user'])) {
    $user = $_POST['user'];
    $passwd = $_POST['passwd'];
    $passwdConfirm = $_POST['passwd2'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phoneNumber'];
    if ($member == 1)
        $gMap = $_POST['gMap'];

    include_once("sqlConnectAPI.php");
    if (($conn = ConnectDB()) == null) {
        die("資料庫連線失敗");
    }
    $cmd = 'SELECT * FROM `註冊審核` WHERE `使用者帳號`=\'' . $user . '\' AND `註冊身分類別`=\'' . $member . '\'';
    if ($sqlData = mysqli_query($conn, $cmd) == false) {
        $cmd = 'INSERT INTO `註冊審核`(`編號`,`註冊身分類別`, `使用者帳號`, `使用者密碼`, `聯絡電話`, `Email`, `住址`, `地圖經緯度`) VALUES (\'\',' . $member . ',"' . $user . '","' . $passwd . '","' . $phone . '","' . $email . '","' . $address . '","' . $gMap . '")';
        if ($sqlData = mysqli_query($conn, $cmd) == false) {
            echo '<script>alert("資料庫存取失敗");</script>';
            sleep(10);
            echo '<script>document.location.href="index.php"</script>';
        } else {
            echo '<script>alert("註冊資訊提交成功!\n請等待管理員審核");</script>';
            unset($_POST['user']);
            unset($_POST['passwd']);
            unset($_POST['passwd2']);
            unset($_POST['email']);
            unset($_POST['address']);
            unset($_POST['phoneNumber']);
            if ($member == 1)
                unset($_POST['gMap']);
            echo '<script>document.location.href="index.php"</script>';
        }
    } else {
        echo '<script>alert("此帳號已被註冊!");</script>';
        echo '<script>document.location.href="registerPage.php"</script>';
    }
}




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $titleStr ?>
    </title>
</head>

<body>

    <div class="WebLayout" style="height:600px; min-height:600px;">
        <div class="topArea">
            <div class="titleDiv" style="color:rgba(190,0,0,1);"><?php echo $titleStr ?></div>
            <div class="WebNameDiv" onclick=goHome()>
                小農<br>
                線上市集<br>
            </div>
            <form action="registerPage.php" method="post">
                <input name="memberInput" type="hidden" value="<?php if ($member == 0) echo '1';
                                                                else echo '0'; ?>"></input>
                <button name="memberType" type="submit" style="position: absolute; top:15px; left:210px; width:100px; <?php if ($member == 0) echo ' background-color: #FFD306;';
                                                                                                                        else echo 'background-color: #C4E1FF;'; ?>">
                    轉至<?php if ($member == 0) echo '小農';
                        else echo '會員'; ?>申請頁面</button>
            </form>
            <div class="TopDiv">
                <div class="registerTopDiv">填寫基本資料</div>
            </div>

            <hr class="TopHr">
            </hr>
        </div>


        <script>
            var passwd = "";
            var error = [0, 1, 2, 3, 4, 6];



            function checkInput(n, obj) {
                switch (n) {
                    case 0: //帳號
                        var re = /^(?=.*\d)(?=.*[a-zA-Z]).{6,30}/g;
                        if (!re.test(obj.value)) {
                            obj.style = "background-color:rgba(255,0,0,0.40); margin: auto 0 auto auto;";
                            document.getElementById("errorText").innerHTML = '帳號輸入格式錯誤<br>帳號格式：<br>1.6~30個字元<br>2.以數字與英文組合成<br>3.至少含有1個大寫或1個小寫英文字母<br>4.第一個數字不為數字';
                            document.getElementById("errorDiv").style.display = "";
                            // error.push(0);
                        } else {
                            obj.style = "margin: auto 0 auto auto;background-color:rgba(0,255,0,0.4);";
                            document.getElementById("errorDiv").style.display = "none";
                            error.splice(error.indexOf(0), 1);
                        }

                        break;
                    case 1: //密碼
                        var re = /^(?=.*[a-zA-Z])(?=.*[0-9]).{8,30}$/g;
                        if (!re.test(obj.value)) {
                            obj.style = "background-color:rgba(255,0,0,0.40); margin: auto 0 auto auto;";
                            document.getElementById("errorText").innerHTML = ('密碼輸入格式錯誤<br>密碼格式：<br>1.8~30個字元<br>2.以數字與英文組合成<br>3.至少含有1個大寫或1個小寫英文字母');
                            document.getElementById("errorDiv").style.display = "";
                            // error.push(1);
                        } else {
                            obj.style = "margin: auto 0 auto auto;background-color:rgba(0,255,0,0.4);";
                            passwd = obj.value;
                            document.getElementById("errorDiv").style.display = "none";
                            error.splice(error.indexOf(1), 1);
                        }
                        break;
                    case 2: //電話
                        var re = /^(?=[0-9]).{9,10}$/;
                        if (!re.test(obj.value)) {
                            obj.style = "background-color:rgba(255,0,0,0.40); margin: auto 5px auto auto;";
                            document.getElementById("errorText").innerHTML = ('請輸入正確格式的電話<br>9~10碼，不須輸入-分隔');
                            document.getElementById("errorDiv").style.display = "";
                            // error.push(2);
                        } else {
                            obj.style = "margin: auto 5px auto auto;background-color:rgba(0,255,0,0.4);";
                            passwd = obj.value;
                            document.getElementById("errorDiv").style.display = "none";
                            error.splice(error.indexOf(2), 1);
                        }
                        break;
                    case 3: //email
                        var re = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/;
                        if (!re.test(obj.value)) {
                            obj.style = "background-color:rgba(255,0,0,0.40); margin: auto 5px auto auto;";
                            document.getElementById("errorText").innerHTML = ('Email信箱輸入格式錯誤');
                            document.getElementById("errorDiv").style.display = "";
                            // error.push(3);
                        } else {
                            obj.style = "margin: auto 5px auto auto;background-color:rgba(0,255,0,0.4);";
                            passwd = obj.value;
                            document.getElementById("errorDiv").style.display = "none";
                            error.splice(error.indexOf(3), 1);
                        }
                        break;

                    case 4: //住址
                        if (obj.value != "") {
                            obj.style = "margin: auto 5px auto auto;background-color:rgba(0,255,0,0.4);";
                            error.splice(error.indexOf(4), 1);
                        }
                        break;

                    case 5: //經緯度
                        if (obj.value != "") {
                            obj.style = "margin: auto 0 auto auto;background-color:rgba(0,255,0,0.4);";
                            error.splice(error.indexOf(5), 1);
                        }
                        break;
                    case 6: //密碼確認                        
                        if (passwd == "")
                            break;
                        else if (passwd != obj.value) {
                            obj.style = "margin: auto 0 auto auto;background-color:rgba(255,0,0,0.40);";
                            document.getElementById("errorText").innerHTML = ('使用者密碼與密碼確認不一致');
                            document.getElementById("errorDiv").style.display = "";
                            // error.push(6);
                        } else {
                            obj.style = "margin: auto 0 auto auto;background-color:rgba(0,255,0,0.4);";
                            error.splice(error.indexOf(6), 1);
                        }
                        break;


                }

            }
        </script>
        <div class="mainDiv" style="  min-height:500px; width:600px;">
            <form class="registerInfoForm" name="registerInfoForm" id="registerInfoForm" method="post" action="registerPage.php">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:larger; font-weight:bolder;">使用者帳號：</td>
                                            <td class="registerTd"><input name="user" id="user" type="text" onblur="checkInput(0,this)" style="margin: auto 0 auto auto;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:larger; font-weight:bolder;">使用者密碼：</td>
                                            <td class="registerTd"><input name="passwd" id="passwd" onblur="checkInput(1,this)" type="password" style="margin: auto 0 auto auto;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>

                                            <td style="font-size:larger; font-weight:bolder;">密碼確認：</td>
                                            <td class="registerTd"><input name="passwd2" id="passwd2" onblur="checkInput(6,this)" type="password" style="margin: auto 0 auto auto;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:larger; font-weight:bolder;">連絡電話：</td>
                                            <td class="registerTd"><input name="phoneNumber" id="phoneNumber" onblur="checkInput(2,this)" class="registerInputText" type="text" style="margin: auto 5px auto auto;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:larger; font-weight:bolder;">Email：</td>
                                            <td class="registerTd"><input name="email" id="email" onblur="checkInput(3,this)" class="registerInputText" type="text" style="margin: auto 5px auto auto;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="registerInput">
                                    <tbody>
                                        <tr>
                                            <td style="font-size:larger; font-weight:bolder;">住址：</td>
                                            <td class="registerTd"><input name="address" id="address" onblur="checkInput(4,this)" class="registerInputText" style="margin: auto 5px auto auto;"></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="registerInput" <?php if ($member == 0) echo 'style="display:none;"' ?>>
                    <tbody>
                        <tr>
                            <td style="font-size:larger; font-weight:bolder;">地圖經緯度：</td>
                            <td class="registerTd"><input name="gMap" id="gMap" class="registerInputText" onblur="checkInput(5,this)"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="googleMapDiv" style="width: 300px; height:300px; background-color:rgba(255,255,255,0.70); border:1px solid #000000; text-align:center;">
                                    因經費不足<br>尚無法顯示Google地圖</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="errorDiv" style="display:none; position: absolute; width:250px; height:200px; margin-bottom:-100px; border:1px solid #000000 ;bottom:50%;background-color:rgba(255,255,255,0.70); <?php if ($member == 1) echo "right:50%;margin-right:-275px;";
                                                                                                                                                                                                            else echo "right:50%;margin-right:-150px;"; ?>">
                    <span id="errorText" style="font-size: 16px; color:red;"></span>
                </div>
                <div style="position: absolute; bottom:20px; right:50%; margin-right:-100px;">
                    <script>
                        function infoSubmitBtn(btn) {
                            if (error.length != 0) {
                                alert('請先正確填寫完資料');
                                for (var i = 0; i < 6; i++)
                                    console.log(error[i]);

                                return false;
                            }
                            btn.value = "程式執行中...";
                            btn.onclick = Function("return false;");
                            btn.disabled = true;
                            console.log('submit');
                            document.getElementById('registerInfoForm').submit();
                            return true;
                        }
                    </script>
                    <button name="infoSubmit" id="infoSubmit" type="submit" onclick="if(!infoSubmitBtn(this)) {return false;}" style="width: 100px; height:50px; background-color:cornflowerblue;  font-weight:bolder; font-size:30px;">送出</button>

                    <script>
                        var infoTable = ["user", "passwd", "passwd2", "phoneNumber", "email", "address", "gMap"];

                        function clearInfo() {
                            infoTable.forEach(function(n) {
                                document.getElementById(n).value = "";
                            })


                            console.log("clear");
                        }
                    </script>
                    <button name="clear" onclick="if(!clearInfo()){return false;}" style="width: 100px; height:50px; background-color:crimson; font-weight:bolder; font-size:30px;">清除</button>
            </form>
        </div>


    </div>


    </div>
</body>

</html>