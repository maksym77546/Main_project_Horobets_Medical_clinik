<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
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

if (!$id || !$doctor_name || !$specialization || !$datetime || !$menu_id) {
    header("Location: edit-new.php?id=$id&error=1");
    exit();
}

// Handle file upload
$uploadedImage = '';
if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image_file']['tmp_name'];
    $fileName = $_FILES['image_file']['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    // Allowed extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp', 'svg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        // Safe unique file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../assets/uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }
        $dest_path = $uploadFileDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $uploadedImage = 'assets/uploads/' . $newFileName;
        }
    }
}

if (!empty($uploadedImage)) {
    $image = $uploadedImage;
} elseif (empty($image)) {
    // If both URL and file are empty, fallback to placeholder
    $image = 'assets/no-image.jpg';
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