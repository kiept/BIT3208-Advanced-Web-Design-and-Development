<?php
// Simple auth helpers for Week6 employee management
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function start_secure_session(){ if(session_status() !== PHP_SESSION_ACTIVE) session_start(); }
function is_logged_in(){ return !empty($_SESSION['user_id']); }
function require_login(){ start_secure_session(); if(!is_logged_in()){ header('Location: login.php'); exit; } }
function login_user($user_id){ start_secure_session(); session_regenerate_id(true); $_SESSION['user_id'] = $user_id; }
function logout_user(){ start_secure_session(); $_SESSION = []; if (ini_get("session.use_cookies")) { $params = session_get_cookie_params(); setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']); } session_destroy(); }
function current_user($conn){ if (empty($_SESSION['user_id'])) return null; $id = intval($_SESSION['user_id']); $stmt = $conn->prepare('SELECT user_id,username,email FROM users WHERE user_id=? LIMIT 1'); $stmt->bind_param('i',$id); $stmt->execute(); $res = $stmt->get_result(); $u = $res->fetch_assoc(); $stmt->close(); return $u; }
