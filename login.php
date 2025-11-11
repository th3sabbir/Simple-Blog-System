<?php
require_once 'config/db.php';

// Redirect if already logged in
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $query = "SELECT id, username, password, full_name FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
        $stmt->close();
    }
}

$page_title = "Login - Blogify";
$active_page = 'login';
?>

<?php include 'header.php'; ?>

    <!-- Login Form -->
    <section class="auth-section">
        <div class="container-narrow">
            <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-sign-in-alt"></i>
                    <h1>Welcome Back</h1>
                    <p>Login to continue sharing your stories</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['registered']) && $_GET['registered'] === 'success'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        Registration successful! Please login with your credentials.
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="register.php">Sign up here</a></p>
                    <p class="admin-link"><a href="admin/login.php"><i class="fas fa-shield-alt"></i> Admin Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
