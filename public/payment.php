<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../auth/login.php?redirect=payment');
    exit;
}

// Cek jika user adalah admin, redirect ke admin dashboard
if ($_SESSION['role'] === 'admin') {
    header('Location: ../admin/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - WeddingInvite</title>
    <style>
        :root {
            --primary: #e8b4b8;
            --secondary: #a26769;
            --light: #f9f5f0;
            --dark: #5d4e46;
            --white: #ffffff;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--light);
            padding: 50px; 
            text-align: center; 
        }
        
        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .success { 
            color: green; 
            font-size: 24px; 
            margin-bottom: 20px; 
        }
        
        .payment-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="logo">
            <i class="fas fa-heart"></i>
            WeddingInvite
        </a>
        <div class="user-menu">
            <span>Halo, <?php echo $_SESSION['name']; ?>!</span>
            <a href="../auth/logout.php" class="btn">Logout</a>
        </div>
    </nav>

    <div class="payment-container">
        <div class="success">✅ Login Berhasil!</div>
        <h1>Halaman Pembayaran</h1>
        <p>Selamat datang, <strong><?php echo $_SESSION['name']; ?></strong>!</p>
        <p>Silakan lanjutkan proses pembayaran untuk tema yang dipilih.</p>
        
        <div style="margin-top: 2rem;">
            <a href="dashboard.php" class="btn">Ke Dashboard</a>
            <a href="../auth/logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>