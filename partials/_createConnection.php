<?php
//Create a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "idiscuss";
$port = 3307; // Default MySQL port is 3306, but XAMPP uses 3307 for MySQL
$conn = mysqli_connect($servername, $username, $password, "", $port);
if (!$conn)
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Failed to create connection with server: ' . mysqli_connect_error() . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    die("Connection failed: " . mysqli_error($conn));
}
?>