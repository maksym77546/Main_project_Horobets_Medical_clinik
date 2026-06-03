<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');
include_once('../function.php'); // For schedule/cert functions

$id             = intval($_POST['id'] ?? 0);
$doctor_name    = trim($_POST['doctor_name'] ?? '');
$doctor_name_en = trim($_POST['doctor_name_en'] ?? '');
$phone_code     = trim($_POST['phone_code'] ?? '+380');
$phone_number   = trim($_POST['phone_number'] ?? '');
$phone          = $phone_code . $phone_number;
$cabinet        = trim($_POST['cabinet'] ?? '');
$specialization = trim($_POST['specialization'] ?? '');
$specialization_en = trim($_POST['specialization_en'] ?? '');
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
} else {
    // Якщо нове фото не вибрано залишаємо старе фото
    $image = $_POST['old_image'] ?? 'assets/no-image.jpg';
}

$doctor_name       = mysqli_real_escape_string($conn, $doctor_name);
$doctor_name_en    = mysqli_real_escape_string($conn, $doctor_name_en);
$phone             = mysqli_real_escape_string($conn, $phone);
$cabinet           = mysqli_real_escape_string($conn, $cabinet);
$image             = mysqli_real_escape_string($conn, $image);
$specialization    = mysqli_real_escape_string($conn, $specialization);
$specialization_en = mysqli_real_escape_string($conn, $specialization_en);
$datetime          = mysqli_real_escape_string($conn, $datetime);

$sql = "UPDATE doctors SET
            doctor_name = '$doctor_name',
            doctor_name_en = '$doctor_name_en',
            phone = '$phone',
            cabinet = '$cabinet',
            image = '$image',
            specialization = '$specialization',
            specialization_en = '$specialization_en',
            datetime = '$datetime',
            menu_id = $menu_id
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    // Process schedule
    $schedule_days = $_POST['schedule_days'] ?? [];
    $schedule_start = $_POST['schedule_start'] ?? [];
    $schedule_end = $_POST['schedule_end'] ?? [];
    
    $start_mapped = [];
    $end_mapped = [];
    if (!empty($schedule_days)) {
        foreach ($schedule_days as $day) {
            $idx = $day - 1; // Array index is 0-6
            $start_mapped[] = $schedule_start[$idx] ?? '';
            $end_mapped[] = $schedule_end[$idx] ?? '';
        }
        save_doctor_schedule($id, $schedule_days, $start_mapped, $end_mapped);
    } else {
        // Clear all schedule if none selected
        mysqli_query($conn, "DELETE FROM doctor_schedule WHERE doctor_id = $id");
    }
    
    // Process certificates
    $cert_titles = $_POST['cert_title'] ?? [];
    $cert_titles_en = $_POST['cert_title_en'] ?? [];
    $cert_dates = $_POST['cert_date'] ?? [];
    $cert_descs = $_POST['cert_desc'] ?? [];
    $cert_descs_en = $_POST['cert_desc_en'] ?? [];
    save_doctor_certificates($id, $cert_titles, $cert_titles_en, $cert_dates, $cert_descs, $cert_descs_en);

    header('Location: index.php?msg=updated');
} else {
    echo 'Помилка: ' . mysqli_error($conn);
}