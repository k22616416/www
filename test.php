<link href="style.css" rel="stylesheet" type="text/css">
<html>

<body>
    <table class="StoreInfoTable" rules="all" id="storeInfoTemplate" style="width:500px;">
        <form id="entryStore' . $i . '" method="post" action="storePage.php">
            <tbody>
                <tr>
                    <td rowspan="2" style="width:70px;"><img src="image/user.png" /><button class="StoreHrefText">進入此賣場</button></td>
                    <td colspan="2" style="width:auto;">使用者帳號：</td>
                    <td>瀏覽次數：</td>
                    <td>已成交訂單數：</td>
                </tr>
                <tr>
                    <td colspan="3">農場簡介：</td>
                    <td><button>查看該賣場<br>訂單資訊</button></td>
                </tr>
            </tbody>
        </form>
    </table>
</body>

</html>