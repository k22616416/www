<html>

<body>
    <Form Action="classicBookShareUpLoad.php" Method="POST" Enctype="multipart/form-data">
        <Input Type="File" Name="upfile"><br>
        <Input Type="Submit" value=" 開始上傳 ">
    </Form>
</body>

</html>
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