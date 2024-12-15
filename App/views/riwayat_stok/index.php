<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pemeriksaan Stok - Apotek</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        table th {
            background-color: black;
            color: white;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        a.button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        a.button:hover {
            background-color: #2980b9;
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
    <center><h2>Manajemen Riwayat Stok</h2></center>
        <a href="<?php echo BASE_URL; ?>/riwayat_stok/create" class="button">Tambah Riwayat Baru</a>
        <table>
            <thead>
                <tr>
                    <th>ID Riwayat Pemeriksaan</th>
                    <th>Nama Obat</th>
                    <th>Tanggal</th>
                    <th>Jenis Transaksi</th>
                    <th>Jumlah</th>
                    <th>Stok Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['riwayat_stok'] as $riwayatstok): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($riwayatstok['id_riwayat']); ?></td>
                        <td><?php echo htmlspecialchars($riwayatstok['nama_obat']); ?></td>
                        <td><?php echo htmlspecialchars($riwayatstok['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($riwayatstok['jenis_transaksi']); ?></td>
                        <td><?php echo htmlspecialchars($riwayatstok['jumlah']); ?></td>
                        <td><?php echo htmlspecialchars($riwayatstok['stok_akhir']); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/riwayat_stok/edit/<?php echo $riwayatstok['id_riwayat']; ?>">Edit</a> |
                            <a href="<?php echo BASE_URL; ?>/riwayat_stok/delete/<?php echo $riwayatstok['id_riwayat']; ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus pemeriksaan ini?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if(empty($data['riwayat_stok'])): ?>
                    <tr>
                        <td colspan="7">Tidak ada data pemeriksaan stok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
