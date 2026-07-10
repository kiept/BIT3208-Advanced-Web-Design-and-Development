<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($name){
        // store username in session as simple auth demo
        $_SESSION['user'] = $name;
        header('Location: index.php'); exit;
    }
}
if (isset($_GET['action']) && $_GET['action']==='logout'){
    session_unset(); session_destroy(); header('Location: index.php'); exit;
}
// fallback
header('Location: index.php');
