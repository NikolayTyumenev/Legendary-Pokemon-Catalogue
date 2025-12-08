<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ADMIN_TABLE', 'group_3_catalogue_admin');

function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function attempt_login($connection, $username, $password) {
    error_log("Attempting login for: " . $username);
    
    $query = "SELECT id, username, password FROM " . ADMIN_TABLE . " WHERE username = ? LIMIT 1";
    $stmt = mysqli_prepare($connection, $query);
    
    if (!$stmt) {
        error_log("Failed to prepare statement: " . mysqli_error($connection));
        return false;
    }
    
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        error_log("Found user in database");
        error_log("Hash from DB: " . $row['password']);
        
        if (password_verify($password, $row['password'])) {
            error_log("Password verified successfully!");
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            
            mysqli_stmt_close($stmt);
            return true;
        } else {
            error_log("Password verification FAILED");
        }
    } else {
        error_log("User NOT found in database");
    }
    
    mysqli_stmt_close($stmt);
    return false;
}

function logout_user() {
    $_SESSION = array();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
}

function get_current_username() {
    return $_SESSION['admin_username'] ?? null;
}
?>