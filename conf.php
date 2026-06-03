<?php
    $servername = 'sql308.infinityfree.com';
    $username = 'if0_41968366';
    $pass = 'vfSbrTiyIqBo0BL';
    $dbname = 'if0_41968366_krok1';

    $conn = mysqli_connect($servername, $username, $pass, $dbname);
    mysqli_set_charset($conn, 'utf8mb4');
    if (mysqli_connect_errno()) {
        echo 'Помилка підключення до бази даних ('.mysqli_connect_error().'):'.mysqli_connect_error();
        exit();
    }