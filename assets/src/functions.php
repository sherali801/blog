<?php

require_once('db_connect.php');
require_once('session.php');

function redirect_to($destination) {
    header('Location: ' . $destination);
    exit;
}

function mySqlFormattedTime($dt) {
    return strftime("%Y-%m-%d %H:%M:%S", $dt);
}

function offset($current_page, $per_page) {
    return ($current_page - 1) * $per_page;
}

function total_pages($total_count, $per_page) {
    return ceil($total_count / $per_page);
}

function affected_rows($rows = 1) {
    global $db;
    return ($db->affected_rows == $rows) ? true : false;
}

function last_insert_id() {
    global $db;
    return $db->insert_id;
}

function escape_string($string) {
    global $db;
    return $db->real_escape_string($string);
}

function confirm_query($result) {
    if (!$result) {
        die("Please Try Again Later.");
    }
}

function execute_query($sql) {
    global $db;
    $result = $db->query($sql);
    confirm_query($result);
    return $result;
}

function shift_result($result) {
    $result = $result->fetch_row();
    return array_shift($result);
}

function count_rows($table) {
    $sql = "SELECT COUNT(*) FROM {$table}";
    $result = execute_query($sql);
    return (int)  shift_result($result);
}

function count_users() {
    $table = "user";
    return count_rows($table);
}

function check_length($string, $min_length = 1, $max_length = 255) {
    $string_length = strlen($string);
    return ($string_length > $min_length && $string_length <= $max_length) ? true : false;
}

function duplicate_username($username, $user_id = 0) {
    $sql = "SELECT COUNT(*) FROM user WHERE username = '{$username}'";
    if ($user_id) {
        $sql .= " AND id != {$user_id}";
    }
    $result = execute_query($sql);
    $result = shift_result($result);
    return $result ? true : false;
}

function check_username($username, $user_id = 0) {
    if (!duplicate_username($username, $user_id)) {
        if (check_length($username)) {
            if (preg_match("/^[\w.%+\-]+@[\w.\-]+\.[A-Za-z]{2,6}$/", $username)) {
                return true;
            } else {
                $_SESSION['messages'][] = "Email pattern does not match.";
                return false;
            }
        } else {
            $_SESSION['messages'][] = "Email length must be less than 256.";
            return false;
        }
    } else {
        $_SESSION['messages'][] = "Email \"{$username}\" already exsist.";
        return false;
    }
}

function check_password($pwd) {
    if (preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])\S{8,15}$/", $pwd)) {
        return password_hash($pwd, PASSWORD_DEFAULT);
    } else {
        $_SESSION['messages'][] = "Password pattern does not match.";
        return false;
    }
}

function password_confirm($user_id, $old_pwd) {
    $sql = "SELECT pwd FROM user WHERE id = {$user_id}";
    $result = execute_query($sql);
    $result = shift_result($result);
    if (password_verify($old_pwd, $result)) {
        return true;
    } else {
        $_SESSION['messages'][] = 'Password confirmation failed.';
        return false;
    }
}

function insert_user($username, $pwd) {
    $dt = mySqlFormattedTime(time());
    $sql = "INSERT INTO user (
            username, pwd, created_at, updated_at
            ) VALUES (
            '{$username}', '{$pwd}', '{$dt}', '{$dt}'
            )";
    execute_query($sql);
    return affected_rows(1);
}

function update_user($user_id, $username, $pwd) {
    $dt = mySqlFormattedTime(time());
    $sql = "UPDATE user SET
            username = '{$username}',
            pwd = '{$pwd}',
            updated_at = '{$dt}'
            WHERE id = {$user_id}
            LIMIT 1";
    execute_query($sql);
    return affected_rows(1);
}

function delete_user($user_id) {
    $sql = "DELETE FROM user WHERE id = {$user_id} LIMIT 1";
    execute_query($sql);
    return affected_rows(1);
}

function get_all_users() {
    $sql = "SELECT id, username
            FROM user";
    $result = execute_query($sql);
    return $result;
}

function get_user_by_id($user_id) {
    $sql = "SELECT username
            FROM user
            WHERE id = {$user_id}";
    $result = execute_query($sql);
    return $result;
}

