<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農線上市集媒合系統';
$store = 'user';
$loginStatus = false;
$loginMember = 0;
$infoName = '';
$errorCode = 0;
error_reporting(0);
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

      <div class="WebNameDiv" onclick=goHome()>
        小農<br>
        線上市集<br>
      </div>

      <div class="LoginArea">
        <!-- 判斷有沒有登入 -->
        <?php

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
              <form method="post" action="index.php">
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
          <form id="login" class="title-add" method="post" action="index.php">
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

      <div class="TopDiv">
        <table class="SearchTable">
          <tbody>
            <tr>
              <td style="width: 100px; height:auto; text-align:right; font-size:larger; font-weight:bold;margin: auto 0% auto auto">農產品篩選</td>
              <td>
                <hr width="1" size=65px color="#000000" style="margin: 0% auto auto 0%; width:1px;">
              </td>
              <!-- Sql農產品篩選條件 -->
              <?php
              $cmd = "SELECT `名稱` FROM `農產品` WHERE 1";
              $sqlData = mysqli_query($conn, $cmd);
              if (mysqli_num_rows($sqlData) > 0) {
                while ($row = mysqli_fetch_assoc($sqlData)) {
                  echo '<td><input type="checkbox" name="" value="" id="sql">' . $row['名稱'] . '</td>';
                }
              }
              ?>
              <!-- <td><input type="checkbox" name="" value="" id="sql">123</td> -->

              <td style="width: 40px;">
                <button style="width: 40px; height:auto; text-align:center; font-size:larger; font-weight:bold;">
                  篩<br>選
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <hr class="TopHr">
      </hr>
    </div>
    <!--透過SQL增加賣場資訊-->
    <div class="mainDiv">


      <script>
        var i = 0;
        var storeInfoTemplate = document.getElementById('storeInfoTemplate');

        function CreatStoreInfoDiv(info) {
          var clone = storeInfoTemplate.cloneNode(true); // "deep" clone

          clone.id = "storeInfoDiv" + ++i; // there can only be one element with an ID

          console.log("clone");
          storeInfoTemplate.parentNode.appendChild(clone);
          clone.style.display = "block";
        }
      </script>
      <?php
      $cmd = "SELECT `賣場編號`,`賣場圖片`,`賣場簡介`,`交易訂單數`,`瀏覽次數` FROM `小農`";
      $sqlData = mysqli_query($conn, $cmd);
      if (mysqli_num_rows($sqlData) > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($sqlData)) {
          // $img = $row['賣場圖片'];
          // printf("%d", $i);
          echo '<form id="entryStore' . $i . '" method="post" action="storePage.php">';
          echo '<table class="StoreInfoTable" id="storeInfoTemplate">
                <tbody>
                  <tr>
                    <td rowspan="3" align="center" style="width: 100px; height:100px;"><img src="image/user.png" alt="123"><button class="StoreHrefText" >進入此賣場</button><input type="hidden" name="storeNumber" value="' . $row['賣場編號'] . '"></a></td>
        
                    <td rowspan="3">
                      <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                    </td>
                    <td rowspan="3" style="width:500px;" id="storeInfo">' . $row["賣場簡介"] . '</td>
                    <!--賣場資訊-->
                    <td rowspan="3">
                      <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                    </td>
                    <td style="right:0px; position: relative; width:150px; font-size:16px;">
                      已成交訂單數:<br>
                      <font color="red">' . $row["交易訂單數"] . '</font>
                    </td>
                  <tr>
                    <td>
                      <hr style="margin: auto 0% auto 0%; height:2px;  border:0px; background-color: #000000;">
                    </td>
                  </tr>
        
                  <tr>
                    <td style=" font-size:16px;">
                      瀏覽次數:<br>
                      <font color="red">' . $row["瀏覽次數"] . '</font>
                    </td>
                  </tr>
                  </tr>
                </tbody>
              </table>';
          echo '</form>';
          $i++;
        }
      }
      ?>

    </div>


  </div>
</body>

</html>