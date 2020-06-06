<html>

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

</html>