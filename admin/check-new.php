<?php
    $db = new PDO('mysql:host=localhost; dbname=project;', 'root', '');
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_FILES['image'])&& $_FILES['image']['tmp_name'] !=''){
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/" . $_FILES['image']['name']);
        $img = "assets/" . $_FILES['image']['name'];
    }
    else {
        $img = '../assets/no-image.jpg';
    }
    $sql = "INSERT INTO news (title, content, image, datetime, menu_id)
            VALUES (:title, :content, :image, :date, :menu_id)";
    $stmt = $db->prepare($sql);
    $stmt ->bindValue(":title", $_POST['title']);
    $stmt ->bindValue(":content", $_POST['content']);
    $stmt ->bindValue(":image", $img);
    $stmt ->bindValue(":date", $_POST['date']);
    $stmt ->bindValue(":menu_id", $_POST['menu_id']);

    $stmt->execute();
    header('location:index.php');