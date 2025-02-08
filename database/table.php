<?php
try{
  require "./connection.php";
  $sql_table="CREATE TABLE users(
    user_id int not null PRIMARY KEY AUTO_INCREMENT,
    username varchar(50) not null,
    email varchar(50) not null unique,
    password varchar(255) not null,
    create_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
  );";

  $statment=$pdo->prepare($sql_table);
  $statment->execute();
  echo "table created!";
}
catch(PDOException $e){
    echo "database error :".$e->getMessage();
}
?>