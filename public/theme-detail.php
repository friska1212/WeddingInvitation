<?php
$page_title = "Pilih Tema Undangan - WeddingInvite";

// Simulasi data themes
$themes = [
    [
        'id' => 1,
        'name' => 'Klasik Elegan',
        'category' => 'classic',
        'description' => 'Tema pernikahan klasik dengan sentuhan elegan dan mewah yang cocok untuk acara formal.',
        'price' => 5000000,
        'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        'is_popular' => true
    ],
    [
        'id' => 2,
        'name' => 'Modern Minimalis',
        'category' => 'modern',
        'description' => 'Desain bersih dan kontemporer dengan fokus pada garis sederhana dan elemen modern.',
        'price' => 4500000,
        'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        'is_popular' => true
    ],
    [
        'id' => 3,
        'name' => 'Rustic Alam',
        'category' => 'rustic',
        'description' => 'Inspirasi alam dengan elemen kayu, tanaman, dan nuansa hangat yang menenangkan.',
        'price' => 6000000,
        'image' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        'is_popular' => false
    ],
    [
        'id' => 4,
        'name' => 'Bohemian Dream',
        'category' => 'bohemian',
        'description' => 'Nuansa bebas dan artistik dengan warna-warna earth tone dan pattern ethnic.',
        'price' => 5500000,
        'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        'is_popular' => false
    ],
    [
        'id' => 5,
        'name' => 'Simple & Clean',
        'category' => 'minimalist',
        'description' => 'Pendekatan minimalis dengan fokus pada esensi, tanpa dekorasi berlebihan.',
        'price' => 3500000,
        'image' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        'is_popular' => false
    ],
    [
        'id' => 6,
        'name' => 'Royal Luxury',
        'category' => 'classic',
        'description' => 'Kemewahan tingkat tinggi dengan dekorasi mewah dan perhatian pada detail.',
        'price' => 8000000,
        'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?ixlib=rb-4.0.3&auto=format&fit=crop&w=1171&q=80',
        'is_popular' => true
    ]
];

$categories = ['all', 'classic', 'modern', 'rustic', 'bohemian', 'minimalist'];
$category_filter = $_GET['category'] ?? 'all';
$search_query = $_GET['search'] ?? '';

