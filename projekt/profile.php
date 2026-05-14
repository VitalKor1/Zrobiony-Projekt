<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['avatar'])) {
    $uploadDir = 'uploads/avatars/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $fileName = time() . '_' . $_FILES['avatar']['name'];
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
        $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $stmt->bind_param("si", $targetFile, $user_id);
        $stmt->execute();
        $_SESSION['avatar'] = $targetFile; 
        header("Location: profile.php");
        exit();
    }
}

if (isset($_POST['update_name'])) {
    $new_name = trim($_POST['new_username']);
    if (!empty($new_name)) {
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $new_name, $user_id);
        $stmt->execute();
        $_SESSION['username'] = $new_name;
        $message = "Name updated!";
    }
}


if (isset($_POST['update_password'])) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res && password_verify($old_pass, $res['password_hash'])) {
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $update->bind_param("si", $hashed_password, $user_id);
        
        if ($update->execute()) {
            $message = "Password changed successfully!";
        } else {
            $message = "Database error during update.";
        }
    } else {
        $message = "Error: Old password incorrect.";
    }
}

$stmt = $conn->prepare("SELECT username, email, avatar, created_at, last_activity FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$userAvatar = !empty($user['avatar']) ? $user['avatar'] : 'img/face.jpg';

$post_stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY id DESC");
$post_stmt->bind_param("i", $user_id);
$post_stmt->execute();
$my_posts = $post_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | <?= htmlspecialchars($user['username']) ?></title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/profile.css">
</head>
<body>

    <nav>
        <div class="LogoName" onclick="location.href='index.php'">
            <img src="img/FascebookLogo.png" alt="Logo">
            <h1>acebook</h1>
        </div>
        <ul class="ulnav">
            <li><a href="index.php" data-lang-en="Home" data-lang-pl="Główna">Home</a></li>
            <li><a href="profile.php" style="background: #d1d5db; color: black;" data-lang-en="Profile" data-lang-pl="Profil">Profile</a></li>
        </ul>
        <div class="creatorslogotip">
            <span class="username"><?= htmlspecialchars($user['username']) ?></span>
            <img src="<?= $userAvatar ?>" class="creatorlogo">
        </div>
    </nav>

    <main class="profile-wrapper">
        
        <aside class="profile-sidebar">
            <?php if($message): ?>
                <div style="padding: 10px; background: #e0f2f1; color: #00695c; border-radius: 10px; text-align: center; font-size: 14px;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="sidebar-avatar-section">
                <form action="profile.php" method="POST" enctype="multipart/form-data" id="avatarForm">
                    <div class="avatar-wrapper">
                        <img src="<?= $userAvatar ?>" class="main-profile-img">
                        <label for="avatarInput" class="upload-badge">📷</label>
                        <input type="file" name="avatar" id="avatarInput" onchange="document.getElementById('avatarForm').submit()">
                    </div>
                </form>
                <h1 class="profile-name" style="font-size: 22px; margin-top: 15px;"><?= htmlspecialchars($user['username']) ?></h1>
                <p class="profile-email" style="margin-bottom: 0;"><?= htmlspecialchars($user['email']) ?></p>
            </div>

            <form action="profile.php" method="POST">
                <div class="sidebar-title" data-lang-en="Edit Profile" data-lang-pl="Edytuj profil">Edit Profile</div>
                <div class="input-group">
                    <label data-lang-en="Username" data-lang-pl="Nazwa użytkownika">Username</label>
                    <input type="text" name="new_username" value="<?= htmlspecialchars($user['username']) ?>">
                </div>
                <button type="submit" name="update_name" class="btn-save-profile" data-lang-en="Save Name" data-lang-pl="Zapisz nazwę">Save Name</button>
            </form>

            <hr style="border: 0; border-top: 1px solid #eee; margin: 10px 0;">

            <form action="profile.php" method="POST">
                <div class="sidebar-title" data-lang-en="Security" data-lang-pl="Bezpieczeństwo">Security</div>
                <div class="input-group">
                    <label data-lang-en="Old Password" data-lang-pl="Stare hasło">Old Password</label>
                    <input type="password" name="old_password" required>
                </div>
                <div class="input-group">
                    <label data-lang-en="New Password" data-lang-pl="Nowe hasło">New Password</label>
                    <input type="password" name="new_password" required>
                </div>
                <button type="submit" name="update_password" class="btn-pass-profile" data-lang-en="Update Password" data-lang-pl="Aktualizuj hasło">Update Password</button>
            </form>
        </aside>

        <section class="profile-main-content">
            <h2 data-lang-en="My Posts" data-lang-pl="Moje posty">My Posts (<?= $my_posts->num_rows ?>)</h2>
            
            <div class="cardpsot" style="grid-template-columns: 1fr; padding: 0;">
                <?php if($my_posts->num_rows > 0): ?>
                    <?php while($row = $my_posts->fetch_assoc()): ?>
                        <div class="card">
                            <div class="card-text">
                                <img src="<?= $userAvatar ?>" class="logoface">
                                <p><?= htmlspecialchars($user['username']) ?></p>
                            </div>
                            <div class="card-info">
                                <p><?= htmlspecialchars($row['text']) ?></p>
                            </div>
                            <?php if(!empty($row['image'])): ?>
                                <img src="uploads/<?= $row['image'] ?>" class="post-img">
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div style="background: white; padding: 50px; border-radius: 28px; text-align: center; color: #9ca3af;">
                        <p data-lang-en="You haven't posted anything yet." data-lang-pl="Nie masz jeszcze żadnych postów.">You haven't posted anything yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <script src="maincode.js"></script>
</body>
</html>