<?php
require "partials/_createConnection.php";
//Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
if(!mysqli_query($conn, $sql))
{
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Failure. </strong> Error creating database: ' . mysqli_error($conn) .'
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>';
}
?>