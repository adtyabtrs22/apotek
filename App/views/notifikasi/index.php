<!-- File: app/views/notifikasi/index.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi - Apotek</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <style>
        .warning { color: red; }
        .expired { color: darkred; }
        .near-expired { color: orange; }
        .low-stock { color: brown; }
    </style>
</head>
<body>
    <h1>Notifikasi Apotek</h1>
    <nav>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>/dashboard">Dashboard</a></li>
            <?php if($_SESSION['jabatan'] === 'admin'): ?>
                <li><a href="<?php echo BASE_URL; ?>/users">Manajemen Pengguna</a></li>
                <li><a href="<?php echo BASE_URL; ?>/supplier">Manajemen Supplier</a></li>
            <?php endif; ?>
            <?php if(in_array($_SESSION['jabatan'], ['admin', 'apoteker'])): ?>
                <li><a href="<?php echo BASE_URL; ?>/obat">Manajemen Obat</a></li>
                <li><a href="<?php echo BASE_URL; ?>/notifikasi">Notifikasi</a></li>
                <li><a href="<?php echo BASE_URL; ?>/riwayat_stok">Riwayat Stok</a></li>
                <li><a href="<?php echo BASE_URL; ?>/detail_pemeriksaan_stok">Detail Pemeriksaan Stok</a></li>
                <li><a href="<?php echo BASE_URL; ?>/pemeriksaan_stok">Pemeriksaan Stok</a></li>
            <?php endif; ?>
            <li><a href="<?php echo BASE_URL; ?>/auth/logout">Logout</a></li>
        </ul>
    </nav>
    <br>

    <!-- Notifikasi Obat Stok Rendah -->
    <?php if(!empty($data['obat_stok_rendah'])): ?>
        <div class="warning low-stock">
            <h2>Obat dengan Stok Rendah</h2>
            <ul>
                <?php foreach($data['obat_stok_rendah'] as $obat): ?>
                    <li><?php echo htmlspecialchars($obat['nama_obat']); ?> - Stok saat ini: <?php echo htmlspecialchars($obat['stok']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p>Tidak ada obat dengan stok rendah.</p>
    <?php endif; ?>

    <!-- Notifikasi Obat Mendekati Kedaluwarsa -->
    <?php if(!empty($data['obat_mendekati_kedaluwarsa'])): ?>
        <div class="warning near-expired">
            <h2>Obat Mendekati Kedaluwarsa</h2>
            <ul>
                <?php foreach($data['obat_mendekati_kedaluwarsa'] as $obat): ?>
                    <li><?php echo htmlspecialchars($obat['nama_obat']); ?> - Kedaluwarsa pada: <?php echo htmlspecialchars($obat['tanggal_kedaluwarsa']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p>Tidak ada obat yang mendekati kedaluwarsa.</p>
    <?php endif; ?>

    <!-- Notifikasi Obat Sudah Kedaluwarsa -->
    <?php if(!empty($data['obat_sudah_kedaluwarsa'])): ?>
        <div class="warning expired">
            <h2>Obat Sudah Kedaluwarsa</h2>
            <ul>
                <?php foreach($data['obat_sudah_kedaluwarsa'] as $obat): ?>
                    <li><?php echo htmlspecialchars($obat['nama_obat']); ?> - Kedaluwarsa pada: <?php echo htmlspecialchars($obat['tanggal_kedaluwarsa']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p>Tidak ada obat yang sudah kedaluwarsa.</p>
    <?php endif; ?>
</body>
</html>
