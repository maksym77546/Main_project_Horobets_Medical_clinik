<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$id             = intval($_POST['id'] ?? 0);
$doctor_name    = trim($_POST['doctor_name'] ?? '');
$image          = trim($_POST['image'] ?? '');
$specialization = trim($_POST['specialization'] ?? '');
$datetime       = trim($_POST['datetime'] ?? '');
$menu_id        = intval($_POST['menu_id'] ?? 0);

if (!$id || !$doctor_name || !$image || !$specialization || !$datetime || !$menu_id) {
    header("Location: edit-new.php?id=$id&error=1");
    exit();
}

$doctor_name    = mysqli_real_escape_string($conn, $doctor_name);
$image          = mysqli_real_escape_string($conn, $image);
$specialization = mysqli_real_escape_string($conn, $specialization);
$datetime       = mysqli_real_escape_string($conn, $datetime);

$sql = "UPDATE doctors SET
            doctor_name = '$doctor_name',
            image = '$image',
            specialization = '$specialization',
            datetime = '$datetime',
            menu_id = $menu_id
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?msg=updated');
} else {
    echo 'Помилка: ' . mysqli_error($conn);
}