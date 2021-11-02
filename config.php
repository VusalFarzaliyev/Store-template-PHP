<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$db_name    ="contact";

$conn = mysqli_connect($servername,$username,$password,$db_name);
 //print_r($conn);
// exit();
    if(!$conn){
        echo "Elaqe yaradilmadi!";
    }
  
?>