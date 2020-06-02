<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '小農註冊頁面';
$store = null;
$member = 0;
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
      <div class="WebNameDiv">
        小農<br>
        線上市集<br>
      </div>

      <button style="position: absolute; top:15px; left:210px; width:100px">轉至<?php if ($member == 0) echo '小農';
                                                                              else echo '會員'; ?>申請頁面</button>

      <div class="TopDiv">
        <div class="registerTopDiv">填寫基本資料</div>

      </div>

      <hr class="TopHr">
      </hr>
    </div>
    <button id="button" style="position: fixed;bottom:0px;">Click me</button>

    <div class="mainDiv" style="  min-height:500px; width:600px;">

      <table>
        <tbody>
          <tr>
            <td>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">使用者帳號：</td>
                    <td class="registerTd"><input type="text" style="margin: auto 0 auto auto;"></td>
                  </tr>
                </tbody>
              </table>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">使用者密碼：</td>
                    <td class="registerTd"><input type="password" style="margin: auto 0 auto auto;"></td>
                  </tr>
                </tbody>
              </table>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">密碼確認：</td>
                    <td class="registerTd"><input type="password" style="margin: auto 0 auto auto;"></td>
                  </tr>
                </tbody>
              </table>
            </td>
            <td>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">連絡電話：</td>
                    <td class="registerTd"><input class="registerInputText" type="text"></td>
                  </tr>
                </tbody>
              </table>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">Email：</td>
                    <td class="registerTd"><input class="registerInputText" type="text"></td>
                  </tr>
                </tbody>
              </table>
              <table class="registerInput">
                <tbody>
                  <tr>
                    <td style="font-size:larger; font-weight:bolder;">住址：</td>
                    <td class="registerTd"><input class="registerInputText"></td>
                  </tr>
                </tbody>
              </table>

            </td>
          </tr>
        </tbody>
      </table>
      <table class="registerInput">
        <tbody>
          <tr>
            <td style="font-size:larger; font-weight:bolder;">地圖經緯度：</td>
            <td class="registerTd"><input class="registerInputText"></td>
          </tr>
          <tr>
            <td colspan="3">
              <div class="googleMapDiv" style="width: 300px; height:300px; background-color:rgba(255,255,255,0.70); border:1px solid #000000;">123</div>
            </td>
          </tr>
        </tbody>
      </table>
      <div style="position: absolute; bottom:20px; right:50px;">
        <button style="width: 100px; height:50px; background-color:cornflowerblue;  font-weight:bolder; font-size:30px;">送出</button>
        <button style="width: 100px; height:50px; background-color:crimson; font-weight:bolder; font-size:30px;">清除</button>
      </div>

    </div>


  </div>
</body>

</html>