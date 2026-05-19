<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../login/index.php');
    exit();
}
include_once('../conf.php');

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header('Location: index.php');
    exit();
}

$sql = "DELETE FROM doctors WHERE id = $id";
mysqli_query($conn, $sql);

header('Location: index.php?msg=deleted');
exit();