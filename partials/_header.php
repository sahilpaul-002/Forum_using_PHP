<?php
//Check session status
if (session_status() === PHP_SESSION_NONE) 
{
  session_start();
}
//Check if the user is logged in
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true)
{
  $login = true;
}
else 
{
  $login = false;
}

//Include/Require the necessary files
require "partials/_dbCreate.php";
require "partials/_createTable.php";
require "partials/_loginModal.php";
require "partials/_signupModal.php";
require "partials/_logoutModal.php";

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/Forum">iDiscuss - Forum</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/Forum">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Top Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

        //Fetch the top 3 categories based on maximum threads from the databse
        $sql = "SELECT 
                  `categories`.`categoryId`, 
                  `categories`.`categoryName`, 
                  `threads`.`threadId`, 
                  COUNT(`threads`.`threadId`) AS `threadCount` 
                  FROM `categories` 
                  INNER JOIN `threads` ON `categories`.`categoryId`=`threads`.`threadCategoryId` 
                  GROUP BY `categories`.`categoryId` 
                  ORDER BY threadCount DESC 
                  LIMIT 3";
        $result = mysqli_query($conn, $sql);
        if ($result)
        {
          while ($row = mysqli_fetch_assoc($result))
          {
            $categoryId = $row["categoryId"];
            $categoryName = $row["categoryName"];
            //Display the category name and link to the thread list page
            echo '<a class="dropdown-item" href="/Forum/threadList.php?catId=' . $categoryId . '">' . $categoryName . '</a>';
          }
        }
        else
        {
          echo '<a class="dropdown-item" href="#">No categories available</a>';
        }
        echo '</div>
      </li>
    </ul>
    <div class="row mx-2">';
    // Check if the user is logged in then allw user to search, and show Welcome with user name
    if($login)
    {
        echo '<form class="form-inline my-2 my-lg-0" action="/forum/search.php" method="GET">
        <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search Threads" aria-label="Search">
        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
        <p class="text-light my-0 mx-2">Welcome ' . $_SESSION["userName"] . '</p> 
        <button type="button" class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#logoutModal">Log Out</button> 
        </form>';
    }
    // If user not loggedin then show Login or sign up button
    else
    {
      echo '<form class="form-inline my-2 my-lg-0">
        <button type="button" class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginModal">Login</button>
        <button type="button" class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupModal">Signup</button>
        </form>';
    }
    echo '</div>
  </div>
</nav>';
?>