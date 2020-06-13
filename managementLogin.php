<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '管理員登入頁面';
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


  <title>
    <?php echo $titleStr ?>
  </title>
</head>

<body>

  <div class="WebLayout">
    <div class="topArea">
      <div class="titleDiv"><?php echo $titleStr ?></div>
      <div class="WebNameDiv" onclick=goHome()>
        小農<br>
        線上市集<br>
      </div>



      <div class="TopDiv">


      </div>

      <hr class="TopHr">
      </hr>
    </div>
    <style>
      .ManagementLogin {
        position: absolute;
        width: 200px;
        left: 50%;
        top: 20%;
        margin-left: -100px;

        background-color: #93FF93;
        border: 1px solid #000000;
        font-weight: bolder;
      }
    </style>
    <!--透過SQL增加賣場資訊-->
    <div class="mainDiv">
      <div class="ManagementLogin">
        此網頁為管理員後台登入頁面，請確認您的帳號已登記為管理員身分。
      </div>
      <div class="LoginArea" style="position: absolute; top:50%; left:50%; margin:-100px auto auto -100px;">
        <!-- 判斷有沒有登入 -->

        <?php
        if (isset($_POST['logout'])) {
          unset($_POST['logout']);
          unset($_SESSION['user']);
          unset($_SESSION['name']);
          unset($_SESSION['member']);
          echo '<script>document.location.location=location</script>';
        } else {
          if (isset($_POST['managementSubmit'])) {
            if (empty($_POST['user']) || empty($_POST['password'])) {
              $errorCode = 1;
            } else {
              $userName = $_POST['user'];
              $passwd = $_POST['password'];

              $cmd = "SELECT * FROM `管理者` WHERE `使用者帳號`= '" . $userName . "' AND `使用者密碼`='" . $passwd . "';";
              $sqlData = mysqli_query($conn, $cmd);
              if ($sqlData->num_rows > 0) {
                $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
                $loginMember = 3;
                $errorCode = 0;
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
        <!-- 轉跳 -->

        <!-- 未登入 -->
        <table class="loginTable" cellpadding="0">
          <form id="login" method="post" action="managementLogin.php">
            <tbody>
              <tr>
                <td><input type="text" class="inputText" placeholder="帳號" name="user"></td>
                <td rowspan="2"><button name="managementSubmit" type="submit" class="LoginButton" style="background-color: #C4E1FF; height:50px;">管理員登入</button></td>
              </tr>
              <tr>
                <td><input type="password" class="inputText" placeholder="密碼" name="password"></td>
              </tr>
            </tbody>
          </form>
        </table>

        <div class="LoginErrorDiv">
          <?php
          if (isset($_POST['managementSubmit'])) {
            switch ($errorCode) {
              case 1:
                echo "請輸入帳號與密碼";
                break;
              case 2:
                echo "帳號或密碼錯誤";
                break;
              case 0:
                echo '<script>document.location.href="managementPage.php"</script>';
                break;
              default:
                echo "發生未知錯誤";
            }
          }
          ?>
        </div>
      </div>
    </div>

  </div>
</body>

</html>