-- Buat database
CREATE DATABASE wedding_invitation;
USE wedding_invitation;

-- Tabel untuk menyimpan data tamu yang mengisi RSVP
CREATE TABLE guests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    attendance ENUM('yes', 'no') NOT NULL,
    guests_count INT NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menyimpan informasi acara
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    address TEXT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin user
INSERT INTO users (email, password, name, role) VALUES 
('admin@weddinginvite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Tabel untuk menyimpan galeri foto
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert data acara
INSERT INTO events (name, description, event_date, location, address) VALUES
('Akad Nikah', 'Akad nikah resmi pasangan', '2024-06-15 08:00:00', 'Ballroom Utama, Hotel Majapahit', 'Jl. Sudirman No. 123, Jakarta Pusat'),
('Resepsi Pernikahan', 'Resepsi pernikahan dan jamuan makan', '2024-06-15 11:00:00', 'Grand Ballroom, Hotel Majapahit', 'Jl. Sudirman No. 123, Jakarta Pusat');

-- Insert data galeri
INSERT INTO gallery (image_url, caption) VALUES
('https://images.unsplash.com/photo-1511895426328-dc8714191300?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80', 'Foto Prewedding 1'),
('https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80', 'Foto Prewedding 2'),
('https://images.unsplash.com/photo-1520854221256-17451cc331bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80', 'Foto Prewedding 3'),
('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80', 'Foto Prewedding 4');