<?php
session_start();
include_once('conf.php');
include_once('function.php');

if (!is_user_logged_in()) {
    header('Location: login/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['appointment_id'] ?? 0);
    $doctor_id = intval($_POST['doctor_id'] ?? 0);
    $user_id = intval($_SESSION['user_id']);
    
    if ($appointment_id && $doctor_id) {
        // Перевіряємо, чи цей запис належить поточному користувачу
        $sql_check = "SELECT id FROM appointments WHERE id = $appointment_id AND user_id = $user_id";
        $res = mysqli_query($conn, $sql_check);
        
        if (mysqli_num_rows($res) > 0) {
            // Видаляємо запис
            $sql_del = "DELETE FROM appointments WHERE id = $appointment_id AND user_id = $user_id";
            if (mysqli_query($conn, $sql_del)) {
                header("Location: post.php?post_id=$doctor_id&cancel_success=1");
                exit();
            }
        }
    }
    
    header("Location: post.php?post_id=$doctor_id&error=cancel");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
