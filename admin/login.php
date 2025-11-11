<?php
session_start();

// Static admin credentials
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

// Check if already logged in as admin
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid admin credentials.';
    }
}

$page_title = "Admin Login - Blogify";
$active_page = 'admin_login';
?>

<?php include 'header.php'; ?>

    <section class="auth-section">
        <div class="container-narrow">
            <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-shield-alt"></i>
                    <h1>Admin Login</h1>
                    <p>Administrator access only</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user-shield"></i> Admin Username
                        </label>
                        <input type="text" id="username" name="username" placeholder="Enter admin username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Admin Password
                        </label>
                        <input type="password" id="password" name="password" placeholder="Enter admin password" required>
                    </div>

                    <button type="submit" class="btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Login as Admin
                    </button>
                </form>

                <div class="auth-footer">
                    <p><a href="../index.php"><i class="fas fa-home"></i> Back to Home</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
