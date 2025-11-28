<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data dari form
    $theme_id = $_POST['theme_id'];
    $groom_name = $_POST['groom_name'];
    $bride_name = $_POST['bride_name'];
    $wedding_date = $_POST['wedding_date'];
    $groom_father = $_POST['groom_father'];
    $groom_mother = $_POST['groom_mother'];
    $bride_father = $_POST['bride_father'];
    $bride_mother = $_POST['bride_mother'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_method = $_POST['payment_method'];
    $notes = $_POST['notes'];
    
    // Simpan data di session
    $_SESSION['order_data'] = [
        'theme_id' => $theme_id,
        'groom_name' => $groom_name,
        'bride_name' => $bride_name,
        'wedding_date' => $wedding_date,
        'groom_father' => $groom_father,
        'groom_mother' => $groom_mother,
        'bride_father' => $bride_father,
        'bride_mother' => $bride_mother,
        'email' => $email,
        'phone' => $phone,
        'payment_method' => $payment_method,
        'notes' => $notes,
        'order_date' => date('Y-m-d H:i:s')
    ];
    
    // Redirect ke halaman pembayaran
    header('Location: payment.php');
    exit;
} else {
    // Jika bukan POST, redirect ke dashboard
    header('Location: dashboard.php');
    exit;
}
?>