<?php
session_start();
include "db.php";


$_SESSION['user_id'] = 999; 
$_SESSION['username'] = 'Developer';


header("Location: index.php");
exit();
?>