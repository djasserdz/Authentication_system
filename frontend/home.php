<?php
session_start();

if(isset($_POST["logout"])){
    session_destroy();
    header("Location:login.php");
    exit();
}
?>






<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white flex justify-between">
        <h1 class="text-lg font-bold">My Website</h1>
        <div>
            <?php if(!isset($_SESSION["username"])) : ?>
            <a href="register.php" class="px-4 py-2 bg-white text-blue-600 rounded">Register</a>
            <a href="login.php" class="px-4 py-2 bg-white text-blue-600 rounded">Login</a>
            <?php else : ?>
            <p>Hello <?php echo $_SESSION["username"] ?></p>
            <?php endif ?>
        </div>
    </nav>
    <div class="container mx-auto text-center mt-10">
        <h2 class="text-3xl font-bold">Welcome to My Website</h2>
        <p class="mt-4 text-gray-700">This is a simple homepage built with HTML and Tailwind CSS.</p>
        <?php if(isset($_SESSION["username"])) : ?>
        <form action="home.php" method="post">
            <button name="logout">logout</button>
        </form>
        <?php endif ?>
    </div>
</body>
</html>