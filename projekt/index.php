<?php
session_start();
include "db.php";

if (isset($_POST['dev_login'])) {

    $admin_id = 999; 
    
    $stmt = $conn->prepare("SELECT id, username, avatar FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['avatar'] = $user['avatar'];
        header("Location: index.php"); 
        exit();
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['text'])) {
    $text = trim($_POST["text"] ?? '');
    if ($text === '') {
        die("Error: text is empty");
    }

    $imageName = null;
    if (!empty($_FILES["image"]["name"])) {
        $imageName = time() . "_" . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName);
    }

    $user_id = $_SESSION['user_id'] ?? null;

    $stmt = $conn->prepare("INSERT INTO posts (text, image, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $text, $imageName, $user_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}

$current_user_id = $_SESSION['user_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Clone</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="css/profile.css">
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
                <li><a href="#cardpsot" data-lang-en="Posts" data-lang-pl="Posty">Posts</a></li>
                <li><a class="asettings" href="settings.php" data-lang-en="Settings" data-lang-pl="Ustawienia">Settings</a></li>
                <li><a href="#About" data-lang-en="About" data-lang-pl="O nas">About</a></li>
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

    <main>
        <div class="settingswindow" style="display: none;">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <button class="btnregist btnsettings" data-lang-en="Registrate" data-lang-pl="Zarejestruj się">Registrate</button>
                <button class="btnlogin btnsettings" data-lang-en="Login" data-lang-pl="Zaloguj się">Login</button>
            <?php else: ?>
                <form method="POST" style="margin:0;">
                    <button type="submit" name="logout" class="btnregist btnsettings" data-lang-en="Log Out" data-lang-pl="Wyloguj się">Log Out</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="navigatepannelmain">
            <ul>
                <li><a href="#" class="not-ready" data-lang-en="Posts" data-lang-pl="Posty">Posts</a></li>
                <li><a href="#" class="not-ready" data-lang-en="Group" data-lang-pl="Grupy">Group</a></li>
                <li><a href="#" class="not-ready" data-lang-en="Friends" data-lang-pl="Znajomi">Friends</a></li>
                <li><input type="text" placeholder="Search..." data-lang-en="Search..." data-lang-pl="Szukaj..."></li>
            </ul>
        </div>

        <button class="crtpst" data-lang-en="Create Post +" data-lang-pl="Utwórz post +">Create Post +</button>

        <div class="cardpsot" id="cardpsot">
            <?php
            $query = "SELECT posts.*, users.username, users.avatar 
                      FROM posts 
                      LEFT JOIN users ON posts.user_id = users.id 
                      ORDER BY posts.id DESC";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()):
            ?>
                <div class="card" data-id="<?= $row['id'] ?>">
                    <div class="card-header" style="display: flex; align-items: center; padding: 10px;">
                        <img src="<?= !empty($row['avatar']) ? $row['avatar'] : 'img/face.jpg' ?>" class="logoface" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        <div style="margin-left: 10px;">
                            <p style="font-weight: bold; margin: 0;"><?= htmlspecialchars($row['username'] ?? 'Unknown') ?></p>
                            <small style="color: gray;"><?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></small>
                        </div>
                    </div>
                    <div class="card-info" style="padding: 10px;">
                        <p><?= htmlspecialchars($row["text"]) ?></p>
                    </div>
                    <?php if ($row["image"]): ?>
                        <img src="uploads/<?= $row["image"] ?>" style="width: 100%;">
                    <?php endif; ?>
                    <div class="card-actions" style="padding: 10px;">
                        <?php
                        $is_author = ($current_user_id > 0 && $current_user_id == $row['user_id']);
                        $is_admin = ($current_user_id == 999);
                        if ($is_author || $is_admin): ?>
                            <button class="deletebutton" type="button" style="color: red; float: right; background: none; border: none; cursor: pointer; font-weight: bold;">X</button>
                        <?php endif; ?>
                        <button type="button" class="morinfo" data-lang-en="More Info" data-lang-pl="Więcej informacji">More Info</button>

                        <div class="post-likes" style="padding: 5px 15px; display: flex; align-items: center; gap: 10px;">
                            
                            <div class="post-actions" style="border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                                <div class="like-container" style="display: flex; align-items: center; gap: 8px;">
                                    <button type="button" class="like-button" style="background: none; border: none; cursor: pointer; font-size: 20px; transition: transform 0.2s;">
                                        <span class="heart-icon">🤍</span>
                                    </button>
                                    <span class="likes-count" style="font-weight: bold; font-family: sans-serif;">0</span>
                                    <span data-lang-en="Likes" data-lang-pl="Polubienia" style="color: #65676b; font-size: 14px;">Likes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <footer>
        <div class="footerform">
            <div class="first-column">
                <h2 id="About" data-lang-en="About" data-lang-pl="O nas">About</h2>
                <p data-lang-en="Number: +48(58)-712-45-90" data-lang-pl="Numer: +48(58)-712-45-90">Number: +48(58)-712-45-90</p>
                <p data-lang-en="Creator's Mail: creators@gmail.com" data-lang-pl="E-mail twórcy: creators@gmail.com">Creator's Mail: creators@gmail.com</p>
            </div>
            <img src="img/FAcebookimg.jpg" alt="">
        </div>

        <div class="dev-panel" style="margin-top: 20px; text-align: center; opacity: 0.5;">
        <form method="POST">
            <button type="submit" name="dev_login" class="dev-btn" 
                    data-lang-en="Developer Login" 
                    data-lang-pl="Logowanie dewelopera">
                Developer Login
            </button>
        </form>
    </div>
    </footer>

    <div id="deleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h3 data-lang-en="Confirmation" data-lang-pl="Potwierdzenie">Confirmation</h3>
            <p data-lang-en="Are you sure you want to delete this post?" data-lang-pl="Czy na pewno chcesz usunąć ten post?">Are you sure you want to delete this post?</p>
            <div class="modal-buttons">
                <button id="cancelDelete" class="btn-cancel" data-lang-en="CANCEL" data-lang-pl="ANULUJ">CANCEL</button>
                <button id="confirmDelete" class="btn-confirm" data-lang-en="DELETE" data-lang-pl="USUŃ">DELETE</button>
            </div>
        </div>
    </div>
    <div id="workInProgressModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <h3 data-lang-en="Coming Soon" data-lang-pl="Wkrótce">Coming Soon</h3>
            <p data-lang-en="It doesn't work, I didn't have enough time to finish it."
                data-lang-pl="To nie działa, nie zdążyłem zrobić tego na czas.">
                It doesn't work, I didn't have enough time to finish it.
            </p>
            <div class="modal-buttons">
                <button id="closeWipModal" class="btn-confirm"
                    data-lang-en="OK" data-lang-pl="OK">OK</button>
            </div>
        </div>
        
    </div>
    <script src="maincode.js"></script>
</body>

</html>