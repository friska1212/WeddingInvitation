<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Kosong jika tidak ada password
define('DB_NAME', 'wedding_invitation');

// Koneksi ke Database
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Koneksi database gagal: " . $e->getMessage());
    }
}

// Fungsi untuk mendapatkan data theme dari database
function getThemeById($id) {
    $pdo = getDBConnection();
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM themes WHERE id = ?");
        $stmt->execute([$id]);
        $theme = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($theme) {
            // Convert features string to array
            $theme['features'] = explode(',', $theme['features']);
            return $theme;
        }
    } catch (PDOException $e) {
        // Jika ada error, gunakan data simulasi
        return getSimulatedTheme($id);
    }
    
    return getSimulatedTheme($id);
}

// Data simulasi backup
function getSimulatedTheme($id) {
    $themes = [
        1 => [
            'id' => 1,
            'name' => 'Klasik Elegan',
            'category' => 'classic',
            'description' => 'Tema pernikahan klasik dengan sentuhan elegan dan mewah yang cocok untuk acara formal.',
            'detailed_description' => 'Tema Klasik Elegan menawarkan kemewahan dan keanggunan tradisional dengan sentuhan modern.',
            'price' => 5000000,
            'image' => 'https://i.pinimg.com/736x/5m/0H/ny/5m0Hny6gq.jpg',
            'features' => ['Gold Foil Printing', 'Customizable Colors', 'RSVP System'],
            'is_popular' => true
        ]
    ];
    
    return isset($themes[$id]) ? $themes[$id] : null;
}
?>