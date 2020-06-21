<link href="style.css" rel="stylesheet" type="text/css">

<?php
if (isset($_POST['submit'])) {
    setcookie('test', '123', time() + 3600);
    unset($_POST['submit']);
    $_COOKIE['test'] = $_POST['test'];
} else if (isset($_POST['cancel'])) {
    setcookie('test', "", time() - 3600);
    unset($_COOKIE['test']);
    echo $_COOKIE['test'];
    unset($_POST['cancel']);
}

if ($_COOKIE['test2'] != null) {
    echo 'test2:' . $_COOKIE['test2'];
}
?>

<html>

<body>
    <form action="test.php" method="post" name="form">
        <input type="text" name="test" />
        <button type="submit" name="submit">save</button>
    </form>
    <form action="test.php" method="post" name="form">
        <button type="submit" name="cancel">cancel</button>
    </form>
    <script>
        console.log(document.cookie);
        document.cookie = "test2" + "=" + "123123;";
    </script>
</body>

</html>