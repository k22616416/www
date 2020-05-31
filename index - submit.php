<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500&display=swap" rel="stylesheet">
</head>
<style>
  * {
    text-align: center;
    font-size: 16px;
    font-family: 'Noto Sans TC', sans-serif;
  }

  .show-todo {
    padding: 2rem;
  }

  .title-add {
    padding: 1rem;
  }

  .title-add>input {
    width: 30rem;
  }

  .show-item {
    background-color: beige;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: row;
    flex-wrap: wrap;
  }

  .show-item>div {
    flex: 0 0 100%;
  }

  button {
    background-color: #e0000000;
    border: #e0000000;
  }

  button:focus {
    outline: 0;
  }

  button:hover {
    background-color: #eeeeee;
  }
</style>

<body>
  <div class="show-todo">
    <?php

    $conn = new mysqli('127.0.0.1:3306', 'root', '', 'todo');
    if (!$conn) {
      die("資料庫連線失敗<br>");
    } else {
      echo "資料庫連線成功<br>";
    }

    $sql = "SELECT * FROM list";

    if (isset($_POST['submit'])) {
      if (empty($_POST['newTask'])) {
        echo "empty!";
      } else {
        $task = $_POST['newTask'];
        //$insertQuery = "INSERT INTO list(title) VALUES ('$task');";
        echo $task;
        $conn->query($insertQuery);
        header('localhost: index.php');
      }
    }

    if (isset($_GET['delTask'])) {
      $task = $_GET['delTask'];
      $deleteQuery = "DELETE FROM list WHERE id=$task";
      $conn->query($deleteQuery);
      header('location: index.php');
    }
    ?>
    <h1 style="font-size: 48px;">備忘錄地下城</h1>
    <form class="title-add" method="post" action="index.php">
      <input name="newTask" type="text" placeholder="title..." />
      <button name="submit" type="submit">ADD</button>
    </form>
    <div class="show-item">
      <table>
        <tr>
          <th width="200">id</th>
          <th width="500">title</th>
          <th width="200">active</th>
        </tr>

        <?php
        $data = $conn->query($sql);
        if ($data->num_rows > 0) {
          foreach ($data as $key => $item) {
            echo "<tr>";
            echo "<td>" . ($key + 1) . "</td><td>" . $item['title'] . "</td>";
            echo "<td><a href=index.php?delTask=" . $item['id'] . ">X</a></td>";
            echo "</tr>";
          }
        } else {
          echo '0筆資料';
        }
        ?>
      </table>
    </div>
  </div>
</body>

</html>