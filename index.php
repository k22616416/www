<?php session_start(); ?>
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
include_once("sqlConnectAPI.php");
if (($conn = ConnectDB()) == null) {
  die("資料庫連線失敗");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

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
                $errorCode = 0;
                $_SESSION['user'] = $userName;
                $_SESSION['name'] = $sqlArray['姓名'];
                $_SESSION['member'] = $loginMember;
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
                $farmStoreNumber = $sqlArray['賣場編號'];

                $_SESSION['user'] = $userName;
                $_SESSION['name'] = $sqlArray['姓名'];
                $_SESSION['member'] = $loginMember;
                $_SESSION['farmStoreNumber'] = $sqlArray['賣場編號'];
                $_SESSION['姓名'] = $infoName;
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
              <form method="post" action="index.php">
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
              $cmd = "SELECT `名稱` FROM `農產品` WHERE 1;";

              if (($sqlData = SqlCommit($conn, $cmd)) > 0) {
                while ($row = $sqlData->fetch_assoc()) {
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
      $cmd = "SELECT * FROM `小農` WHERE 1;";
      if (($sqlData = SqlCommit($conn, $cmd)) != null) {
        $i = 0;
        while ($row = $sqlData->fetch_assoc()) {

          // $img = $row['賣場圖片'];
          // printf("%d", $i);
          echo '<form id="entryStore' . $i . '" method="post" action="storePage.php">';
          echo '<table class="StoreInfoTable" id="storeInfoTemplate">
                <tbody>
                  <tr>
                    <td rowspan="3" align="center" style="width: 100px; height:100px;">';
          if ($row['賣場圖片'] != null)
            echo '<img src="data:' . $row['圖片編碼格式'] . ';base64,' . $row['賣場圖片'] . '" />';
          else
            echo '<img src="image/user.png"/>';


          echo '<button class="StoreHrefText" >進入此賣場</button><input type="hidden" name="storeNumber" value="' . $row['賣場編號'] . '"></a></td>
        
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