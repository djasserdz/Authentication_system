<?php
if(isset($_POST["login"])){
    $email=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
    $pa=filter_var($_POST["password"],FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($email) || empty($pa)){
        $error="Missing Email/Password";
    }
    else{
        try{
           require "../database/connection.php";
           $sql_find="SELECT * FROM users where email=:email;";
           $statment=$pdo->prepare($sql_find);
           $statment->bindParam(":email",$email);
           $statment->execute();
           $user_flag=$statment->rowCount();
           if($user_flag == 0){
             $error="Credentials do not match our records";
           }
           else{
            $row=$statment->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                $error="Credentials do not match our records";
            }
            else{
                if(password_verify($pa,$row["password"])){
                    session_start();
                    $_SESSION["username"]=$row["username"];
                    header("Location:home.php");
                    exit();
                }
                else{
                    $error="Credentials do not match our records";
                }
            }
           }
        }
        catch(PDOException $e){
            $error="Database error :".$e->getMessage();
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        <?php if(isset($error) && !empty($error)) :  ?>
        <p class="text-red-500"><?php echo $error ?></p>
        <?php endif ?>
        <form action="login.php" method="post">
            <label class="block mb-2">Email</label>
            <input type="email" class="w-full p-2 border rounded mb-4" placeholder="Enter email" name="email">
            
            <label class="block mb-2">Password</label>
            <input type="password" class="w-full p-2 border rounded mb-4" placeholder="Enter password" name="password">
            
            <button class="w-full bg-blue-600 text-white p-2 rounded" name="login">Login</button>
        </form>
    </div>
</body>
</html>