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
