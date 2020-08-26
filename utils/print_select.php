<!DOCTYPE html>
<html lang="en-US">
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
<table>
  <tbody>
  <?php
  try {
    $con = new PDO("mysql:host=localhost;dbname=mysql", "antonov", "antonov");
    $query = "show tables;";
    $result = $con->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    print "<tr>";
    print "<th>rn</th>";
    foreach ($row as $field => $value) {
      print "<th>$field</th>";
    } // end foreach
    print "</tr>";
    //second query gets the data
    $data = $con->query($query);
    $data->setFetchMode(PDO::FETCH_ASSOC);
    //foreach ($data as $row) {
    foreach ($data as $index => $row) {
      print "<tr>";
      print "<td class='rn'>".($index+1)."</td>";
      foreach ($row as $name => $value) {
        print "<td>$value</td>";
      } // end field loop
      print "</tr>";
    } // end record loop
  } catch (PDOException $e) {
    echo 'ERROR: '.$e->getMessage();
  } // end try
  ?>
  </tbody>
</table>
</body>
</html>