// Filter themes
$filtered_themes = array_filter($themes, function($theme) use ($category_filter, $search_query) {
    $category_match = $category_filter === 'all' || $theme['category'] === $category_filter;
    $search_match = empty($search_query) || 
                   stripos($theme['name'], $search_query) !== false || 
                   stripos($theme['description'], $search_query) !== false;
    
    return $category_match && $search_match;
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #e8b4b8;
            --secondary: #a26769;
            --light: #f9f5f0;
            --dark: #5d4e46;
            --white: #ffffff;
            --gray: #6c757d;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: var(--light);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary);
        }

        .nav-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
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

        /* Themes Section */
        .themes-section {
            padding: 120px 0 80px;
        }

        .themes-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .themes-header h1 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .themes-header p {
            font-size: 1.2rem;
            color: var(--gray);
        }

        .filter-section {
            margin-bottom: 3rem;
        }

        .search-box {
            position: relative;
            max-width: 400px;
            margin: 0 auto 2rem;
        }

        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .category-filters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .category-filter {
            padding: 10px 25px;
            border: 2px solid var(--primary);
            background: transparent;
            color: var(--primary);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .category-filter:hover,
        .category-filter.active {
            background: var(--primary);
            color: white;
        }

        /* Themes Grid */
        .themes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .theme-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .theme-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .theme-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .theme-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .theme-card:hover .theme-image img {
            transform: scale(1.1);
        }

        .theme-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .popular-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #27ae60;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .theme-info {
            padding: 1.5rem;
        }

        .theme-info h3 {
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .theme-info p {
            color: var(--gray);
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .theme-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .theme-actions {
            display: flex;
            gap: 0.5rem;
        }

        .theme-actions .btn {
            flex: 1;
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .login-prompt {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
            color: #856404;
        }

        .login-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .login-prompt a:hover {
            text-decoration: underline;
        }

        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray);
            grid-column: 1 / -1;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #bdc3c7;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-top: 4rem;
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            
            .themes-section {
                padding: 100px 0 60px;
            }
            
            .themes-header h1 {
                font-size: 2rem;
            }
            
            .themes-grid {
                grid-template-columns: 1fr;
            }
            
            .theme-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="index.html" class="logo">
                    <i class="fas fa-heart"></i>
                    WeddingInvite
                </a>
                
                <div class="nav-menu">
                    <a href="index.html" class="nav-link">Beranda</a>
                    <a href="themes.php" class="nav-link active">Tema</a>
                    <a href="#features" class="nav-link">Fitur</a>
                    <a href="#testimonials" class="nav-link">Testimoni</a>
                </div>
                
                <div class="nav-actions">
                    <a href="../auth/login.php" class="btn btn-outline">Login</a>
                    <a href="../auth/register.php" class="btn btn-primary">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="themes-section">
        <div class="container">
            <div class="themes-header">
                <h1>Pilih Tema Undangan</h1>
                <p>Temukan tema yang sesuai dengan kepribadian dan gaya pernikahan Anda</p>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="search-box">
                    <input type="text" id="searchThemes" placeholder="Cari tema..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <i class="fas fa-search"></i>
                </div>
                
                <div class="category-filters">
                    <button class="category-filter <?php echo $category_filter === 'all' ? 'active' : ''; ?>" data-category="all">
                        Semua Tema
                    </button>
                    <?php foreach(array_slice($categories, 1) as $category): ?>
                        <button class="category-filter <?php echo $category_filter === $category ? 'active' : ''; ?>" data-category="<?php echo $category; ?>">
                            <?php echo ucfirst($category); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Themes Grid -->
            <div class="themes-grid">
                <?php if(count($filtered_themes) > 0): ?>
                    <?php foreach($filtered_themes as $theme): ?>
                        <div class="theme-card">
                            <div class="theme-image">
                                <img src="<?php echo $theme['image']; ?>" alt="<?php echo $theme['name']; ?>">
                                <div class="theme-category"><?php echo $theme['category']; ?></div>
                                <?php if($theme['is_popular']): ?>
                                    <div class="popular-badge">Populer</div>
                                <?php endif; ?>
                            </div>
                            <div class="theme-info">
                                <h3><?php echo $theme['name']; ?></h3>
                                <p><?php echo $theme['description']; ?></p>
                                <div class="theme-price">Rp <?php echo number_format($theme['price'], 0, ',', '.'); ?></div>
                                <div class="theme-actions">
                                    <a href="theme-detail.php?id=<?php echo $theme['id']; ?>" class="btn btn-outline">
                                        Lihat Detail
                                    </a>
                                    <button class="btn btn-primary" onclick="selectTheme(<?php echo $theme['id']; ?>)">
                                        Pilih Tema
                                    </button>
                                </div>
                                <div class="login-prompt">
                                    <small>Login diperlukan untuk memilih tema ini</small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h3>Tema tidak ditemukan</h3>
                        <p>Coba gunakan kata kunci lain atau filter yang berbeda</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <i class="fas fa-heart"></i>
                </div>
                <p class="footer-text">
                    WeddingInvite - Platform undangan pernikahan digital terpercaya. 
                </p>
                <p style="margin-top: 2rem; opacity: 0.7; font-size: 0.9rem;">
                    &copy; 2024 WeddingInvite. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchThemes');
            const categoryFilters = document.querySelectorAll('.category-filter');
            
            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const themeCards = document.querySelectorAll('.theme-card');
                
                themeCards.forEach(card => {
                    const themeName = card.querySelector('h3').textContent.toLowerCase();
                    const themeDesc = card.querySelector('p').textContent.toLowerCase();
                    
                    if (themeName.includes(searchValue) || themeDesc.includes(searchValue)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
            
            // Category filter functionality
            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    const searchParams = new URLSearchParams(window.location.search);
                    searchParams.set('category', category);
                    window.location.href = `themes.php?${searchParams.toString()}`;
                });
            });
        });

        function selectTheme(themeId) {
            // Redirect ke login dengan parameter redirect
            window.location.href = '../auth/login.php?redirect=order&theme_id=' + themeId;
        }
    </script>
</body>
</html>