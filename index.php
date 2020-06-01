<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
$store = null;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">


  <title>
    小農線上市集媒合系統
  </title>
</head>

<body>

  <div class="WebLayout">
    <div class="topArea">
      <div class="titleDiv">農產品販售區</div>
      <div class="WebNameDiv">
        小農<br>
        線上市集<br>
      </div>

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
          <form class="title-add" method="post" action="index.php">
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
        <button type="button" class="RegisterButton">註冊成為新的小農或會員</button>
      </div>

      <div class="TopDiv">
        <table class="SearchTable">
          <tbody>
            <tr>
              <td style="width: 100px; height:auto; text-align:right; font-size:larger; font-weight:bold;margin: auto 0% auto auto">農產品篩選</td>
              <td>
                <hr width="1" size=65px color="#000000" style="margin: 0% auto auto 0%; width:1px;">
              </td>
              <!-- Sql農產品篩選條件 -->
              <td><input type="checkbox" name="" value="" id="sql">123</td>
              <td><input type="checkbox" name="" value="" id="sql">123</td>
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
            <td rowspan="3" align="center" style="width: 100px; height:100px;"><img src="image/user.png" alt="123"><a href="" class="StoreHrefText">進入此賣場</a></td>

            <td rowspan="3">
              <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
            </td>
            <td rowspan="3" style="width:500px;" id="sql">賣場資訊</td>
            <!--賣場資訊-->
            <td rowspan="3">
              <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
            </td>
            <td style="right:0px; position: relative; width:150px; font-size:16px;">
              已成交訂單數：<br>
              <font color="red">000</font>
            </td>
          <tr>
            <td>
              <hr style="margin: auto 0% auto 0%; height:2px;  border:0px; background-color: #000000;">
            </td>
          </tr>

          <tr>
            <td style=" font-size:16px;">
              瀏覽次數：<br>
              <font color="red">000</font>
            </td>
          </tr>
          </tr>

        </tbody>
      </table>

    </div>


  </div>
</body>

</html>