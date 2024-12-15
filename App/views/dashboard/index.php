<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Apotek</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Global Style */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        /* Header Style */
        .header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .header .logout {
            margin-left: auto;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header a {
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
        }

        /* Sidebar Style */
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            margin-top: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
            margin-bottom: 10px;
            cursor: pointer;
            border-bottom: 1px solid #495057;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li:hover,
        .sidebar ul li.active {
            background-color: #495057;
        }

        .sidebar .dropdown {
            display: none;
            background-color: #495057;
            margin-top: -8px;
        }

        .sidebar .dropdown li {
            padding: 10px 20px;
            margin-bottom: 8px;
            border-bottom: 1px solid #6c757d;
        }

        .sidebar .dropdown li a {
            color: white;
        }

        /* Main Content Style */
        .content {
            margin-left: 260px;
            padding: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .stat-card h3 {
            margin: 10px 0;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: bold;
            color: #17a2b8;
        }

        .notification {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .notification h4 {
            margin-bottom: 15px;
        }

        .notification ul {
            padding: 0;
            list-style: none;
        }

        .notification ul li {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .toggle-dropdown {
            cursor: pointer;
        }

        /* Notification Styles */
        .notification {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .low-stock {
            background-color: #fff4e5;
            border-left: 5px solid #f5a623;
        }

        .expired {
            background-color: #ffe5e5;
            border-left: 5px solid #d0021b;
        }

        .near-expired {
            background-color: #fff7e5;
            border-left: 5px solid #f8e71c;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a class="logout" href="<?php echo BASE_URL; ?>/auth/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" style="margin-top: 20px;">
        <ul>
            <center><h2>APOTEK SINJAI</h2></center>
            <li><a href="<?php echo BASE_URL; ?>/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="toggle-dropdown" onclick="toggleDropdown()"> 
                <i class="fas fa-database"></i> Master Data 
                <i class="fas fa-chevron-down" style="margin-left:auto;"></i>
            </li>
            <ul class="dropdown" id="masterDataDropdown">
                <li><a href="<?php echo BASE_URL; ?>/kategori_obat"><i class="fas fa-list-alt"></i> Kategori Obat</a></li>
                <li><a href="<?php echo BASE_URL; ?>/jenis_obat"><i class="fas fa-capsules"></i> Jenis Obat</a></li>
                <li><a href="<?php echo BASE_URL; ?>/satuan"><i class="fas fa-ruler"></i> Satuan</a></li>
                <?php if ($_SESSION['jabatan'] === 'admin'): ?>
                <li><a href="<?php echo BASE_URL; ?>/users"><i class="fas fa-users"></i> Manajemen Pengguna</a></li>
                <li><a href="<?php echo BASE_URL; ?>/supplier"><i class="fas fa-truck"></i> Manajemen Supplier</a></li>
                <?php endif; ?>
            </ul>
            <li><a href="<?php echo BASE_URL; ?>/obat"><i class="fas fa-pills"></i> Manajemen Obat</a></li>
            <?php if (in_array($_SESSION['jabatan'], ['admin', 'apoteker'])): ?>
                <li><a href="<?php echo BASE_URL; ?>/pemeriksaan_stok"><i class="fas fa-check-circle"></i> Pemeriksaan Stok</a></li>
                <li><a href="<?php echo BASE_URL; ?>/riwayat_stok"><i class="fas fa-history"></i> Riwayat Stok</a></li>
                <li><a href="<?php echo BASE_URL; ?>/detail_pemeriksaan_stok"><i class="fas fa-info-circle"></i> Detail Pemeriksaan Stok</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Content -->
    <div class="content" style="margin-top: 20px;">
        <h2>
            Selamat datang, <strong><?php echo htmlspecialchars(strtoupper($data['nama_user'])); ?></strong>!
        </h2>
        <h3>Anda Login sebagai <?php echo htmlspecialchars(strtoupper($_SESSION['jabatan'])); ?></h3>
        <div class="stat-card">
            <h3>Total Obat</h3>
            <p><?php echo htmlspecialchars($data['total_obat']); ?></p>
        </div>

        <h2>Notifikasi</h2>

        <!-- Notifications -->
        <?php if (!empty($data['obat_stok_rendah'])): ?>
            <div class="notification low-stock">
                <h2>⚠️ Obat dengan Stok Rendah</h2>
                <ul>
                    <?php foreach ($data['obat_stok_rendah'] as $obat): ?>
                        <li><strong><?php echo htmlspecialchars($obat['nama_obat']); ?></strong> - Stok saat ini: <?php echo htmlspecialchars($obat['stok']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['obat_mendekati_kedaluwarsa'])): ?>
            <div class="notification near-expired">
                <h2>⏳ Obat Mendekati Kedaluwarsa</h2>
                <ul>
                    <?php foreach ($data['obat_mendekati_kedaluwarsa'] as $obat): ?>
                        <li><strong><?php echo htmlspecialchars($obat['nama_obat']); ?></strong> - Kedaluwarsa: <?php echo htmlspecialchars($obat['tanggal_kedaluwarsa']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['obat_sudah_kedaluwarsa'])): ?>
            <div class="notification expired">
                <h2>❌ Obat Sudah Kedaluwarsa</h2>
                <ul>
                    <?php foreach ($data['obat_sudah_kedaluwarsa'] as $obat): ?>
                        <li><strong><?php echo htmlspecialchars($obat['nama_obat']); ?></strong> - Kedaluwarsa: <?php echo htmlspecialchars($obat['tanggal_kedaluwarsa']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('masterDataDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>
</html>