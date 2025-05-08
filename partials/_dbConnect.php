<?php
require "partials/_createConnection.php";

//Connect to database
mysqli_select_db($conn, $dbName);
if(!$conn)
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to create connection with database: ' . mysqli_error($conn) . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    die("Connection failed: " . mysqli_error($conn));
}
?>