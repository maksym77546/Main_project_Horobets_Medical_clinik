<?php
session_start();
include_once('conf.php');
include_once('function.php');

if (!isset($_GET['doctor_id']) || !isset($_GET['date'])) {
    echo json_encode(['error' => 'Missing parameters']);
    exit();
}

$doctor_id = intval($_GET['doctor_id']);
$date = trim($_GET['date']);

// Check if date is valid
if (!strtotime($date)) {
    echo json_encode(['error' => 'Invalid date']);
    exit();
}

// Ensure the date is not in the past
if (strtotime($date) < strtotime('today')) {
    echo json_encode(['slots' => []]);
    exit();
}

$slots = get_available_slots($doctor_id, $date);

echo json_encode(['slots' => $slots]);
?>
