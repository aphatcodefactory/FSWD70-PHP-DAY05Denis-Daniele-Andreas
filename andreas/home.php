<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <?php
      ob_start();
      session_start();
    ?>

    <title>Big Library</title>
  </head>
  <body>
    <div class="container">
      <h1 class="text-center text-danger">Big Library</h1>
      <div class="row" style="margin-bottom: 1rem;">
        <span class="col-11">You're logged in as: <b><?php echo $_SESSION['user'] . "</b> (as an " . $_SESSION['userStatus'] . ")"; ?></span>
        <a href="actions/a_logout.php" class="col-1 btn btn-danger">Logout</a>
      </div>
      <table class="table table-dark">
        <thead>
          <tr>
            <th scope="col">ISBN</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sql = 'SELECT isbn, title, type, status, name, surname FROM media LEFT JOIN author ON media.fk_authorID = author.authorID;';
            //$sql = "SELECT isbn, title, fk_authorID, type, status FROM media;";
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
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>
</html>
