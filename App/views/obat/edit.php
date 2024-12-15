<!-- File: app/views/obat/edit.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat - Apotek</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
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

        .content {
            margin-left: 260px;
            padding: 20px;
            margin-top: 20px;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            margin-bottom: 20px;
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
    <div class="content">
        <div class="form-container">
            <h2>Edit Obat</h2>
            <form method="POST" action="<?php echo BASE_URL; ?>/obat/edit/<?php echo $data['obat']->id_obat; ?>">
                <label for="nama_obat">Nama Obat:</label>
                <input type="text" name="nama_obat" value="<?php echo htmlspecialchars($data['obat']->nama_obat); ?>" required>

                <label for="id_jenis_obat">Jenis Obat:</label>
                <select name="id_jenis_obat" required>
                    <?php foreach ($data['jenis_obat'] as $jenis): ?>
                        <option value="<?php echo $jenis['id_jenis_obat']; ?>" <?php echo ($jenis['id_jenis_obat'] == $data['obat']->id_jenis_obat) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($jenis['jenis_obat']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="id_kategori">Kategori Obat:</label>
                <select name="id_kategori" required>
                    <?php foreach ($data['kategori_obat'] as $kategori): ?>
                        <option value="<?php echo $kategori['id_kategori']; ?>" <?php echo ($kategori['id_kategori'] == $data['obat']->id_kategori) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($kategori['kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="id_satuan">Satuan:</label>
                <select name="id_satuan" required>
                    <?php foreach ($data['satuan'] as $satuan): ?>
                        <option value="<?php echo $satuan['id_satuan']; ?>" <?php echo ($satuan['id_satuan'] == $data['obat']->id_satuan) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($satuan['satuan']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="tanggal_kedaluwarsa">Tanggal Kedaluwarsa:</label>
                <input type="date" name="tanggal_kedaluwarsa" value="<?php echo htmlspecialchars($data['obat']->tanggal_kedaluwarsa); ?>" required>

                <label for="stok">Stok:</label>
                <input type="number" name="stok" min="0" value="<?php echo htmlspecialchars($data['obat']->stok); ?>" required>

                <label for="stok_minimal">Stok Minimal:</label>
                <input type="number" name="stok_minimal" min="0" value="<?php echo htmlspecialchars($data['obat']->stok_minimal); ?>" required>

                <button type="submit"><i class="fas fa-save"></i> Update Obat</button>
            </form>
        </div>
    </div>
</body>
</html>
