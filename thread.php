<!-- Inserting data into the database logic -->
<?php
    //Include/require the necessary files
    require "partials/_dbCreate.php";
    require "partials/_createTable.php";

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
            $threadId = $_GET["threadId"];
            $commentContent = $_POST["commentTextArea"];
            $sessionUserId = $_SESSION["userId"];
            // Making the input text protected before inserting into the database
            $commentContent = str_replace(
                ["<",">", "'", '"'],
                ["&lt","&gt;", "&#39;", "&quot;"],
                $commentContent
            );
            $sql = "INSERT INTO `comments` (`commentContent`, `commentThreadId`, `commentUserId`) VALUES 
            ('$commentContent', '$threadId', '$sessionUserId')";
            $result = mysqli_query($conn, $sql);
            if ($result)
            {
                // Redirect on success to avoid form resubmission
                header("Location: thread.php?threadId=" . $threadId . "&success=true");
                exit;
            }
            else
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Your comment could not be added. Please try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>';
            }
        }
    }
       //Display success message by checking the yrl
       if (isset($_GET["success"]) && $_GET["success"] === "true") {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added successfully.
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
    <title>iDiscuss - Threads</title>
</head>

<body>
    <!-- Header -->
    <?php require "partials/_header.php"; ?>

    <!--Threads page header -->
    <div class="container my-3">
        <!--Threads header display logic -->
        <?php
            //Capture the category id from the url
            $threadId = $_GET["threadId"];
            $sql = "SELECT * FROM `threads` WHERE `threadId` = '$threadId'";
            $result = mysqli_query($conn, $sql);
            //Display the category information using the category id
            while ($row = mysqli_fetch_assoc($result))
            {
                $threadTitle = $row["threadTitle"];
                $threadDescription = $row["threadDescription"];
            }
        ?>
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $threadTitle; ?></h1>
            <p class="lead"><?php echo $threadDescription; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each others.</p>
            <?php
                //Get the user id from the threads table and use it to get the user name from the users table
                $threadId = $_GET["threadId"];
                $sql = "SELECT `threadUserId` FROM `threads` WHERE `threadId` = '$threadId'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $userId = $row['threadUserId'];

                //Get the username
                $sql = "SELECT `userName` FROM `users` WHERE `userId` = '$userId'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
            ?>
            <p>Posted by: <?php echo $row["userName"]; ?></p>
        </div>
    </div>
    
    <!-- Post comment -->
    <div class="container">
        <h1 class="py-2">Post a comment</h1>
            <div class="container">
            <form action="<?php echo $_SERVER["REQUEST_URI"]?>" method="POST">
                <div class="form-group">
                    <label for="commentTextArea">Type your comment</label>
                    <textarea class="form-control" name ="commentTextArea" id="commentTextArea" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
            </div>
        </h1>
    </div>

    <!--Comments display logic -->
    <div class="container my-3" id="foot">
        <h1 class="py-2">Comments</h1>
        <?php
            //Capture the category id from the url
            $threadId = $_GET["threadId"];
            $sql = "SELECT * FROM `comments` WHERE `commentThreadId` = '$threadId'";
            $result1 = mysqli_query($conn, $sql);
            //Display the category information using the category id
            $noResult = true;
            while ($row1 = mysqli_fetch_assoc($result1))
            {
                $noResult = false;
                $commentContent = $row1["commentContent"];
                $userId = $row1["commentUserId"];
                $sql = "SELECT `userName` FROM `users` WHERE `userId` = '$userId'";
                $result2 = mysqli_query($conn, $sql);
                $row2 = mysqli_fetch_assoc($result2);
                $userName = $row2["userName"];
                echo '<div class="media mt-4">
                    <img src="img\default user.png" width="34px" class="mr-3" alt="Default user">
                    <div class="media-body">
                        <p class="mb-0">' . $commentContent .'</p>
                        <p class="font-weight-bold my-0">by - ' . $userName . '</p>
                    </div>
                </div>';
            }
            if ($noResult)
            {
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No comments found!</p>
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