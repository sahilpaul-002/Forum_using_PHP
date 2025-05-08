<?php
    //Check session status
    if (session_status() === PHP_SESSION_NONE) 
    {
        session_start();
    }
    // Include/require the necessary files
    require "partials/_dbCreate.php";
    require "partials/_createTable.php";
    //Display alert message when not logged in 
    if (isset($_GET["login"]) && $_GET["login"] == "false")
    {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>You are not a user!</strong> Please login to engage in discussions.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }
?>
<?php
    // Action on post method
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Include/require the necessary files
        // require "partials/_dbCreate.php";
        // require "partials/_createTable.php";

        $userName = $_POST["signupUsername"];
        $userEmail = $_POST["signupEmail"];
        $password = $_POST["signupPassword"];
        $confirmPassword = $_POST["signupConfirmPassword"];

        //Check if username and user email already exists
        $sql = "SELECT * FROM `users` WHERE `userName` = '$userName'";
        $checkResult1 = mysqli_query($conn, $sql);
        $sql = "SELECT * FROM `users` WHERE `userEmail` = '$userEmail'";
        $checkResult2 = mysqli_query($conn, $sql);
        //Check if username already exists
        if(mysqli_num_rows($checkResult1) > 0)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Username already exists. Please try another username.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        else if(mysqli_num_rows($checkResult2) > 0)
        {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> User email already exists. Please try another email.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        else
        {
            //Check if password and confirm password are empty
            if(empty($password) || empty($confirmPassword))
            {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Password cannot be empty. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }
            else
            {
            //Check if password and confirm password are same
            if($password == $confirmPassword)
            {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                //Insert the user into the database
                $sql = "INSERT INTO `users` (`userName`, `userEmail`, `userPassword`) VALUES ('$userName', '$userEmail', '$passwordHash')";
                $result = mysqli_query($conn, $sql);
                //Check if the query was successful to show alert message
                if($result)
                {
                    $showAlert = true;
                    //Redirect to stop resubmission of form
                    header("Location: /Forum/signup.php?success=true");
                    exit();
                }
                else
                {
                    $showAlert = false;
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Your account is not created. Please try again.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>';
                }
            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Password do not match. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }
        }
    }
}
    //Display success message
    if (isset($_GET["success"]) && $_GET["success"] === "true")
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is created. You can login.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
    }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>