<?php
if (isset($_POST['submit'])) {
    echo $_POST['input'];
    unset($_POST['submit']);
}

?>

<form name="form1" method="post" action="">
    <input type="text" name="input" value="123"></input>
    <input name="submit" type="submit"> </input>
</form>
<form name="form1" method="post" action="">
    <input type="text" name="input" value="456"></input>
    <input name="submit" type="submit"> </input>
</form>