function log_in($username, $pwd) {
    $sql = "SELECT id, username, pwd
            FROM user
            WHERE username = '{$username}'
            LIMIT 1";
    $result = execute_query($sql);
    $result = $result->fetch_assoc();
    if ($username == $result['username'] && password_verify($pwd, $result['pwd'])) {
        $_SESSION['user_id'] = $result['id'];
        return true;
    } else {
        $_SESSION['messages'][] = "Email/Password combination does not match.";
        return false;
    }
}

function create_post_category($post_category_name, $visibility, $user_id) {
    $dt = mySqlFormattedTime(time());
    $sql = "INSERT INTO post_category (
            post_category_name, visibility, created_at, updated_at, user_id
            ) VALUES (
            '{$post_category_name}', {$visibility}, '{$dt}', '{$dt}', {$user_id}
            )";
    execute_query($sql);
    return affected_rows(1);
}

function get_all_post_categories() {
    $sql = "SELECT id, post_category_name
            FROM post_category
            WHERE visibility = 1";
    return execute_query($sql);
}

function get_all_post_categories_by_user_id($user_id) {
    $sql = "SELECT id, post_category_name, visibility
            FROM post_category
            WHERE user_id = {$user_id}";
    return execute_query($sql);
}

function get_post_category_by_id($post_category_id, $user_id) {
    $sql = "SELECT post_category_name, visibility
            FROM post_category
            WHERE id = {$post_category_id}
            AND user_id = {$user_id}";
    return execute_query($sql);
}

function update_post_category($post_category_id, $post_category_name, $visibility) {
    $sql = "UPDATE post_category SET
            post_category_name = '{$post_category_name}',
            visibility = {$visibility}
            WHERE id = {$post_category_id}
            LIMIT 1";
    execute_query($sql);
    return affected_rows();
}

function create_video_category($video_category_name, $visibility, $user_id) {
    $dt = mySqlFormattedTime(time());
    $sql = "INSERT INTO video_category (
            video_category_name, visibility, created_at, updated_at, user_id
            ) VALUES (
            '{$video_category_name}', {$visibility}, '{$dt}', '{$dt}', {$user_id}
            )";
    execute_query($sql);
    return affected_rows();
}

function get_all_video_categories() {
    $sql = "SELECT id, video_category_name
            FROM video_category
            WHERE visibility = 1";
    return execute_query($sql);
}

function get_all_video_categories_by_user_id($user_id) {
    $sql = "SELECT id, video_category_name, visibility
            FROM video_category
            WHERE user_id = {$user_id}";
    return execute_query($sql);
}

function get_video_category_by_id($video_category_id, $user_id) {
    $sql = "SELECT video_category_name, visibility
            FROM video_category
            WHERE id = {$video_category_id}
            AND user_id = {$user_id}";
    return execute_query($sql);
}

function update_video_category($video_category_id, $video_category_name, $visibility) {
    $sql = "UPDATE video_category SET
            video_category_name = '{$video_category_name}',
            visibility = {$visibility}
            WHERE id = {$video_category_id}
            LIMIT 1";
    execute_query($sql);
    return affected_rows();
}

function create_post($title, $body, $visibility, $post_category_id, $user_id) {
    $dt = mySqlFormattedTime(time());
    $sql = "INSERT INTO post (
            title, body, visibility, created_at, updated_at, user_id, post_category_id
            ) VALUES (
            '{$title}', '{$body}', {$visibility}, '{$dt}', '{$dt}', {$user_id}, {$post_category_id}
            )";
    execute_query($sql);
    return affected_rows();
}

function get_all_posts_by_user_id($user_id) {
    $sql = "SELECT p.id, p.title, p.body, p.visibility, pc.post_category_name
            FROM post p, post_category pc
            WHERE p.user_id = {$user_id}
            AND p.post_category_id = pc.id";
    return execute_query($sql);
}

function get_post_by_id($post_id, $user_id) {
    $sql = "SELECT p.title, p.body, p.visibility, pc.post_category_name
            FROM post p, post_category pc
            WHERE p.id = {$post_id}
            AND p.user_id = {$user_id}
            AND p.post_category_id = pc.id";
    return execute_query($sql);
}

