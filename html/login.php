<?php
session_start(); 
require_once('../private/connect.php');
require_once('../private/authentication.php');

$connection = db_connect();

if (is_logged_in()) {
    header('Location: admin.php');
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (attempt_login($connection, $username, $password)) {
        set_success_message("Welcome back, {$username}!");
        header('Location: admin.php');
        exit;
    } else {
        $error_message = 'Invalid username or password.';
    }
}

$page_title = "Admin Login";
include('includes/header.php');
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Admin Login</h4>
            </div>
            <div class="card-body">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>
                
                <hr>
                
                <div class="alert alert-info mb-0">
                    <small>
                        <strong>Admin Access:</strong> Use your assigned credentials to access the admin panel.
                    </small>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-outline-secondary">
                Back to Home
            </a>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>