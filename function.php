
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
        $doctor_id = intval($doctor_id);
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

// ===============================
// ГРАФІК РОБОТИ ЛІКАРІВ
// ===============================

// отримання розкладу лікаря
function get_doctor_schedule($doctor_id) {
    global $conn;
    $doctor_id = intval($doctor_id);
    $sql = "SELECT * FROM doctor_schedule WHERE doctor_id = $doctor_id ORDER BY day_of_week ASC";
    $result = mysqli_query($conn, $sql);
    if (!$result) return [];
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// збереження розкладу лікаря (видаляє старий і вставляє новий)
function save_doctor_schedule($doctor_id, $days, $start_times, $end_times) {
    global $conn;
    $doctor_id = intval($doctor_id);
    
    // Видалити старий розклад
    mysqli_query($conn, "DELETE FROM doctor_schedule WHERE doctor_id = $doctor_id");
    
    // Вставити новий
    if (!empty($days) && is_array($days)) {
        foreach ($days as $i => $day) {
            $day = intval($day);
            $start = mysqli_real_escape_string($conn, $start_times[$i] ?? '08:00');
            $end = mysqli_real_escape_string($conn, $end_times[$i] ?? '17:00');
            if ($day >= 1 && $day <= 7 && !empty($start) && !empty($end)) {
                $sql = "INSERT INTO doctor_schedule (doctor_id, day_of_week, start_time, end_time) 
                        VALUES ($doctor_id, $day, '$start', '$end')";
                mysqli_query($conn, $sql);
            }
        }
    }
}

// ===============================
// СЕРТИФІКАТИ ЛІКАРІВ
// ===============================

// отримання сертифікатів лікаря
function get_doctor_certificates($doctor_id) {
    global $conn;
    $doctor_id = intval($doctor_id);
    $sql = "SELECT * FROM doctor_certificates WHERE doctor_id = $doctor_id ORDER BY issued_date DESC";
    $result = mysqli_query($conn, $sql);
    if (!$result) return [];
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// збереження сертифікатів лікаря (видаляє старі і вставляє нові)
function save_doctor_certificates($doctor_id, $titles, $dates, $descriptions) {
    global $conn;
    $doctor_id = intval($doctor_id);
    
    // Видалити старі сертифікати
    mysqli_query($conn, "DELETE FROM doctor_certificates WHERE doctor_id = $doctor_id");
    
    // Вставити нові
    if (!empty($titles) && is_array($titles)) {
        foreach ($titles as $i => $title) {
            $title = trim($title);
            if (empty($title)) continue;
            
            $title = mysqli_real_escape_string($conn, $title);
            $date = mysqli_real_escape_string($conn, $dates[$i] ?? '');
            $desc = mysqli_real_escape_string($conn, $descriptions[$i] ?? '');
            
            $date_val = !empty($date) ? "'$date'" : "NULL";
            $desc_val = !empty($desc) ? "'$desc'" : "NULL";
            
            $sql = "INSERT INTO doctor_certificates (doctor_id, title, issued_date, description) 
                    VALUES ($doctor_id, '$title', $date_val, $desc_val)";
            mysqli_query($conn, $sql);
        }
    }
}

// ===============================
// РЕЄСТРАЦІЯ ТА АВТОРИЗАЦІЯ КОРИСТУВАЧІВ
// ===============================

// реєстрація нового користувача
function register_user($full_name, $email, $phone, $password) {
    global $conn;
    $full_name = mysqli_real_escape_string($conn, trim($full_name));
    $email = mysqli_real_escape_string($conn, trim($email));
    $phone = mysqli_real_escape_string($conn, trim($phone));
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Перевірити чи email вже існує
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        return false; // email вже зайнятий
    }
    
    $sql = "INSERT INTO users (full_name, email, phone, password_hash) 
            VALUES ('$full_name', '$email', '$phone', '$password_hash')";
    return mysqli_query($conn, $sql);
}

// авторизація користувача
function login_user($email, $password) {
    global $conn;
    $email = mysqli_real_escape_string($conn, trim($email));
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        return $user;
    }
    return false;
}

// отримання користувача за ID
function get_user_by_id($user_id) {
    global $conn;
    $user_id = intval($user_id);
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// перевірка чи користувач авторизований
function is_user_logged_in() {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
}