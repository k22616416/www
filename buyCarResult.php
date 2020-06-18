<?php session_start(); ?>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '買菜籃';
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

      <div class="LoginArea">
        <!-- 判斷有沒有登入 -->

        <?php
        if (isset($_POST['logout'])) {
          unset($_POST['logout']);
          unset($_SESSION['user']);
          unset($_SESSION['name']);
          unset($_SESSION['member']);
          echo '<script>document.location.location=location</script>';
        } else if ($_SESSION['user'] != null) {
          $loginStatus = true;
          $loginMember = $_SESSION['member'];
          $infoName = $_SESSION['name'];
          $userName = $_SESSION['user'];
          $farmStoreNumber = $_SESSION['farmStoreNumber'];
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
                $errorCode = 0;
                $_SESSION['user'] = $userName;
                $_SESSION['name'] = $sqlArray['姓名'];
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
              <form method="post" action="buyCarResult.php">
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
          <form id="login" class="title-add" method="post" action="buyCarResult.php">
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
        <table border="0" width="600" high="70">
          　 <tr>
            　 <td>
              <h3 id="totalCount">總購買數量：</h3>
            </td>
            <td>
              <p align="right">
                <h3 id="totalCash">總金額：</h3>
              </p>
            </td>
            　
          </tr>
        </table>

      </div>

      <hr class="TopHr">
      </hr>
    </div>

    <!--透過SQL增加賣場資訊-->
    <div class="mainDiv">
      <div style="margin:10px auto auto auto;">
        <form name="buyCarResult" id="buyCarResult" method="post" action="buyCarInser.php">
          <div>
            <span style="font-size: larger; ">請選擇運送方式</span><br>
            <select name="transport" id="transport" style="font-size: larger; ">
              <option value=""></option>
              <option value="郵寄">郵寄</option>
              <option value="面交">面交</option>
            </select>
            <br>
            <span style="font-size: larger; ">請輸入運送地址(如面交則無需填寫)</span><br>
            <input type="text" name="position" id="position" value="" style="font-size: medium; width:500px;" />
          </div>
          <table class="buyCarResultTable" rules="all" cellpadding='5'>
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
              <?php

              if (isset($_SESSION['buyCarList'])) {
                $list = unserialize($_SESSION['buyCarList']);
                debug(print_r($list, true));
                $totalCount = 0;
                $totalCash = 0;
                for ($i = 0; $i < count($list, COUNT_NORMAL); $i++) {
                  // if (!is_array($list[$i])) continue;
                  echo '<tr>
                        <input type="hidden" name="seller" value="' . $list[$i]['seller'] . '"/>
                        <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                          <p align="center"><b>' . $list[$i]['name'] . '</b></p>
                        </td>
                        <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                          <p align="center"><b>' . $list[$i]['CCash'] . '</b></p>
                        </td>
                        <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                          <p align="center"><b>' . $list[$i]['count'] . '</b></p>
                        </td>
                        <td bgcolor="#FFFFFF" width="140" high="50" align="center" valign="center">
                          <p align="center"><b>' . $list[$i]['CCash'] * $list[$i]['count'] . '</b></p>
                        </td>
                      </tr>';
                  $totalCash += $list[$i]['CCash'] * $list[$i]['count'];
                  $totalCount += $list[$i]['count'];
                }
                echo '<tr>
                      <td bgcolor="#FFFF33" colspan="1" width="140">
                        <p align="center"><b>總金額</b></p>
                      </td>
                      <td bgcolor="#FFFF33" colspan="2" width="270">
                        
                      </td>
                      <td bgcolor="#FFFF33" colspan="1" width="140">
                        <p align="center"><b>' . $totalCash . '</b></p>
                      </td>
                      </tr>';
                echo '<script>
                      document.getElementById("totalCount").innerHTML = "總購買數量：' . $totalCount . '";
                      document.getElementById("totalCash").innerHTML = "總金額：' . $totalCash . '";
                      </script>
                      <input type="hidden" name="totalCash" value="' . $totalCash . '"/>
                      ';
              }
              ?>

            </tbody>
          </table>
        </form>
        <button type="button" class="RegisterButton" onclick="buyTheOrder(<?php if (isset($_SESSION['buyCarList'])) echo 'true';
                                                                          else echo 'false';  ?>)" style="width:110px; height:30px; font-size:17px; border-radius:8px; position:absolute; top:5px; right:5px;">
          結帳
        </button>
        <div id="loginRemind" style="width:200px; text-align:center; position:absolute; top:5px; right: 50%; margin-right:-100px; background-color:rgba(255,255,255,0.7); color:red; font-size:20px; font-weight: bolder; <?php if ($loginStatus) echo 'display:none'; ?>">
          請先登入
        </div>
      </div>

    </div>
    <script>
      function buyTheOrder(empty) {
        if (!empty) {
          alert("錯誤!\n購物車內沒有商品，將返回首頁。");
          document.location.href = "index.php";
          return false;
        }
        var pos = document.getElementById("position").value;
        var port = document.getElementById("transport").value;
        if (pos == "" || port == "") {
          alert("請選擇配送方式並輸入地址!");
          return false;
        }
        document.getElementById("buyCarResult").submit();
      }
    </script>
  </div>
</body>

</html>