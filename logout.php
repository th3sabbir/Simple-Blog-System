<?php
require_once 'config/db.php';

// Destroy session and redirect
session_destroy();
header('Location: index.php');
exit;
?>
