<?php
if(isset($_POST["register"])){
    $username=filter_var($_POST["username"],FILTER_SANITIZE_SPECIAL_CHARS);
    $email=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    $pass=filter_var($_POST["password"],FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($username) || empty($email) || empty($pass)){
        $error="Missing username/Email/Password";
    }
    else{
        try{
            require "../database/connection.php";
            $sql_find_email="SELECT * FROM users where email=:email;";
            $statment=$pdo->prepare($sql_find_email);
            $statment->bindParam(":email",$email);
            $statment->execute();
            $dublicate_user_flag=$statment->rowCount();
            if($dublicate_user_flag != 0){
                $error="Cannot use email";
            }
            else{
                $hash=password_hash($pass,PASSWORD_DEFAULT);
                $sql_insert="INSERT INTO users(username,email,password) values(:username,:email,:password);";
                $statment=$pdo->prepare($sql_insert);
                $statment->bindParam(":username",$username);
                $statment->bindParam(":email",$email);
                $statment->bindParam(":password",$hash);
                $statment->execute();
                session_start();
                $_SESSION["username"]=$username;
                header("Location:home.php");
                exit();
            }
        }
        catch(PDOException $e){
            echo "Database error :".$e->getMessage();
        }
       
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Register</h2>
        <?php if(isset($error) && !empty($error)) : ?>
        <p class="text-red-500"><?php echo $error ?></p>
        <?php endif ?>
        <form action="register.php" method="post">
            <label class="block mb-2">Username</label>
            <input type="text" class="w-full p-2 border rounded mb-4" placeholder="Enter username" name="username">
            
            <label class="block mb-2">Email</label>
            <input type="email" class="w-full p-2 border rounded mb-4" placeholder="Enter email" name="email">
            
            <label class="block mb-2">Password</label>
            <input type="password" class="w-full p-2 border rounded mb-4" placeholder="Enter password" name="password">
            
            <button class="w-full bg-blue-600 text-white p-2 rounded" name="register">Register</button>
        </form>
    </div>
</body>
</html>