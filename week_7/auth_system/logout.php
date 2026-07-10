<?php
include 'includes/auth.php';
logout_user();
header('Location: login.php'); exit;
