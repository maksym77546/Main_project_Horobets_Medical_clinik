<?php
session_start();
include_once('conf.php');
include_once('function.php');

if (!is_user_logged_in()) {
    header('Location: login/index.php');
    exit();
}

$doctor_id = intval($_POST['doctor_id'] ?? 0);
$date = trim($_POST['date'] ?? '');
$time = trim($_POST['time'] ?? '');

if (!$doctor_id || !$date || !$time) {
    header("Location: post.php?post_id=$doctor_id&error=1");
    exit();
}

$date = mysqli_real_escape_string($conn, $date);
$time = mysqli_real_escape_string($conn, $time);
$user_id = intval($_SESSION['user_id']);

// Double check if the slot is still available
$available_slots = get_available_slots($doctor_id, $date);
if (!in_array($time, $available_slots)) {
    // Slot is taken
    header("Location: post.php?post_id=$doctor_id&error=booked");
    exit();
}

// Insert booking
$sql = "INSERT INTO appointments (doctor_id, user_id, appointment_date, appointment_time, status)
        VALUES ($doctor_id, $user_id, '$date', '$time', 'booked')";

if (mysqli_query($conn, $sql)) {
    header("Location: post.php?post_id=$doctor_id&success=1");
} else {
    header("Location: post.php?post_id=$doctor_id&error=db");
}
?>
