<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js" async></script>
<?php
$titleStr = '買菜籃';
$store = null;
?>

<!DOCTYPE html>
<html>

<head> <meta charset="UTF-8">


  <title>
    <?php echo $titleStr ?>
  </title>
</head>

<body>

  <div class="WebLayout">
    <div class="topArea">
      <div class="titleDiv"><?php echo $titleStr ?></div>
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
          <form class="title-add" method="post" action="buyCarResult.php">
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


      </div>

      <hr class="TopHr">+
      </hr>
    </div>

    <!--透過SQL增加賣場資訊-->
    <div class="mainDiv">
    <center>
      <div style="width:500px;border:1px 	#84C1FF solid;border-radius:10px;padding:16px;background-color:white;">
          <div style="width:400px;text-align:left;">
          <b>您的總金額為：40美元<br>
          請於三日內匯款至以下帳號。<br></b>      
          </div>
          <div style="width:400px;background-color:	#FCFCFC;border:1px #272727 solid;text-align:left;">
            <div style="width:400px;background-color:	#FCFCFC;border:1px #272727 solid;text-align:left;">匯款資訊如下：</div>
            <div style="width:400px;background-color:	#FCFCFC;border:1px #272727 solid;text-align:left;">銀行代碼000</div>
            <div style="width:400px;background-color:	#FCFCFC;border:1px #272727 solid;text-align:left;">匯款帳號 123456789 123456789</div>
          </div>
        </div>
    </center>
    
     <table class="loginTable" cellpadding="0" >
          
    </table>  
    
    <table class="loginTable" cellpadding="0" >

    </table>
    <tr>
    <center>
    <br>
      <td><b><button type="button" onclick="javascript:location.href='buyCarResult.php'"class="RegisterButton"style="width:110px;height:30px;font-size:17px;border-radius:8px;"><font face="微軟正黑體"color="white">返回</font></button></b></td>
    </center>
    </tr>     

    </div>
  </div>
</body>

</html>