<?php
session_start();
include_once('conf.php');
include_once('function.php');

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // Basic validation
    if (empty($full_name) || empty($email) || empty($password)) {
        header('Location: register.php?error=fill');
        exit();
    }
    
    if ($password !== $password_confirm) {
        header('Location: register.php?error=pass');
        exit();
    }
    
    if (strlen($password) < 6) {
        header('Location: register.php?error=passlen');
        exit();
    }
    
    // Attempt registration
    if (register_user($full_name, $email, $phone, $password)) {
        header('Location: user-login.php?success=registered');
        exit();
    } else {
        // Assume failure is due to duplicate email
        header('Location: register.php?error=email');
        exit();
    }
}
elseif ($action === 'login') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $user = login_user($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header('Location: user-profile.php');
        exit();
    } else {
        header('Location: user-login.php?error=invalid');
        exit();
    }
}
else {
    header('Location: index.php');
    exit();
}
