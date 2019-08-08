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
        <span class="col-7">You're logged in as: <b><?php echo $_SESSION['user'] . "</b> (as an " . $_SESSION['userStatus'] . ")"; ?></span>
        <span class="col-3 mr-1"><input type="text" name="searchstr" id="search" style="padding: 0.5rem;" value="" placeholder="search..."></span>
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
        <tbody id="searchresult">
          <?php
            $sql = 'SELECT isbn, title, type, status, name, surname FROM media
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
            }
           ?>
        </tbody>
      </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
            crossorigin="anonymous">
    </script>
    <script>
      document.ready(function() {
        // Variable to hold request
        var request;

        // Bind to the submit event of our form
        $("#searchresult").submit(function(event){

           // Prevent default posting of form - put here to work in case of errors
           event.preventDefault();

           // Abort any pending request
           if (request) {
               request.abort();
           }
           // setup some local variables
           var $form = $(this);

           // Let's select and cache all the fields
           var $inputs = $form.find("input");

           // Serialize the data in the form
           var serializedData = $form.serialize();

           // Let's disable the inputs for the duration of the Ajax request.
           // Note: we disable elements AFTER the form data has been serialized.
           // Disabled form elements will not be serialized.
           $inputs.prop("disabled", true);

           // Fire off the request to /form.php
           request = $.ajax({
               url: "a_search.php",
               type: "post",
               data: serializedData
           });

           // Callback handler that will be called regardless
           // if the request failed or succeeded
           request.always(function () {
               // Reenable the inputs
               $inputs.prop("disabled", false);
           });
        });
      });
    </script>
  </body>
</html>
