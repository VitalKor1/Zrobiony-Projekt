<?php
session_start();
include "db.php";

$showAuthModal = false; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        $showAuthModal = true; 
    } else {
        $text = trim($_POST["text"] ?? '');
        $imageName = null;
        if (!empty($_FILES["image"]["name"])) {
            $imageName = time() . "_" . $_FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName);
        }

        $author_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO posts (text, image, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $text, $imageName, $author_id);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/FascebookLogo.png" type="image/x-icon">
    <title>Facebook2</title>
    <link rel="stylesheet" href="CSS/style.css"> 
    <link rel="stylesheet" href="CSS/addPost.css">
</head>
<body>
     
      <header>
        <nav>
            <div class="LogoName" style="cursor: pointer;" onclick="location.href='index.php'">
                <img src="img/FascebookLogo.png" alt="">
                <h1>acebook</h1>
            </div>
            <ul class="ulnav">
                <li>
                    <a href="profile.php" data-lang-en="Profiles" data-lang-pl="Profile">Profiles</a>
                </li>
                <li>
                    <a href="index.php#cardpsot" data-lang-en="Posts" data-lang-pl="Posty">Posts</a>
                </li>
                <li>
                    <a href="settings.php" data-lang-en="Settings" data-lang-pl="Ustawienia">Settings</a>
                </li>
                <li>
                    <a href="index.php#About" data-lang-en="About" data-lang-pl="O nas">About</a>
                </li>
            </ul>
            
            <div class="creatorslogotip">
              <span class="username" style="margin-right: 10px;">
                  <?php if(isset($_SESSION['username'])): ?>
                      <?= htmlspecialchars($_SESSION['username']) ?>
                  <?php else: ?>
                      <span data-lang-en="Guest" data-lang-pl="Gość">Guest</span>
                  <?php endif; ?>
              </span>
              <img src="<?= !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'img/Creators_logo.png' ?>" alt="" class="creatorlogo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">  
            </div>
        </nav>
      </header>

       <main>
        <form action="addPost.php" method="POST" enctype="multipart/form-data">
            <div class="postCreator">
                <h2 data-lang-en="Create Post" data-lang-pl="Utwórz post">Create Post</h2>

                <textarea name="text" placeholder="What's on your mind?" data-lang-en="What's on your mind?" data-lang-pl="O czym myślisz?" class="postText" required></textarea>

                <div class="uploadSection">
                    <label for="imageUpload" class="uploadBtn" data-lang-en="Add Image" data-lang-pl="Dodaj zdjęcie">Add Image</label>
                    <input type="file" id="imageUpload" name="image" accept="image/*" hidden>
                </div>

                <div class="previewContainer">
                    <div class="imageWrapper">
                        <img id="previewImage" src="" alt="">
                        <span id="removeImage">✕</span>
                    </div>
                </div>

                <div class="tagsSection">
                    <select id="tagSelect">
                        <option value="" data-lang-en="Select tag..." data-lang-pl="Wybierz tag...">Select tag...</option>
                        <option value="Travel" data-lang-en="Travel" data-lang-pl="Podróże">Travel</option>
                        <option value="Food" data-lang-en="Food" data-lang-pl="Jedzenie">Food</option>
                        <option value="Music" data-lang-en="Music" data-lang-pl="Muzyka">Music</option>
                        <option value="Work" data-lang-en="Work" data-lang-pl="Praca">Work</option>
                        <option value="Life" data-lang-en="Life" data-lang-pl="Życie">Life</option>
                    </select>
                    <div class="selectedTags"></div>
                </div>

                <button type="submit" class="postBtn" data-lang-en="Post" data-lang-pl="Opublikuj">Post</button>
            </div>
        </form>
       </main>
       <div id="authErrorModal" class="modal-overlay" style="<?= $showAuthModal ? 'display: flex;' : 'display: none;' ?>">
    <div class="modal-content">
        <h3 data-lang-en="Access Denied" data-lang-pl="Brak dostępu">Access Denied</h3>
        <p data-lang-en="To create a post, you need to log in to your account." 
           data-lang-pl="Aby utworzyć post, musisz zalogować się na swoje konto.">
           To create a post, you need to log in to your account.
        </p>
        <div class="modal-buttons">
            <button onclick="location.href='login.php'" class="btn-confirm" 
                    data-lang-en="Login" data-lang-pl="Zaloguj się">Login</button>
            <button onclick="document.getElementById('authErrorModal').style.display='none'" class="btn-cancel" 
                    data-lang-en="Close" data-lang-pl="Zamknij">Close</button>
        </div>
    </div>
</div>

<script src="codeaddpost.js"></script>
<script src="maincode.js"></script> 
</body>
</html>