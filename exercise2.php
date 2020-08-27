<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>exercise 2</title>
  <style type="text/css">
    table, th, td {
      border: 1px solid black;
    }
    td {
      padding: 0 10px;
    }
    .rn {
      background: #ccc;
    }
  </style>
</head>
<body>
  <?php
    /**
     * @param $result - требуется чистый результат $con->query()
     * @param string $title
     */
    function printTableFromSelect($result, $title="Раскрыть содержимое") {
      print "<details>";
      print "<summary>$title</summary>";
      print "<table>";
      print "<tbody>";
      $row = $result->fetch(PDO::FETCH_ASSOC);
      print "<tr>";
      print "<th>rn</th>";
      foreach ($row as $field => $value) {
        print "<th>$field</th>";
      }
      print "</tr>";
      $data = $result;
      $data->setFetchMode(PDO::FETCH_ASSOC);
      foreach ($data as $index => $row) {
        print "<tr>";
        print "<td class='rn'>".($index+1)."</td>";
        foreach ($row as $name => $value) {
          print "<td>$value</td>";
        }
        print "</tr>";
      }
      print "</tbody>";
      print "</table>";
      print "</details>";
    }

    function generateRandomString($length=10) {
      //$charset = "абвгдеёжзиклмнопрстуфхцчшщьыъэюя"; //когда php исполняется на маке он некорректно обрабатывает русские буквы
      $charset = "abcdefghijklmnopqrstuvwxyz"; //поэтому я сделал через английские, но уверен суть задания я не изменил
      $charsetLength = strlen($charset);
      $randomString = '';
      for ($i=0; $i<$length; $i++) {
        $randomString .= $charset[rand(0, $charsetLength-1)];
      }
      return ucfirst($randomString);
    }

    try {
      $con = new PDO("mysql:host=localhost;dbname=mysql", "antonov", "antonov");
      $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

      /**
       * Задание 1
       */
      $query = "create table if not exists users(
            id int(10) not null auto_increment,
            name char(30) not null,
            age smallint(6) not null,
            primary key (id)
          )";
      $result = $con->exec($query);
      $result = $con->exec("truncate table users");

      print "<h3>Задание 1.</h3>";
      print "<h4>вставить 1000 разных строчек</h4>";

      $con->exec("set names utf8");
      foreach (range(1, 1000) as $number) {
        $statement = $con->prepare("insert into users(name, age) values(:name, :age)");
        $statement->bindParam(":name", generateRandomString(6), PDO::PARAM_STR, 6);
        $statement->bindParam(":age", rand(10,100), PDO::PARAM_INT);
        $statement->execute();
      }

      $result = $con->query("select * from users");
      printTableFromSelect($result, "Содержимое таблицы users [".$result->rowCount()."]");
      /**
       */

      /**
       * Задание 2
       */
      print "<h3>Задание 2.</h3>";
      print "<h4>строки таблицы users, где age>50</h4>";

      $query = "select * from users where age>50";

      $resultAsArray = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);

      print "<details>";
      print "<summary>Содержимое запроса в виде массива [".sizeof($resultAsArray)."]</summary>";
      print_r($resultAsArray);
      print "</details>";

      $result = $con->query($query);
      printTableFromSelect($result, "Содержимое запроса в виде таблицы [".$result->rowCount()."]");
      /**
       */

      /**
       * Задание 3
       */
      print "<h3>Задание 3.</h3>";
      print "<h4>строки где есть буквосочетание \"av\" или \"ab\"</h4>"; //смотреть 52-53 строчки этого кода

      $query = "select * from users where name like '%av' or name like '%ab%'";

      $resultAsArray = $con->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $resultAsJson = json_encode($resultAsArray);

      print "<details>";
      print "<summary>Содержимое запроса в виде json [".sizeof($resultAsArray)."]</summary>";
      print_r($resultAsJson);
      print "</details>";
      /**
       */

      /**
       * Задание 4
       */
      print "<h3>Задание 4.</h3>";
      print "<h4>обновить строки, где age>70 на Pepito</h4>";

      $query = "select * from users where age>70";
      $result = $con->query($query);
      printTableFromSelect($result, "Строки, которые подлежат обновлению [".$result->rowCount()."]");

      $query = "update users set name='Pepito' where age>70";
      $result = $con->exec($query);

      $query = "select * from users";
      $result = $con->query($query);
      printTableFromSelect($result, "Содержимое таблицы users после обновления [".$result->rowCount()."]");
      /**
       */

      /**
       * Задание 5
       */
      print "<h3>Задание 5.</h3>";
      print "<h4>вывести все уникальные имена (name)</h4>";

      $query = "select distinct name from users";
      $result = $con->query($query);
      printTableFromSelect($result, "Содержимое запроса в виде таблицы [".$result->rowCount()."]");
      /**
       */

    } catch (PDOException $e) {
      echo 'ERROR: '.$e->getMessage();
    }
  ?>
</body>
</html>