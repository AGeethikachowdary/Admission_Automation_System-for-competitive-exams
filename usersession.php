<?php
error_reporting(0);
session_start(); // Start the session
extract($_POST);

if (!isset($_SESSION['user'])) {
    echo "<br>You are not logged in. Please <a href='index.php'>login</a> to access this page.";
    exit();
} 
?>
