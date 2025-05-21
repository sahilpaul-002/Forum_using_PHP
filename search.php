<?php
//Check session status
if (session_status() === PHP_SESSION_NONE) 
{
  session_start();
}

//Include/require the necessary files
require "partials/_dbCreate.php";
require "partials/_createTable.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        #foot {
            min-height: 443px;
        }
    </style>
    <title>iDiscuss - Coding Forums</title>
  </head>
  <body>
    <!-- Header -->
    <?php require "partials/_header.php"; ?>
    <!-- Display search results -->
    <div class="search my-5" id="foot">
        <h1 class="py-4">Search results for <?php echo htmlspecialchars($_GET["search"])?></h1>
        <div class="result">
            <?php
              //Capture the category id from the url
              $search = htmlspecialchars($_GET["search"]);
              $sql = "SELECT * FROM `threads` WHERE MATCH(`threadTitle`,`threadDescription`) AGAINST ('\"$search\"')";
              $result = mysqli_query($conn, $sql);
              //Display the category information using the category id
              $noResult = true;
              while ($row = mysqli_fetch_assoc($result))
              {
                $noResult = false;
                $threadTitle = $row["threadTitle"];
                $threadDescription = $row["threadDescription"];
                echo '<div class="media mt-4">
                <img src="img\default user.png" width="34px" class="mr-3" alt="Default user">
                <div class="media-body">
                <h5 class="mt-0"><a href="thread.php?threadId=' . $row["threadId"] . '">' . $threadTitle . '</a></h5>
                ' . $threadDescription .'
                  </div>
                </div>';
                }
                if ($noResult)
                {
                  echo '<div class="jumbotron jumbotron-fluid">
                  <div class="container">
                  <p class="display-4">No threads found!</p>
                  </div>
                  </div>';
                }          
            ?>
        </div>
    </div>

    <?php require "partials/_footer.php"; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>