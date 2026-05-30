<?php
// Перемикач мови
session_start();
$allowed = ['uk', 'en'];
if (isset($_GET['lang']) && in_array($_GET['lang'], $allowed)) {
    $_SESSION['lang'] = $_GET['lang'];
}
// Повернутися на попередню сторінку
$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header('Location: ' . $redirect);
exit();
