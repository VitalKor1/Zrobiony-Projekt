<?php
session_start();
include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';
    $checkpassword = $_POST["checkpassword"] ?? '';

    if (!$username || !$email || !$password) {
        $error = "Fill all fields";
    } elseif ($password !== $checkpassword) {
        $error = "Passwords do not match";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email";
    } else {


        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already exists";
        } else {

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password_hash);

        if ($stmt->execute()) {

    $new_user_id = $conn->insert_id;


    $_SESSION['user_id'] = $new_user_id;
    $_SESSION['username'] = $username; 
    $_SESSION['avatar'] = 'img/face.jpg'; 

    header("Location: index.php");
    exit();
} else {
            $error = "DB error";
        }
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
    <!-- header -->
    <header>
        <nav>
            <div class="LogoName" style="cursor: pointer;">
                <img src="img/FascebookLogo.png" alt="">
                <h1>acebook</h1>
            </div>
            <ul class="ulnav">
                <li>
                    <a href="">Profiles</a>
                </li>
                <li>
                    <a href="#cardpsot">Posts</a>
                </li>
                <li>
                    <a href="#">Settings</a>
                </li>
                <li>
                    <a href="#About">About</a>
                </li>
                <li>
                    <a href="#">###</a>
                </li>
            </ul>
            
            <div class="creatorslogotip">
              <img src="img/Creators_logo.png" alt="" class="creatorlogo">  
            </div>
            
            
        </nav>
    </header>

    <!-- main -->
     <main>
        <form class="rejestracjaicon" action="rejestracja.php" method="POST">
    <h2>Registrate</h2>

     <?php if ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

    <div class="rejestracjainputs">
        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Enter your E-mail" required>

        <input type="password" name="password" placeholder="Enter password" required>

        <input type="password" name="checkpassword" placeholder="Confirm password" required>
    </div>

    <button class="buttonregist" type="submit">Registrate</button>
</form>
     </main>
</body>
<script src="rejestracja.js"></script>
</html>