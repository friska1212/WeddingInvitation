<?php
session_start();

// Jika sudah login, redirect
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$page_title = "Daftar - WeddingInvite";

// Check for error messages
$error = isset($_GET['error']) ? $_GET['error'] : '';
$error_message = '';

switch ($error) {
    case 'email_exists':
        $error_message = 'Email sudah terdaftar!';
        break;
    case 'password_mismatch':
        $error_message = 'Password tidak cocok!';
        break;
    case 'required_fields':
        $error_message = 'Semua field harus diisi!';
        break;
    case 'invalid_email':
        $error_message = 'Format email tidak valid!';
        break;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        .register-page {
            padding: 120px 0 80px;
            background: linear-gradient(135deg, var(--light), var(--white));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .register-container {
            max-width: 500px;
            margin: 0 auto;
            background: var(--white);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header h1 {
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .register-header p {
            color: var(--gray);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 180, 184, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            margin-top: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .register-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--light-gray);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background: rgba(232, 72, 85, 0.1);
            color: var(--danger);
            border: 1px solid rgba(232, 72, 85, 0.2);
        }

        .password-requirements {
            background: var(--light-gray);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .password-requirements h4 {
            margin-bottom: 0.5rem;
            color: var(--secondary);
        }

        .requirement {
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .requirement i {
            color: var(--success);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .register-page {
                padding: 100px 0 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="../index.html" class="logo">
                    <i class="fas fa-heart"></i>
                    WeddingInvite
                </a>
                <div class="nav-actions">
                    <a href="login.php" class="btn btn-outline">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="register-page">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1>Daftar Akun Baru</h1>
                    <p>Buat akun untuk memesan undangan digital</p>
                </div>

                <!-- Error Message -->
                <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
                <?php endif; ?>

                <form action="process-register.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">
                                <i class="fas fa-user"></i> Nama Depan
                            </label>
                            <input type="text" id="first_name" name="first_name" required 
                                   placeholder="Masukkan nama depan">
                        </div>

                        <div class="form-group">
                            <label for="last_name">
                                <i class="fas fa-user"></i> Nama Belakang
                            </label>
                            <input type="text" id="last_name" name="last_name" required 
                                   placeholder="Masukkan nama belakang">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="email" name="email" required 
                               placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <i class="fas fa-phone"></i> Nomor WhatsApp
                        </label>
                        <input type="tel" id="phone" name="phone" required 
                               placeholder="628123456789">
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-key"></i> Password
                        </label>
                        <input type="password" id="password" name="password" required 
                               placeholder="Buat password yang kuat">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">
                            <i class="fas fa-key"></i> Konfirmasi Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required 
                               placeholder="Ulangi password Anda">
                    </div>

                    <div class="password-requirements">
                        <h4><i class="fas fa-info-circle"></i> Kriteria Password</h4>
                        <div class="requirement">
                            <i class="fas fa-check"></i>
                            <span>Minimal 8 karakter</span>
                        </div>
                        <div class="requirement">
                            <i class="fas fa-check"></i>
                            <span>Mengandung huruf dan angka</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-register">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>

                    <div class="register-footer">
                        <p>Sudah punya akun? <a href="login.php" style="color: var(--primary); font-weight: 500;">Login di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Password confirmation validation
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        function validatePassword() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = 'var(--danger)';
                return false;
            } else {
                confirmPassword.style.borderColor = '';
                return true;
            }
        }
        
        confirmPassword.addEventListener('input', validatePassword);
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validatePassword()) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }
            
            if (password.value.length < 8) {
                e.preventDefault();
                alert('Password harus minimal 8 karakter!');
                return;
            }
        });
    </script>
</body>
</html>