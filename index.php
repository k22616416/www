<link href="style.css" rel="stylesheet" type="text/css">
<?php
$titleStr = '小農線上市集媒合系統';
$store = null;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">


  <title>
    <?php echo $titleStr; ?>
  </title>
</head>

<body>
  <div class="WebLayout">

    <div class="titleDiv">農產品販售區</div>
    <div class="WebNameDiv">
      小農<br>
      線上市集<br>
    </div>
    <div class="LoginArea">
      <table class="loginTable" cellpadding="0">
        <tbody>
          <tr>
            <td><input type="text" class="inputText" placeholder="帳號"></td>
            <td><button type="button" class="LoginButton" style="background-color: #C4E1FF;">會員登入</button></td>
          </tr>
          <tr>
            <td><input type="text" class="inputText" placeholder="密碼"></td>
            <td><button type="button" class="LoginButton" style="background-color: #FFD306;">小農登入</button></td>
          </tr>
        </tbody>
      </table>
      <button type="button" class="RegisterButton">註冊成為新的小農或會員</button>
    </div>

    <div class="TopDiv">
      <table class="SearchTable">
        <tbody>
          <tr>
            <td style="width: 100px; height:auto; text-align:right; font-size:larger; font-weight:bold;margin: auto 0% auto auto">農產品篩選</td>
            <td>
              <hr width="1" size=65px color="#000000" style="margin: 0% auto auto auto; width:1px;">
            </td>
            <td style="width: 500px; height:auto; text-align:left;">123</td>
          </tr>
        </tbody>
        <!-- Sql農產品篩選條件 -->
      </table>
    </div>
    <hr class="TopHr">

    </hr>


  </div>
</body>

</html>