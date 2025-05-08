<?php
//Check session status
if (session_status() === PHP_SESSION_NONE) 
{
  session_start();
}
//Display alert message when logged out
if (isset($_GET["logout"]) && $_GET["logout"] == "true")
{
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> You are now logged out.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>';
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
            min-height: 433px;
        }
    </style>
    <title>iDiscuss - Coding Forums</title>
  </head>
  <body>
    <!-- Header -->
    <?php require "partials/_header.php"; ?>
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="img\aaron-burden-QJDzYT_K8Xg-unsplash.jpg" class="d-block w-100" alt="Study image" style="height: 400px; object-fit: cover">
            </div>
            <div class="carousel-item">
            <img src="img\jeshoots-com-pUAM5hPaCRI-unsplash.jpg" class="d-block w-100" alt="Study image" style="height: 400px; object-fit: cover">
            </div>
            <div class="carousel-item">
            <img src="img\thought-catalog-505eectW54k-unsplash.jpg" class="d-block w-100" alt="Study image" style="height: 400px; object-fit: cover">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="container">
        <h2 class="text-center my-4">Welcome to iDiscuss - Coding Forums</h2>
        <h3 class="text-center my-3">Categories</h3>
    </div>
    
    <!--Category cards -->
    <div class="container my-3" id="foot">
        <div class="row">
            <?php
            //Use a for loop to iterate through categories 
            $sql = "SELECT * FROM `categories`";
            $checkResult = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($checkResult))
            {
                    echo '<div class="col-md-4 mb-4">
                            <div class="card h-100" style="width: 18rem; margin: auto;">
                            <img src="img\karolina-grabowska-H_eb_VfG2Ow-unsplash.jpg" class="card-img-top" alt="Books image">
                                <div class="card-body text-center">
                                <h5 class="card-title"><a href="threadList.php?catId=' . $row["categoryId"] . '">' . $row["categoryName"] . '</a></h5>
                                <p class="card-text">' . $row["categoryDescription"] . '</p>
                                <a href="threadList.php?catId=' . $row["categoryId"] . '" class="btn btn-primary">View Threads</a>
                                </div>
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