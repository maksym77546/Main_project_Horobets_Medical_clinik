<?php
include_once ('conf.php');

// Helper to translate database items dynamically from database columns
function translate_db_item(&$item) {
    if (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en') {
        if (isset($item['title_en']) && !empty($item['title_en'])) {
            $item['title'] = $item['title_en'];
        }
        if (isset($item['doctor_name_en']) && !empty($item['doctor_name_en'])) {
            $item['doctor_name'] = $item['doctor_name_en'];
        }
        if (isset($item['specialization_en']) && !empty($item['specialization_en'])) {
            $item['specialization'] = $item['specialization_en'];
        }
        if (isset($item['description_en']) && !empty($item['description_en'])) {
            $item['description'] = $item['description_en'];
        }
    }
}

//отримання пунктів меню
    function get_menu () {
        global $conn;
        $sql = "SELECT * FROM menu";

        $result = mysqli_query($conn, $sql);
        $menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if ($menus) {
            foreach ($menus as &$m) translate_db_item($m);
        }
        return $menus;
    }
// отримання списку лікарів
function get_doctors($search = '', $limit = 0, $offset = 0) {
     global $conn;
     $sql = "SELECT * FROM doctors";
     if (!empty($search)) {
         $search = mysqli_real_escape_string($conn, $search);
         $sql .= " WHERE doctor_name LIKE '%$search%' OR specialization LIKE '%$search%' OR doctor_name_en LIKE '%$search%' OR specialization_en LIKE '%$search%'";
     }
     
     if ($limit > 0) {
         $sql .= " LIMIT $limit OFFSET $offset";
     }
     
     $result = mysqli_query($conn, $sql);

     $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
     if ($doctors) {
         foreach ($doctors as &$d) translate_db_item($d);
     }
     return $doctors;
}

