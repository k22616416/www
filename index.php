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
            <td><input type="text" class="inputText" placeholder="帳號" name="user"></td>
            <td><button type="button" class="LoginButton" style="background-color: #C4E1FF;">會員登入</button></td>
          </tr>
          <tr>
            <td><input type="password" class="inputText" placeholder="密碼" name="password"></td>
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
              <hr width="1" size=65px color="#000000" style="margin: 0% auto auto 0%; width:1px;">
            </td>
            <!-- Sql農產品篩選條件 -->
            <td><input type="checkbox" name="" value="">123</td>
            <td><input type="checkbox" name="" value="">123</td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr class="TopHr">
    </hr>

    <div class="mainDiv">
      <div class="StoreInfoDiv">
        <table class="StoreInfoTable">
          <tbody>
            <td style="width:100px;">
              <table class="StoreInfoTable" style="border: 0px solid #000000; width: 100px;">
                <tbody>
                  <tr>
                    <td style="height:70px; width:70px;"><a href=""><img src="image/user.png" alt="123"></a></td> <!-- Sql賣場圖片&連結-->
                  </tr>
                  <tr>
                    <td style="height:30px; width:70px;"><a href="" style="font-size:18px; color:#00bfff; font-weight: bold; text-align: center;">進入此賣場</a></td> <!-- Sql賣場連結-->
                  </tr>
                </tbody>
              </table>
            </td>
            <td style="width: 3px;">
              <hr width=" 1px" size=108px color="#000000" style="margin: 0% auto 0% auto; ">
            </td>
            <td>
              <div style="width: auto;">//賣場資訊</div> <!-- Sql賣場資訊 -->
            </td>
            <td style="width: 3px;">
              <hr width="1px" size=108px color="#000000" style="margin: 0% auto 0% auto; ">
            </td>
            <td style="width: 100px;">
              <table class="StoreInfoTable" style="width: 100px; position: relative;left:0px;">
                <tbody>
                  <tr style="height:50; width:100px; font-size:14px;">
                    <td>已成交訂單數:000</td> <!-- Sql賣場訂單數-->
                  </tr>
                  <tr>
                    <td>
                      <hr style="margin: auto 0% auto 0%; height:2px;  border:0px; background-color: #000000;">
                    </td>
                  </tr>
                  <tr style="height:50; width:100px; font-size:14px;">
                    <td>瀏覽次數:000</td> <!-- Sql賣場瀏覽次數-->
                  </tr>
                </tbody>
              </table>
            </td>
          </tbody>
        </table>


      </div>

    </div>


  </div>
</body>

</html>