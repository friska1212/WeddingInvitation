<?php
session_start();

// Include file konfigurasi database
require_once '../config/database.php';

// Initialize database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=weddinginvitation", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jika koneksi gagal, tetap lanjut tanpa database (untuk demo)
    $pdo = null;
}

// CEK JIKA SUDAH LOGIN - REDIRECT LANGSUNG
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../public/dashboard.php');
        exit;
    } else {
        // Untuk customer, cek apakah ada redirect specific
        if (isset($_GET['redirect']) && $_GET['redirect'] === 'payment') {
            header('Location: ../public/payment.php');
        } else if (isset($_GET['theme_id'])) {
            header('Location: ../public/order.php?theme_id=' . $_GET['theme_id']);
        } else {
            header('Location: ../public/dashboard.php');
        }
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        
        // Simulasi login tanpa database (untuk sementara)
        if ($email === 'admin@weddinginvite.com' && $password === 'admin123') {
            // Login sebagai admin
            $_SESSION['user_id'] = 1;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'admin';
            $_SESSION['name'] = 'Administrator';
            $_SESSION['logged_in'] = true; // PASTIKAN INI ADA
            
            header('Location: ../admin/dashboard.php');
            exit;
        } else {
            // Login sebagai customer (auto create session)
            $_SESSION['user_id'] = time(); // ID sementara
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'customer';
            $_SESSION['name'] = explode('@', $email)[0];
            $_SESSION['logged_in'] = true; // PASTIKAN INI ADA
            
            // Cek apakah ada redirect URL atau tema yang dipilih
            if (isset($_POST['redirect']) && $_POST['redirect'] === 'payment') {
                // Redirect ke halaman pembayaran
                header('Location: ../public/payment.php');
            } else if (isset($_POST['theme_id']) && !empty($_POST['theme_id'])) {
                // Redirect ke halaman order dengan tema tertentu
                header('Location: ../public/order.php?theme_id=' . $_POST['theme_id']);
            } else {
                // Default redirect ke dashboard
                header('Location: ../public/dashboard.php');
            }
            exit;
        }
        
    } else {
        $error = "Harap isi semua field.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - WeddingInvite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e8b4b8;
            --secondary: #a26769;
            --light: #f9f5f0;
            --dark: #5d4e46;
            --accent: #d8a48f;
            --white: #ffffff;
            --gray: #6c757d;
            --light-gray: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--secondary), var(--dark));
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right {
            flex: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo i {
            color: var(--primary);
        }

        .welcome-text h1 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .features {
            list-style: none;
            margin-top: 30px;
        }

        .features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .features i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .login-form h2 {
            color: var(--secondary);
            margin-bottom: 30px;
            font-size: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s;
            margin-top: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--gray);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            font-size: 0.9rem;
        }

        .demo-info {
            margin-top: 20px;
            padding: 15px;
            background: var(--light-gray);
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            font-size: 0.9rem;
        }

        .demo-info h4 {
            color: var(--secondary);
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .login-left {
                padding: 30px;
            }
            
            .login-right {
                padding: 30px;
            }
            
            .welcome-text h1 {
                font-size: 1.8rem;
            }
            
            .login-form h2 {
                fontSize: 1.6rem;
            }
        }

        @media (max-width: 480px) {
            .login-left, .login-right {
                padding: 20px;
            }
            
            .welcome-text h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Welcome -->
        <div class="login-left">
            <div class="logo">
                <i class="fas fa-heart"></i>
                <span>WeddingInvite</span>
            </div>
            <div class="welcome-text">
                <h1>Selamat Datang Kembali!</h1>
            </div>
    
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-form">
                <h2>Masuk</h2>

                <?php if (isset($error)): ?>
                    <div class="error-message">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" id="loginForm">
                    <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">
                    <input type="hidden" name="theme_id" value="<?php echo isset($_GET['theme_id']) ? htmlspecialchars($_GET['theme_id']) : ''; ?>">
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <input type="email" id="email" name="email" placeholder="masukkan email Anda" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" placeholder="masukkan password Anda" required>
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="register.php">Daftar di sini!</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto focus on email field
            document.getElementById('email').focus();
            
            // Check URL parameters for redirect info
            const urlParams = new URLSearchParams(window.location.search);
            const redirect = urlParams.get('redirect');
            const themeId = urlParams.get('theme_id');
            
            console.log('Redirect:', redirect);
            console.log('Theme ID:', themeId);
        });
    </script>
</body>
</html>