function get_posts($q, $per_page, $offset) {
    $sql = "SELECT title, body
            FROM post
            WHERE visibility = 1";
    if (!empty($q)) {
        $sql .= " AND (title LIKE '%{$q}%'
                  OR body LIKE '%{$q}%')";
    }
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$offset}";
    return execute_query($sql);
}

function get_posts_by_category_id($q, $post_category_id, $per_page, $offset) {
    $sql = "SELECT title, body
            FROM post
            WHERE visibility = 1
            AND post_category_id = {$post_category_id}";
    if (!empty($q)) {
        $sql .= " AND (title LIKE '%{$q}%'
                  OR body LIKE '%{$q}%')";
    }
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$offset}";
    return execute_query($sql);
}

function update_post($post_id, $title, $body, $visibility, $post_category_id, $user_id) {
    $sql = "UPDATE post SET
            title = '{$title}',
            body = '{$body}',
            visibility = {$visibility},
            post_category_id = {$post_category_id}
            WHERE id = {$post_id}
            AND user_id = {$user_id}";
    execute_query($sql);
    return affected_rows();
}

function count_posts($q = '') {
    $sql = "SELECT COUNT(*)
            FROM post
            WHERE visibility = 1";
    if (!empty($q)) {
        $sql .= " AND (title LIKE '%{$q}%'
                  OR body LIKE '%{$q}%')";
    }
    $result = execute_query($sql);
    return (int) shift_result($result);
}

function count_posts_by_category_id($q, $post_category_id) {
    $sql = "SELECT COUNT(*)
            FROM post
            WHERE visibility = 1
            AND post_category_id = {$post_category_id}";
    if (!empty($q)) {
        $sql .= " AND (title LIKE '%{$q}%'
                  OR body LIKE '%{$q}%')";
    }
    $result = execute_query($sql);
    return (int) shift_result($result);
}

function create_video($title, $url, $visibility, $video_category_id, $user_id) {
    $dt = mySqlFormattedTime(time());
    $sql = "INSERT INTO video (
            title, url, visibility, created_at, updated_at, user_id, video_category_id
            ) VALUES (
            '{$title}', '{$url}', {$visibility}, '{$dt}', '{$dt}', {$user_id}, {$video_category_id}
            )";
    execute_query($sql);
    return affected_rows();
}

function get_all_videos_by_user_id($user_id) {
    $sql = "SELECT v.id, v.title, v.url, v.visibility, vc.video_category_name
            FROM video v, video_category vc
            WHERE v.user_id = {$user_id}
            AND v.video_category_id = vc.id";
    return execute_query($sql);
}

function get_video_by_id($video_id, $user_id) {
    $sql = "SELECT v.title, v.url, v.visibility, vc.video_category_name
            FROM video v, video_category vc
            WHERE v.id = {$video_id}
            AND v.user_id = {$user_id}
            AND v.video_category_id = vc.id";
    return execute_query($sql);
}

function update_video($video_id, $title, $url, $visibility, $video_category_id, $user_id) {
    $sql = "UPDATE video SET
            title = '{$title}',
            url = '{$url}',
            visibility = {$visibility},
            video_category_id = {$video_category_id}
            WHERE id = {$video_id}
            AND user_id = {$user_id}";
    execute_query($sql);
    return affected_rows();
}

function count_videos_by_category_id($q, $video_category_id) {
    $sql = "SELECT COUNT(*)
            FROM video
            WHERE visibility = 1
            AND video_category_id = {$video_category_id}";
    if (!empty($q)) {
        $sql .= " AND (title LIKE '%{$q}%'
                  OR body LIKE '%{$q}%')";
    }
    $result = execute_query($sql);
    return (int) shift_result($result);
}

function get_videos_by_category_id($q, $video_category_id, $per_page, $offset) {
    $sql = "SELECT title, url
            FROM video
            WHERE visibility = 1
            AND video_category_id = {$video_category_id}";
    if (!empty($q)) {
        $sql .= " AND title LIKE '%{$q}%'";
    }
    $sql .= " LIMIT {$per_page}";
    $sql .= " OFFSET {$offset}";
    return execute_query($sql);
}

?>
