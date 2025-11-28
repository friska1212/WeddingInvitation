<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Undangan Pernikahan</title>
    <style>
        :root {
            --primary: #8B5FBF;
            --primary-light: #9D76C1;
            --secondary: #E9D7FD;
            --dark: #333;
            --light: #f8f9fa;
            --danger: #e74c3c;
            --success: #2ecc71;
            --warning: #f39c12;
            --gray: #6c757d;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: var(--dark);
        }
        
        .container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .logo h2 {
            font-size: 1.5rem;
        }
        
        .nav-links {
            list-style: none;
        }
        
        .nav-links li {
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .nav-links li:hover, .nav-links li.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid white;
        }
        
        .nav-links li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .nav-links li a i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .header h1 {
            color: var(--primary);
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Card Styles */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            text-align: center;
            border-left: 4px solid var(--primary);
        }
        
        .stat-card h3 {
            font-size: 2rem;
            color: var(--primary);
            margin: 10px 0;
        }
        
        .stat-card p {
            color: var(--gray);
        }
        
        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: var(--secondary);
            color: var(--primary);
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.completed {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .status.processing {
            background-color: #d4edda;
            color: #155724;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background-color: var(--warning);
            color: white;
        }
        
        .btn-delete {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-complete {
            background-color: var(--success);
            color: white;
        }
        
        .btn-add {
            background-color: var(--primary);
            color: white;
            padding: 10px 20px;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-add i {
            margin-right: 8px;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .close {
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(139, 95, 191, 0.2);
        }
        
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        .btn-cancel {
            background-color: var(--gray);
            color: white;
        }
        
        .btn-save {
            background-color: var(--primary);
            color: white;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 600;
            color: var(--gray);
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h2><i class="fas fa-heart"></i> WeddingAdmin</h2>
            </div>
            <ul class="nav-links">
                <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-shopping-cart"></i> Pemesanan</a></li>
                <li><a href="#"><i class="fas fa-history"></i> Riwayat</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Data Customer</a></li>
                <li><a href="#"><i class="fas fa-palette"></i> Tema</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Dashboard Admin</h1>
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=8B5FBF&color=fff" alt="Admin">
                    <span>Admin User</span>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="card stat-card">
                    <p>Total Pemesanan</p>
                    <h3>142</h3>
                    <p><i class="fas fa-arrow-up text-success"></i> 12% dari bulan lalu</p>
                </div>
                <div class="card stat-card">
                    <p>Pemesanan Baru</p>
                    <h3>24</h3>
                    <p>Menunggu konfirmasi</p>
                </div>
                <div class="card stat-card">
                    <p>Pemesanan Selesai</p>
                    <h3>98</h3>
                    <p>Bulan ini</p>
                </div>
                <div class="card stat-card">
                    <p>Pendapatan</p>
                    <h3>Rp 12.5 Jt</h3>
                    <p>Bulan ini</p>
                </div>
            </div>
            
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab active" data-tab="orders">Pemesanan Aktif</div>
                <div class="tab" data-tab="history">Riwayat Pemesanan</div>
            </div>
            
            <!-- Orders Tab -->
            <div class="tab-content active" id="orders">
                <button class="btn btn-add" id="addOrderBtn"><i class="fas fa-plus"></i> Tambah Pemesanan</button>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama Customer</th>
                                <th>Tema</th>
                                <th>Tanggal Pernikahan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#WD001</td>
                                <td>Andi & Sari</td>
                                <td>Elegant Purple</td>
                                <td>15 Des 2023</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-complete"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#WD002</td>
                                <td>Budi & Rina</td>
                                <td>Romantic Pink</td>
                                <td>22 Des 2023</td>
                                <td><span class="status processing">Diproses</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-complete"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#WD003</td>
                                <td>Citra & Dedi</td>
                                <td>Classic Gold</td>
                                <td>05 Jan 2024</td>
                                <td><span class="status pending">Pending</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-complete"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#WD004</td>
                                <td>Eko & Fitri</td>
                                <td>Minimalist White</td>
                                <td>12 Jan 2024</td>
                                <td><span class="status processing">Diproses</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-complete"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- History Tab -->
            <div class="tab-content" id="history">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama Customer</th>
                                <th>Tema</th>
                                <th>Tanggal Pernikahan</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#WD098</td>
                                <td>Rizky & Ani</td>
                                <td>Elegant Purple</td>
                                <td>10 Nov 2023</td>
                                <td>12 Nov 2023</td>
                                <td><span class="status completed">Selesai</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#WD097</td>
                                <td>Hendra & Maya</td>
                                <td>Romantic Pink</td>
                                <td>05 Nov 2023</td>
                                <td>07 Nov 2023</td>
                                <td><span class="status completed">Selesai</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>#WD096</td>
                                <td>Fajar & Lina</td>
                                <td>Classic Gold</td>
                                <td>28 Okt 2023</td>
                                <td>30 Okt 2023</td>
                                <td><span class="status completed">Selesai</span></td>
                                <td>
                                    <button class="btn btn-edit"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Order Modal -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Pemesanan Baru</h2>
                <span class="close">&times;</span>
            </div>
            <form id="orderForm">
                <div class="form-group">
                    <label for="customerName">Nama Customer</label>
                    <input type="text" id="customerName" class="form-control" placeholder="Masukkan nama customer">
                </div>
                <div class="form-group">
                    <label for="customerEmail">Email Customer</label>
                    <input type="email" id="customerEmail" class="form-control" placeholder="Masukkan email customer">
                </div>
                <div class="form-group">
                    <label for="weddingDate">Tanggal Pernikahan</label>
                    <input type="date" id="weddingDate" class="form-control">
                </div>
                <div class="form-group">
                    <label for="theme">Pilih Tema</label>
                    <select id="theme" class="form-control">
                        <option value="">Pilih tema</option>
                        <option value="Elegant Purple">Elegant Purple</option>
                        <option value="Romantic Pink">Romantic Pink</option>
                        <option value="Classic Gold">Classic Gold</option>
                        <option value="Minimalist White">Minimalist White</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="processing">Diproses</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel">Batal</button>
                    <button type="submit" class="btn btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                tab.classList.add('active');
                document.getElementById(tab.dataset.tab).classList.add('active');
            });
        });
        
        // Modal functionality
        const modal = document.getElementById('orderModal');
        const addOrderBtn = document.getElementById('addOrderBtn');
        const closeBtn = document.querySelector('.close');
        const cancelBtn = document.querySelector('.btn-cancel');
        
        addOrderBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });
        
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
        
        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
        
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
        
        // Form submission
        document.getElementById('orderForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Data pemesanan berhasil disimpan!');
            modal.style.display = 'none';
        });
        
        // Edit and delete buttons functionality
        document.querySelectorAll('.btn-edit, .btn-delete, .btn-complete').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.classList.contains('btn-edit')) {
                    document.getElementById('modalTitle').textContent = 'Edit Pemesanan';
                    modal.style.display = 'flex';
                } else if (this.classList.contains('btn-delete')) {
                    if (confirm('Apakah Anda yakin ingin menghapus pemesanan ini?')) {
                        alert('Pemesanan berhasil dihapus!');
                    }
                } else if (this.classList.contains('btn-complete')) {
                    if (confirm('Tandai pemesanan ini sebagai selesai?')) {
                        alert('Pemesanan telah ditandai sebagai selesai!');
                    }
                }
            });
        });
    </script>
</body>
</html>