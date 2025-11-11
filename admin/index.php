<?php
session_start();

// Check if admin is already logged in
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: dashboard.php');
    exit;
}

// If not logged in, redirect to login page
header('Location: login.php');
exit;
?>