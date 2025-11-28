<nav class="navbar">
    <div class="container">
        <div class="nav-content">
            <a href="index.php" class="logo">
                <i class="fas fa-heart"></i>
                WeddingInvite
            </a>
            
            <div class="nav-menu">
                <a href="index.php" class="nav-link">Beranda</a>
                <a href="dashboard.php" class="nav-link">Tema</a>
                <a href="#features" class="nav-link">Fitur</a>
                <a href="#testimonials" class="nav-link">Testimoni</a>
            </div>
            
            <div class="nav-actions">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="dashboard.php" class="btn btn-outline">Dashboard</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="dashboard.php" class="btn btn-primary">Buat Undangan</a>
                <?php endif; ?>
            </div>
            
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu">
    <div class="mobile-menu-content">
        <a href="index.php" class="mobile-nav-link">Beranda</a>
        <a href="dashboard.php" class="mobile-nav-link">Tema</a>
        <a href="#features" class="mobile-nav-link">Fitur</a>
        <a href="#testimonials" class="mobile-nav-link">Testimoni</a>
        <div class="mobile-nav-actions">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="btn btn-outline">Dashboard</a>
                <a href="logout.php" class="btn btn-primary">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline">Login</a>
                <a href="dashboard.php" class="btn btn-primary">Buat Undangan</a>
            <?php endif; ?>
        </div>
    </div>
</div>