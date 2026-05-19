<?php
    include_once ('../function.php');
    include_once ('../conf.php');
$new_id = $_GET['new_id'];
if (!is_numeric($new_id)) exit();

$new = delete_new($new_id);
header('location: index.php');