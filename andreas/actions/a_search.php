<?php

  if (!empty($_POST['searchstr'])) {
    $sql = "SELECT isbn, title, type, status, name, surname FROM media
            LEFT JOIN author ON media.fk_authorID = author.authorID
            WHERE title LIKE '%".$str."%' OR ((name LIKE '%".$str."%')
            OR (surname LIKE '%".$str."%') ORDER BY surname) ORDER BY title;";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<tr>
          <th scope=\"row\">'.$row['isbn'].'</th>
          <td>'.$row['title'].'</td>
          <td>'.$row['name'].' '.$row['surname'].'</td>
          <td>'.$row['type'].'</td>
          <td>'.$status[$row['status']].'</td>
        </tr>';
      }
    }
  } else {
    /*$sql = 'SELECT isbn, title, type, status, name, surname FROM media
                    LEFT JOIN author ON media.fk_authorID = author.authorID;';
    $status = array('avail', 'reserved');
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<tr>
          <th scope=\"row\">'.$row['isbn'].'</th>
          <td>'.$row['title'].'</td>
          <td>'.$row['name'].' '.$row['surname'].'</td>
          <td>'.$row['type'].'</td>
          <td>'.$status[$row['status']].'</td>
        </tr>';
      }
    }*/
  }
