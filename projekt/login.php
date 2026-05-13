<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? '';

    if (!$username || !$password) {
        $error = "Fill all fields";
    } else {

        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password_hash"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                header("Location: index.php");
                exit();

            } else {
                $error = "Wrong password";
            }

        } else {
            $error = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>

    <link rel="stylesheet" href="CSS/rejestracja.css">
    <link rel="shortcut icon" href="img/FascebookLogo.png" type="image/x-icon">
</head>
<body>

<header>
    <nav>
        <div class="LogoName" style="cursor: pointer;">
            <img src="img/FascebookLogo.png" alt="">
            <h1>acebook</h1>
        </div>

        <ul class="ulnav">
            <li><a href="#">Profiles</a></li>
            <li><a href="#">Posts</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">About</a></li>
        </ul>

        <div class="creatorslogotip">
            <img src="img/Creators_logo.png" alt="" class="creatorlogo">
        </div>
    </nav>
</header>

<main>

<form class="rejestracjaicon" method="POST">
    <h2>Login</h2>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <div class="rejestracjainputs">

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

    </div>

    <button class="buttonregist" type="submit">Login</button>
</form>

</main>

</body>
<script src="login.js"></script>
</html>