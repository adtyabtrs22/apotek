<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Apotek</title>
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
            justify-content: flex-end;
            align-items: center;
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

        /* Main Content Style */
        .content {
            margin-left: 260px;
            padding: 20px;
            margin-top: 20px;
        }

        .form-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-container h2 {
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="<?php echo BASE_URL; ?>/auth/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
        <div class="form-container">
            <h2>Tambah Pengguna Baru</h2>
            <form method="POST" action="<?php echo BASE_URL; ?>/users/create">
                <label for="nama_user">Nama:</label>
                <input type="text" name="nama_user" required>

                <label for="jabatan">Jabatan:</label>
                <select name="jabatan" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="admin">Admin</option>
                    <option value="apoteker">Apoteker</option>
                </select>

                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <button type="submit"><i class="fas fa-save"></i> Tambah Pengguna</button>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('masterDataDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('masterDataDropdown');
            dropdown.style.display = 'none';
        });
    </script>
</body>
</html>
