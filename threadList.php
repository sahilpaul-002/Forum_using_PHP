<?php
    require "partials/_dbCreate.php";
    require "partials/_createTable.php";
 
    if(false) {}
    else
    {
        //Actions on post request
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //Check session status
            if (session_status() === PHP_SESSION_NONE) 
            {
                session_start();
            }
            //Check if the user is logged in
            if(!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] != true)
            {
                header("Location: login.php?login=false");
                exit;
            }
            $catId = $_GET["catId"];
            $threadTitle = $_POST["questionTitle"];
            $threadDescription = $_POST["questionDescription"];
            $sessionUserId = $_SESSION["userId"];
            // Making the input text protected before inserting into the database
            $threadTitle = str_replace(
                ["<",">", "'", '"'],
                ["&lt","&gt;", "&#39;", "&quot;"],
                $threadTitle
            );
            $threadDescription = str_replace(
                ["<",">", "'", '"'],
                ["&lt","&gt;", "&#39;", "&quot;"],
                $threadDescription
            );

            $sql = "INSERT INTO `threads` (`threadTitle`, `threadDescription`, `threadCategoryId`, `threadUserId`) VALUES 
            ('$threadTitle', '$threadDescription', '$catId', '$sessionUserId')";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                // Redirect on success to avoid form resubmission
                header("Location: threadList.php?catId=" . $catId . "&success=true");
                exit();
            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Your thread could not be added. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }
        }
    }
    if(isset($_GET["success"]) && $_GET["success"] === "true")
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added successfully.
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
    <style>
        #foot {
            min-height: 433px;
        }
    </style>
    <title>iDiscuss - Threads List</title>
</head>

<body>
    <!-- Header -->
    <?php require "partials/_header.php"; ?>

    <!--Threads page header -->
    <div class="container my-3">
        <!--Threads header display logic -->
        <?php
            //Capture the category id from the url
            $catId = $_GET["catId"];
            $sql = "SELECT * FROM `categories` WHERE `categoryId` = '$catId'";
            $result = mysqli_query($conn, $sql);
            //Display the category information using the category id
            while ($row = mysqli_fetch_assoc($result))
            {
                $catName = $row["categoryName"];
                $catDesc = $row["categoryDescription"];
            }
        ?>
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catName; ?> forum</h1>
            <p class="lead"><?php echo $catDesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each others.</p>
            <a class="btn btn-dark btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    
    <!-- Post threads -->
    <div class="container">
        <h1 class="py-2">Start a discussion</h1>
            <div class="container">
            <form action="<?php echo $_SERVER['REQUEST_URI']?>"  method="POST">
                <div class="form-group">
                    <label for="questionTitle">Question Title</label>
                    <input type="text" class="form-control" name = "questionTitle" stionTitle" aria-describedby="questionTitleHelp">
                    <small id="questionTitleHelp" class="form-text text-muted">Keep the title short and crisp</small>
                </div>
                <div class="form-group">
                    <label for="questionDescription">Ellaborate your concern</label>
                    <textarea class="form-control" name ="questionDescription" id="questionDescription" rows="6"></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
            </div>
        </h1>
    </div>

    <!--Threads display logic -->
    <div class="container my-3" id="foot">
        <h1 class="py-2">Browse question</h1>
        <?php
            //Capture the category id from the url
            $catId = $_GET["catId"];
            $sql = "SELECT * FROM `threads` WHERE `threadCategoryId` = '$catId'";
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
                    <p class="lead">Be the first person to ask a question.</p>
                </div>
                </div>';
            }   
        ?>
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