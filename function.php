
<?php
include_once ('conf.php');
//отримання пунктів меню
    function get_menu () {
        global $conn;
        $sql = "SELECT * FROM menu";

        $result = mysqli_query($conn, $sql);
        $menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $menus;
    }
// отримання списку лікарів
function get_doctors($search = '') {
     global $conn;
     $sql = "SELECT * FROM doctors";
     if (!empty($search)) {
         $search = mysqli_real_escape_string($conn, $search);
         $sql .= " WHERE doctor_name LIKE '%$search%' OR specialization LIKE '%$search%'";
     }
     $result = mysqli_query($conn, $sql);

     $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
     return $doctors;
}
// отримання окремого лікаря
function get_doctor_by_id($doctor_id) {
        global $conn;
        $sql = "SELECT * FROM doctors WHERE id =" .$doctor_id;
        $result = mysqli_query($conn, $sql);
        $doctor = mysqli_fetch_assoc($result);
        return $doctor;
}
//отримання лікарів за категорією
function get_doctors_by_category($category_id) {
        global $conn;
        $category_id = mysqli_real_escape_string($conn, $category_id);
        $sql = "SELECT * FROM doctors WHERE menu_id=".$category_id;

        $result = mysqli_query($conn, $sql);
        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $doctors;
}
// отримання назви категорії
function get_category_title($category_id) {
        global $conn;
        $category_id = mysqli_real_escape_string($conn, $category_id);
        $sql = "SELECT * FROM menu WHERE id=".$category_id;
        $result = mysqli_query($conn, $sql);
        $category = mysqli_fetch_assoc($result);
        return $category;
}
// видалення лікаря
function delete_doctor($doctor_id) {
        global $conn;
        $doctor_id = mysqli_real_escape_string($conn, $doctor_id);

        $sql = "DELETE FROM doctors WHERE id =" .$doctor_id;
        $result = mysqli_query($conn, $sql);

}