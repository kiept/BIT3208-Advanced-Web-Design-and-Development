<?php
include 'includes/auth.php';
start_secure_session();
logout_user();
header('Location: login.php'); exit;
