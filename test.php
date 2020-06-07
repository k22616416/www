<!-- <html>

<body>
    <Form Action="classicBookShareUpLoad.php" Method="POST" Enctype="multipart/form-data">
        <Input Type="File" Name="upfile"><br>
        <Input Type="Submit" value=" 開始上傳 ">
    </Form>
</body>

</html> -->
<?php

echo '
                <table class="StoreInfoTable" id="storeInfoTemplate"';
if (0) echo 'style="background-color: #ADADAD;"';
echo '>
                <form name="commodity" id="commodity' . 1 . '" action="submitStoreFixedInfo.php"  method="post" align="center" style="margin:auto auto auto auto;">
                    <input type="hidden" name="commodityIndex" value="' . 3 . '"></input>
                    <tbody>
                        <tr>
                            <td rowspan="3" align="center" style="width: 100px; height:100px;">
                            <input style="width:70px;display:none;" type="file" name="imgInput" id="imgInput' . 1 . '" targetID="previewImg' . 1 . '"" onchange="readURL(this)" accept="image/gif, image/jpeg, image/png" />
                            <img id="previewImg' . 1 . '" src="image/carrot.png">
                            <span id="sql" style="font-size:smaller;">有機</span>
                            
                            </td>
                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td rowspan="3" id="sql">
                                <table style="border:0px; border-collapse:collapse; width:400px; height:100px; font-weight: bold; font-size:18px;">
                                    <tr style="border: 3px solid #000000; border-top:0px; border-right:0px; border-left:0px; ">

                                        <td style="border: 3px solid #000000; border-top:0px; border-left:0px; width:200px;">
                                            品名：<input name="CName" id="CName' . 1 . '"  value="' . '產品3' . '" style="width: 100px;" onkeydown="if(event.keyCode==13){return false;}"/></td>

                                        <td><input name="cash" id="cash' . 1 . '" value="' . 30 . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input>元/把</td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px;  border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px;">配銷地點：<input name="location" id="location' . 1 . '"  value="' . "123" . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></td>
                                        <td>運送方式：<input name="transport" id="transport' . 1 . '"   value="' . '配銷方式3' . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
                                    </tr>
                                    <tr style="border: 3px solid #000000; border-right:0px; border-bottom:0px; border-left:0px;">
                                        <td style="border: 3px solid #000000; border-left:0px; border-bottom:0px;">
                                            剩餘數量：<input name="maxCount" id="maxCount' . 1 . '"  value="' . 20 . '" style="width: 50px;" onkeydown="if(event.keyCode==13){return false;}"></input></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>

                            <td rowspan="3">
                                <hr width=" 3px" size=100px color="#000000" style="margin: 0% auto 0% auto; border: 0px;">
                            </td>
                            <td align="center" style="right:0px; position: relative; width: 100px; font-size:24px; font-weight: bolder; ">';
if (1)
    echo '<button type="button" name="fixedButton' . 1 . '" id="fixedButton' . 1 . '" onclick="fixed(' . 1 . ',' . true . ')" font color="blue" align="center" style=" font-size:24px; font-weight: bolder; background-color: #BEBEBE;">修<br>改</button>
                                <button type="button" name="submitButton' . 1 . '" id="submitButton' . 1 . '" onclick="fixed(' . 1 . ',' . false . ')" font color="blue" align="center" style=" font-size:16px; width:40px;font-weight: bolder; background-color: #53FF53;display:none;">提交修改</button>';
else
    echo '<div id="fixedButton' . 1 . '"  align="center" style="color:#EEEEEE; font-size:24px; font-weight: bolder; ">審<br>核<br>中</div>';

echo '</td>
                        </tr>
                    </tbody>
                </form>
            </table>';
?>
<script>
    function fixed(index, status) {
        var idStr = [
            "CName",
            "cash",
            "location",
            "transport",
            "maxCount",
            "imgInput"
        ];
        var name = [];
        var value = [];
        for (var i = 0; i < idStr.length; i++) {
            if (idStr[i] == "imgInput") continue;
            if (status)
                document.getElementById(idStr[i] + index).disabled = "";
            else
                document.getElementById(idStr[i] + index).disabled = "disabled";
            name[i] = document.getElementById(idStr[i] + index).name;
            value[i] = document.getElementById(idStr[i] + index).value;
        }

        if (!status) {
            document.getElementById("imgInput" + index).style.display = "none";
            document.getElementById("submitButton" + index).style.display = "none";
            document.getElementById("fixedButton" + index).style.display = "";
            for (var i = 0; i < idStr.length; i++) {
                console.log(document.getElementById(idStr[i] + index).value);
            }
            document.getElementById('commodity' + index).submit();

            // MakeForm(name, value);
        } else {
            document.getElementById("imgInput" + index).style.display = "";
            document.getElementById("submitButton" + index).style.display = "";
            document.getElementById("fixedButton" + index).style.display = "none";
        }
    }

    function MakeForm(name, value) {
        // 建立一個 form 
        var form1 = document.createElement("form");
        form1.enctype = "multipart/form-data";
        form1.id = "form1";
        form1.name = "form1";
        // 新增到 body 中 
        document.body.appendChild(form1);
        // 建立一個輸入 
        for (var i = 0; i < name.length; i++) {
            var input = document.createElement("input");
            // 設定相應引數 
            input.type = "text";
            input.name = name[i];
            input.value = value[i];
            // 將該輸入框插入到 form 中 
            form1.appendChild(input);
        }

        // form 的提交方式 
        form1.method = "post";
        // form 提交路徑 
        form1.action = "submitStoreFixedInfo.php";
        // 對該 form 執行提交
        form1.submit();
        // 刪除該 form 
        document.body.removeChild(form1);
    }
</script>
<!-- <html>

    <head>
        <script src="jquery-3.5.1.min.js"></script>

    </head>

    <body>
        <form action="/somewhere/to/upload" enctype="multipart/form-data">
            <input type="file" id="progressbarTWInput" accept="image/gif, image/jpeg, image/png" />
            <img id="previewImg" src="#" />
        </form>
    </body>
    <script>
        $("#progressbarTWInput").change(function() {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#previewImg").attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    </html> -->