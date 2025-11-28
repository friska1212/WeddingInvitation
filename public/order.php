<?php
session_start();

// Cek jika belum login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../auth/login.php');
    exit;
}

// Ambil theme_id dari URL
$theme_id = $_GET['theme_id'] ?? 0;
$user_name = $_SESSION['name'] ?? 'User';

// Data tema (harus sama dengan di themes.php)
$themes = [
    ['id' => 1, 'name' => 'Klasik Elegan', 'category' => 'classic', 'price' => 500000, 'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'],
    ['id' => 2, 'name' => 'Modern Minimalis', 'category' => 'modern', 'price' => 450000, 'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'],
    ['id' => 3, 'name' => 'Rustic Alam', 'category' => 'rustic', 'price' => 600000, 'image' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'],
    ['id' => 4, 'name' => 'Bohemian Dream', 'category' => 'bohemian', 'price' => 550000, 'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'],
    ['id' => 5, 'name' => 'Simple & Clean', 'category' => 'minimalist', 'price' => 350000, 'image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80'],
    ['id' => 6, 'name' => 'Royal Luxury', 'category' => 'classic', 'price' => 800000, 'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80'],
];

// Cari tema berdasarkan ID
$selected_theme = null;
foreach ($themes as $theme) {
    if ($theme['id'] == $theme_id) {
        $selected_theme = $theme;
        break;
    }
}

// Jika tema tidak ditemukan, redirect ke themes.php
if (!$selected_theme) {
    header('Location: themes.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Proses data form di sini
    $bridegroom_name = $_POST['bridegroom_name'] ?? '';
    $bride_name = $_POST['bride_name'] ?? '';
    $wedding_date = $_POST['wedding_date'] ?? '';
    $wedding_time = $_POST['wedding_time'] ?? '';
    $wedding_venue = $_POST['wedding_venue'] ?? '';
    
    // Data orang tua mempelai pria
    $bridegroom_father = $_POST['bridegroom_father'] ?? '';
    $bridegroom_mother = $_POST['bridegroom_mother'] ?? '';
    
    // Data orang tua mempelai wanita
    $bride_father = $_POST['bride_father'] ?? '';
    $bride_mother = $_POST['bride_mother'] ?? '';
    
    $additional_notes = $_POST['additional_notes'] ?? '';
    
    // Simpan ke session atau database
    $_SESSION['order_data'] = [
        'theme_id' => $theme_id,
        'theme_name' => $selected_theme['name'],
        'bridegroom_name' => $bridegroom_name,
        'bride_name' => $bride_name,
        'wedding_date' => $wedding_date,
        'wedding_time' => $wedding_time,
        'wedding_venue' => $wedding_venue,
        'bridegroom_father' => $bridegroom_father,
        'bridegroom_mother' => $bridegroom_mother,
        'bride_father' => $bride_father,
        'bride_mother' => $bride_mother,
        'additional_notes' => $additional_notes,
        'total_price' => $selected_theme['price']
    ];
    
    // Redirect ke halaman pembayaran
    header('Location: payment.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Tema <?php echo $selected_theme['name']; ?> - WeddingInvite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e8b4b8;
            --secondary: #a26769;
            --light: #f9f5f0;
            --dark: #5d4e46;
            --white: #ffffff;
            --gray: #6c757d;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .welcome {
            font-weight: 500;
        }
        
        .logout-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .order-container {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 3rem;
            margin-top: 2rem;
        }

        .theme-preview {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .theme-image {
            width: 100%;
            height: 250px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .theme-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .theme-info h2 {
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }

        .theme-price {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .theme-description {
            color: var(--gray);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .order-form {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: var(--shadow);
        }

        .form-title {
            color: var(--secondary);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            border-bottom: 2px solid var(--light);
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .required {
            color: #e74c3c;
        }

        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--light);
        }

        .form-section h3 {
            color: var(--secondary);
            margin-bottom: 1rem;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section h3 i {
            color: var(--primary);
        }

        .parents-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .parents-section {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .parents-section h4 {
            color: var(--secondary);
            margin-bottom: 1rem;
            font-size: 1.1rem;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 0.5rem 0;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feature-list li i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .order-container {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .parents-grid {
                grid-template-columns: 1fr;
            }
            
            .theme-preview {
                position: static;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="dashboard.php" class="logo">
            <i class="fas fa-heart"></i>
            WeddingInvite
        </a>
        <div class="user-menu">
            <span class="welcome">Halo, <?php echo htmlspecialchars($user_name); ?>!</span>
            <a href="../auth/logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <div class="container">
        <h1 style="color: var(--secondary); margin-bottom: 1rem;">Pesan Tema Undangan</h1>
        <p style="color: var(--gray); margin-bottom: 2rem;">Lengkapi data untuk memesan tema <strong><?php echo $selected_theme['name']; ?></strong></p>

        <div class="order-container">
            <!-- Preview Tema -->
            <div class="theme-preview">
                <div class="theme-image">
                    <img src="<?php echo $selected_theme['image']; ?>" alt="<?php echo $selected_theme['name']; ?>">
                </div>
                <div class="theme-info">
                    <h2><?php echo $selected_theme['name']; ?></h2>
                    <div class="theme-price">Rp <?php echo number_format($selected_theme['price'], 0, ',', '.'); ?></div>
                    <p class="theme-description">
                        Tema yang dipilih akan disesuaikan dengan data yang Anda isi. 
                        Pastikan semua data diisi dengan benar.
                    </p>
                    <div style="background: var(--light); padding: 1rem; border-radius: 8px;">
                        <h4 style="color: var(--secondary); margin-bottom: 0.5rem;">Fitur Tema:</h4>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Desain responsif</li>
                            <li><i class="fas fa-check"></i> Customizable warna</li>
                            <li><i class="fas fa-check"></i> RSVP digital</li>
                            <li><i class="fas fa-check"></i> Countdown timer</li>
                            <li><i class="fas fa-check"></i> Gallery foto</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Pemesanan -->
            <form method="POST" class="order-form">
                <h2 class="form-title">Data Pernikahan</h2>

                <!-- Data Mempelai -->
                <div class="form-section">
                    <h3><i class="fas fa-user-friends"></i> Data Mempelai</h3>
                    
                    <div class="form-group">
                        <label for="bridegroom_name">Nama Mempelai Pria <span class="required">*</span></label>
                        <input type="text" id="bridegroom_name" name="bridegroom_name" placeholder="Masukkan nama lengkap mempelai pria" required>
                    </div>

                    <div class="form-group">
                        <label for="bride_name">Nama Mempelai Wanita <span class="required">*</span></label>
                        <input type="text" id="bride_name" name="bride_name" placeholder="Masukkan nama lengkap mempelai wanita" required>
                    </div>
                </div>

                <!-- Data Orang Tua Mempelai Pria -->
                <div class="form-section">
                    <h3><i class="fas fa-male"></i> Orang Tua Mempelai Pria</h3>
                    
                    <div class="parents-grid">
                        <div class="form-group">
                            <label for="bridegroom_father">Nama Ayah <span class="required">*</span></label>
                            <input type="text" id="bridegroom_father" name="bridegroom_father" placeholder="Nama ayah mempelai pria" required>
                        </div>

                        <div class="form-group">
                            <label for="bridegroom_mother">Nama Ibu <span class="required">*</span></label>
                            <input type="text" id="bridegroom_mother" name="bridegroom_mother" placeholder="Nama ibu mempelai pria" required>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua Mempelai Wanita -->
                <div class="form-section">
                    <h3><i class="fas fa-female"></i> Orang Tua Mempelai Wanita</h3>
                    
                    <div class="parents-grid">
                        <div class="form-group">
                            <label for="bride_father">Nama Ayah <span class="required">*</span></label>
                            <input type="text" id="bride_father" name="bride_father" placeholder="Nama ayah mempelai wanita" required>
                        </div>

                        <div class="form-group">
                            <label for="bride_mother">Nama Ibu <span class="required">*</span></label>
                            <input type="text" id="bride_mother" name="bride_mother" placeholder="Nama ibu mempelai wanita" required>
                        </div>
                    </div>
                </div>

                <!-- Detail Acara -->
                <div class="form-section">
                    <h3><i class="fas fa-calendar-alt"></i> Detail Acara</h3>
                    
                    <div class="form-group">
                        <label for="wedding_date">Tanggal Pernikahan <span class="required">*</span></label>
                        <input type="date" id="wedding_date" name="wedding_date" required>
                    </div>

                    <div class="form-group">
                        <label for="wedding_time">Waktu Acara <span class="required">*</span></label>
                        <input type="time" id="wedding_time" name="wedding_time" required>
                    </div>

                    <div class="form-group">
                        <label for="wedding_venue">Lokasi Acara <span class="required">*</span></label>
                        <textarea id="wedding_venue" name="wedding_venue" placeholder="Masukkan alamat lengkap lokasi pernikahan" required></textarea>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="form-section">
                    <h3><i class="fas fa-sticky-note"></i> Informasi Tambahan</h3>
                    
                    <div class="form-group">
                        <label for="additional_notes">Catatan Tambahan</label>
                        <textarea id="additional_notes" name="additional_notes" placeholder="Masukkan catatan khusus, permintaan tambahan, atau informasi lainnya"></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="themes.php" class="btn btn-outline" style="flex: 1;">Kembali ke Tema</a>
                    <button type="submit" class="btn btn-primary" style="flex: 2;">
                        <i class="fas fa-credit-card"></i> Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('wedding_date').min = today;
            
            // Auto-focus on first input
            document.getElementById('bridegroom_name').focus();
            
            console.log('Theme ID: <?php echo $theme_id; ?>');
            console.log('Theme Name: <?php echo $selected_theme['name']; ?>');
        });
    </script>
</body>
</html>