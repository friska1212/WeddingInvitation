<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if all fields are filled
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        header('Location: register.php?error=required_fields');
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: register.php?error=invalid_email');
        exit;
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        header('Location: register.php?error=password_mismatch');
        exit;
    }
    
    // Check password length
    if (strlen($password) < 8) {
        header('Location: register.php?error=password_length');
        exit;
    }
    
    // Demo: Check if email already exists (in real app, check database)
    $existing_emails = ['customer@example.com', 'admin@weddinginvite.com'];
    if (in_array($email, $existing_emails)) {
        header('Location: register.php?error=email_exists');
        exit;
    }
    
    // Demo registration (in real app, save to database)
    // For demo purposes, we'll just redirect to login with success message
    
    // In a real application, you would:
    // 1. Hash the password: $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // 2. Save to database
    // 3. Send verification email
    // 4. Then redirect to login
    
    header('Location: login.php?success=registered');
    exit;
    
} else {
    // If not POST method, redirect to register
    header('Location: register.php');
    exit;
}
?>