<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$userAvatar = !empty($user['avatar']) ? $user['avatar'] : 'img/face.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/settings.css">
    <link rel="shortcut icon" href="img/FascebookLogo.png" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <div class="LogoName" style="cursor: pointer;" onclick="location.href='index.php'">
                <img src="img/FascebookLogo.png" alt="">
                <h1>acebook</h1>
            </div>
            <ul class="ulnav">
                <li><a href="profile.php" data-lang-en="Profiles" data-lang-pl="Profile">Profiles</a></li>
                <li><a href="index.php#cardpsot" data-lang-en="Posts" data-lang-pl="Posty">Posts</a></li>
                <li><a href="#" data-lang-en="Settings" data-lang-pl="Ustawienia">Settings</a></li>
                <li><a href="index.php#About" data-lang-en="About" data-lang-pl="O nas">About</a></li>
            </ul>
            
            <div class="creatorslogotip">
                <span class="username">
                    <?php if (isset($_SESSION['username'])): ?>
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    <?php else: ?>
                        <span data-lang-en="Guest" data-lang-pl="Gość">Guest</span>
                    <?php endif; ?>
                </span>
              
                <img src="<?= !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'img/Creators_logo.png' ?>" alt="" class="creatorlogo">  
            </div>
        </nav>
    </header>

    <main class="settings-wrapper">
    <div class="settings-card">
        <h2 data-lang-en="Account Settings" data-lang-pl="Ustawienia konta">Account Settings</h2>
        
        <div class="settings-container">
  
            <div class="settings-item">
                <div class="settings-info">
                    <p class="settings-label" data-lang-en="Dark Mode" data-lang-pl="Tryb ciemny">Dark Mode</p>
                    <p class="settings-desc" data-lang-en="Change appearance to dark" data-lang-pl="Zmień wygląd na ciemny">Сменить оформление сайта на темное</p>
                </div>
                <label class="switch">
                    <input type="checkbox" id="theme-toggle">
                    <span class="slider round"></span>
                </label>
            </div>

            <hr class="settings-divider">


            <div class="settings-item">
                <div class="settings-info">
                    <p class="settings-label" data-lang-en="Notifications" data-lang-pl="Powiadomienia">Notifications</p>
                    <p class="settings-desc" data-lang-en="Get notified about new posts" data-lang-pl="Otrzymuj powiadomienia o postach">Получать уведомления о новых постах</p>
                </div>
                <label class="switch">
                    <input type="checkbox" disabled>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="settings-item">
                <div class="settings-info">
                    <p class="settings-label" data-lang-en="Language: English" data-lang-pl="Język: Polski">Language: English</p>
                    <p class="settings-desc" data-lang-en="Translate site to Polish" data-lang-pl="Przetłumacz stronę na polski">Translate site to Polish</p>
                </div>
                <label class="switch">
                    <input type="checkbox" id="lang-toggle">
                    <span class="slider round"></span>
                </label>
            </div>
            
        </div>
    </div>
</main>
<script src="maincode.js"></script>
</body>
</html>