// отримання загальної кількості лікарів (для пагінації)
function get_total_doctors($search = '') {
     global $conn;
     $sql = "SELECT COUNT(*) as count FROM doctors";
     if (!empty($search)) {
         $search = mysqli_real_escape_string($conn, $search);
         $sql .= " WHERE doctor_name LIKE '%$search%' OR specialization LIKE '%$search%' OR doctor_name_en LIKE '%$search%' OR specialization_en LIKE '%$search%'";
     }
     $result = mysqli_query($conn, $sql);
     $row = mysqli_fetch_assoc($result);
     return intval($row['count']);
}
// отримання окремого лікаря
function get_doctor_by_id($doctor_id) {
        global $conn;
        $doctor_id = intval($doctor_id);
        $sql = "SELECT * FROM doctors WHERE id =" .$doctor_id;
        $result = mysqli_query($conn, $sql);
        $doctor = mysqli_fetch_assoc($result);
        if ($doctor) translate_db_item($doctor);
        return $doctor;
}
//отримання лікарів за категорією
function get_doctors_by_category($category_id, $limit = 0, $offset = 0) {
        global $conn;
        $category_id = mysqli_real_escape_string($conn, $category_id);
        $sql = "SELECT * FROM doctors WHERE menu_id=".$category_id;

        if ($limit > 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $result = mysqli_query($conn, $sql);
        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
        if ($doctors) {
            foreach ($doctors as &$d) translate_db_item($d);
        }
        return $doctors;
}

// отримання загальної кількості лікарів у категорії (для пагінації)
function get_total_doctors_by_category($category_id) {
    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $sql = "SELECT COUNT(*) as count FROM doctors WHERE menu_id=".$category_id;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return intval($row['count']);
}
// отримання назви категорії
function get_category_title($category_id) {
        global $conn;
        $category_id = mysqli_real_escape_string($conn, $category_id);
        $sql = "SELECT * FROM menu WHERE id=".$category_id;
        $result = mysqli_query($conn, $sql);
        $category = mysqli_fetch_assoc($result);
        if ($category) translate_db_item($category);
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
    $certs = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if ($certs) {
        foreach ($certs as &$c) translate_db_item($c);
    }
    return $certs;
}

// збереження сертифікатів лікаря (видаляє старі і вставляє нові)
function save_doctor_certificates($doctor_id, $titles, $titles_en, $dates, $descriptions, $descriptions_en) {
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
            $title_en = mysqli_real_escape_string($conn, $titles_en[$i] ?? '');
            $date = mysqli_real_escape_string($conn, $dates[$i] ?? '');
            $desc = mysqli_real_escape_string($conn, $descriptions[$i] ?? '');
            $desc_en = mysqli_real_escape_string($conn, $descriptions_en[$i] ?? '');
            
            $date_val = !empty($date) ? "'$date'" : "NULL";
            $desc_val = !empty($desc) ? "'$desc'" : "NULL";
            $desc_en_val = !empty($desc_en) ? "'$desc_en'" : "NULL";
            $title_en_val = !empty($title_en) ? "'$title_en'" : "NULL";
            
            $sql = "INSERT INTO doctor_certificates (doctor_id, title, title_en, issued_date, description, description_en) 
                    VALUES ($doctor_id, '$title', $title_en_val, $date_val, $desc_val, $desc_en_val)";
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

// ===============================
// СИСТЕМА ЗАПИСУ НА ПРИЙОМ
// ===============================

// отримання доступних годин для лікаря на певну дату
function get_available_slots($doctor_id, $date) {
    global $conn;
    $doctor_id = intval($doctor_id);
    $date = mysqli_real_escape_string($conn, trim($date));
    
    // Визначаємо день тижня (1=Пн ... 7=Нд)
    $timestamp = strtotime($date);
    if (!$timestamp) return [];
    $day_of_week = date('N', $timestamp);
    
    // Отримуємо графік лікаря на цей день
    $sql_sched = "SELECT start_time, end_time FROM doctor_schedule WHERE doctor_id = $doctor_id AND day_of_week = $day_of_week";
    $res_sched = mysqli_query($conn, $sql_sched);
    $schedule = mysqli_fetch_assoc($res_sched);
    
    if (!$schedule) {
        return []; // Не працює в цей день
    }
    
    $start_time = strtotime($schedule['start_time']);
    $end_time = strtotime($schedule['end_time']);
    
    // Генеруємо всі можливі слоти (кожні 30 хвилин)
    $all_slots = [];
    $current_time = $start_time;
    while ($current_time + 1800 <= $end_time) { // 1800 секунд = 30 хвилин
        $all_slots[] = date('H:i', $current_time);
        $current_time += 1800;
    }
    
    // Отримуємо вже заброньовані слоти на цю дату
    $sql_booked = "SELECT TIME_FORMAT(appointment_time, '%H:%i') as booked_time FROM appointments WHERE doctor_id = $doctor_id AND appointment_date = '$date' AND status = 'booked'";
    $res_booked = mysqli_query($conn, $sql_booked);
    $booked_slots = [];
    while ($row = mysqli_fetch_assoc($res_booked)) {
        $booked_slots[] = $row['booked_time'];
    }
    
    // Фільтруємо вільні слоти
    $available_slots = array_diff($all_slots, $booked_slots);
    
    return array_values($available_slots);
}

// отримання активних записів користувача до певного лікаря
function get_user_appointments_for_doctor($user_id, $doctor_id) {
    global $conn;
    $user_id = intval($user_id);
    $doctor_id = intval($doctor_id);
    
    $sql = "SELECT id, appointment_date, TIME_FORMAT(appointment_time, '%H:%i') as appointment_time 
            FROM appointments 
            WHERE user_id = $user_id AND doctor_id = $doctor_id AND status = 'booked' AND appointment_date >= CURDATE()
            ORDER BY appointment_date ASC, appointment_time ASC";
            
    $result = mysqli_query($conn, $sql);
    if (!$result) return [];
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}