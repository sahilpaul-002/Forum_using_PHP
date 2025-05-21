<?php
require "partials/_dbConnect.php";

// Create a table for storing category data
$sql = "CREATE TABLE IF NOT EXISTS `categories` (
    `categoryId` INT(10) AUTO_INCREMENT PRIMARY KEY,
    `categoryName` VARCHAR(255) NOT NULL,
    `categoryDescription` VARCHAR(255) NOT NULL, 
    `cetegoryUserId` INT(10) NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cetegoryUserId) REFERENCES `users`(userId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
if (!mysqli_query($conn, $sql))
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failure. </strong> Table not created: ' . mysqli_error($conn) .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}

//Create a table for storing user data
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `userId` INT(10) AUTO_INCREMENT PRIMARY KEY,
    `userName` VARCHAR(255) NOT NULL UNIQUE,
    `userEmail` VARCHAR(255) NOT NULL UNIQUE, 
    `userPassword` VARCHAR(255) NOT NULL, 
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
if (!mysqli_query($conn, $sql))
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failure. </strong> Table not created: ' . mysqli_error($conn) .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}

//Create a table for storing thread data
$sql = "CREATE TABLE IF NOT EXISTS `threads` (
    `threadId` INT(10) AUTO_INCREMENT PRIMARY KEY,
    `threadTitle` Varchar(255) NOT NULL,
    `threadDescription` TEXT NOT NULL,
    `threadUserId` INT(10) NOT NULL,
    `threadCategoryId` INT(10) NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT (`threadTitle`, `threadDescription`),
    FOREIGN KEY (threadUserId) REFERENCES `users`(userId) ON DELETE CASCADE,
    FOREIGN KEY (threadCategoryId) REFERENCES `categories`(categoryId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
if (!mysqli_query($conn, $sql))
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failure. </strong> Table not created: ' . mysqli_error($conn) .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}

//Create a table for storing comments data
$sql = "CREATE TABLE IF NOT EXISTS `comments` (
    `commentId` INT(10) AUTO_INCREMENT PRIMARY KEY,
    `commentContent` TEXT NOT NULL,
    `commentUserId` INT(10) NOT NULL,
    `commentThreadId` INT(10) NOT NULL,
    `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (commentUserId) REFERENCES `users`(userId) ON DELETE CASCADE,
    FOREIGN KEY (commentThreadId) REFERENCES `threads`(threadId) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
if (!mysqli_query($conn, $sql))
{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Failure. </strong> Table not created: ' . mysqli_error($conn) .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
?>