<?php
// Default page title
if (!isset($page_title)) {
    $page_title = "Blogify - Share Your Stories";
}

// Default active page
if (!isset($active_page)) {
    $active_page = 'home';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="index.php" class="logo">
                    <i class="fas fa-blog"></i>
                    <span>Blogify</span>
                </a>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="index.php" class="<?php echo $active_page === 'home' ? 'active' : ''; ?>">Home</a></li>
                    <?php if (is_logged_in()): ?>
                        <li><a href="dashboard.php" class="<?php echo $active_page === 'dashboard' ? 'active' : ''; ?>">Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo htmlspecialchars(get_current_username()); ?></span>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="<?php echo $active_page === 'login' ? 'active' : ''; ?>">Login</a></li>
                        <li><a href="register.php" class="btn-primary <?php echo $active_page === 'register' ? 'active' : ''; ?>">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <button class="mobile-menu-toggle" id="mobileToggle" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>