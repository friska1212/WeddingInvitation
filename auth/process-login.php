<?php
session_start();

if ($is_valid) {
    // Set session
    $_SESSION['user_email'] = $email;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
    
    // Redirect berdasarkan user type
    if ($user_type === 'admin') {
        header('Location: ../admin/dashboard.php');
    } else {
        header('Location: ../public/dashboard.php');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user_type = $_POST['user_type'] ?? 'customer';
    
    // Validasi input
    if (empty($email) || empty($password)) {
        header('Location: login.php?error=required');
        exit;
    }
    
    // Demo credentials - dalam production, gunakan database
    $valid_credentials = [
        'admin' => [
            'email' => 'admin@weddinginvite.com',
            'password' => 'password123'
        ],
        'customer' => [
            'email' => 'customer@example.com', 
            'password' => 'password123'
        ]
    ];
    
    // Check credentials
    $is_valid = false;
    foreach ($valid_credentials as $type => $cred) {
        if ($email === $cred['email'] && $password === $cred['password']) {
            $is_valid = true;
            $user_type = $type;
            break;
        }
    }
    
    if ($is_valid) {
        // Set session
        $_SESSION['user_email'] = $email;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Redirect ke dashboard
        header('Location: ../public/dashboard.php');
        exit;
    } else {
        // Invalid credentials
        header('Location: login.php?error=invalid');
        exit;
    }
} else {
    // Jika bukan POST, redirect ke login
    header('Location: login.php');
    exit;
}
?>