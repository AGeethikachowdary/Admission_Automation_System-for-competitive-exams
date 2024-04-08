<?php
    //error_reporting(0);
    session_start();
$getid= $_SESSION['user'];
$con=mysqli_connect("localhost","root","","oas");
if(!isset($con))
{
    die("Database Not Found");
}

//<img src='./images/Tick.png' width='20px'>
//style='background-color:transparent;border:none;'


if(isset($_REQUEST["appr"]))
{
    
    $sql  = "insert into t_status values(";
    $sql .= "'" . $getid . "',";
    $sql .= "'Approved')";
    
    
  
    
    
    mysqli_query($con, $sql);
    echo $sql;
    
    
}



?>