<?php
try{
  require "../database/config.php";
  $pdo=new PDO("mysql:host=$server;dbname=$dbname",$user,$password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //echo "connected";
}
catch(PDOException $e){
    //echo "database error :".$e->getMessage();
}
?>