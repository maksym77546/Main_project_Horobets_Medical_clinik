
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
// отримання списку новин
function get_news() {
     global $conn;
     $sql = "SELECT * FROM news";
     $result = mysqli_query($conn, $sql);

     $news = mysqli_fetch_all($result, MYSQLI_ASSOC);
     return $news;
}
// отримання окремої новини
function get_news_by_id($post_id) {
        global $conn;
        $sql = "SELECT * FROM news WHERE id =" .$post_id;
        $result = mysqli_query($conn, $sql);
        $post = mysqli_fetch_assoc($result);
        return $post;
}
//отримання категорії новини
function get_new_by_category($category_id) {
        global $conn;
        $category_id = mysqli_real_escape_string($conn, $category_id);
        $sql = "SELECT * FROM news WHERE menu_id=".$category_id;

        $result = mysqli_query($conn, $sql);
        $new = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $new;
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
// видалення новини
function delete_new($new_id) {
        global $conn;
        $new_id = mysqli_real_escape_string($conn, $new_id);

        $sql = "DELETE FROM news WHERE id =" .$new_id;
        $result = mysqli_query($conn, $sql);

}