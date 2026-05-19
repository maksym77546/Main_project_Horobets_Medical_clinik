<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$doctor_name   = trim($_POST['doctor_name'] ?? '');
$image         = trim($_POST['image'] ?? '');
$specialization= trim($_POST['specialization'] ?? '');
$datetime      = trim($_POST['datetime'] ?? '');
$menu_id       = intval($_POST['menu_id'] ?? 0);

if (!$doctor_name || !$image || !$specialization || !$datetime || !$menu_id) {
    header('Location: add-new.php?error=1');
    exit();
}

$doctor_name    = mysqli_real_escape_string($conn, $doctor_name);
$image          = mysqli_real_escape_string($conn, $image);
$specialization = mysqli_real_escape_string($conn, $specialization);
$datetime       = mysqli_real_escape_string($conn, $datetime);

$sql = "INSERT INTO doctors (doctor_name, image, specialization, datetime, menu_id)
        VALUES ('$doctor_name', '$image', '$specialization', '$datetime', $menu_id)";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?msg=added');
} else {
    echo 'Помилка: ' . mysqli_error($conn);
}