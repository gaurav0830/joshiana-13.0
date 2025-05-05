<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "joshianadb";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$conn){
          die('Could not Connect MySql Server:' .mysqli_connect_error());
        }
?>