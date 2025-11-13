<?php 
/**
 * FILE: views/employee_overview.php
 * FUNGSI: Menampilkan ringkasan total karyawan, total gaji, dan rata-rata masa kerja
 */
include 'views/header.php';
?>

<h2>Ringkasan Karyawan</h2>

<p style="margin-bottom: 2rem; color: #666;">
    Data berikut diambil dari VIEW <code>employee_overview</code> di database PostgreSQL.
    Menampilkan total karyawan, total gaji per bulan, dan rata-rata masa kerja.
</p>

<?php if ($stats->rowCount() > 0): ?>
    <?php 
    $data = $stats->fetch(PDO::FETCH_ASSOC);
    ?>

    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Karyawan</h3>
            <div class="number"><?php echo $data['total_karyawan']; ?></div>
        </div>

        <div class="card">
            <h3>Total Gaji Per Bulan</h3>
            <div class="number">Rp <?php echo number_format($data['total_gaji_per_bulan'], 0, ',', '.'); ?></div>
        </div>

        <div class="card">
            <h3>Rata-rata Masa Kerja</h3>
            <div class="number"><?php echo $data['rata_rata_masa_kerja']; ?> tahun</div>
        </div>
    </div>

    <!-- Visualisasi Data -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Ringkasan</h3>

        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;">
            <h4>Distribusi Statistik</h4>
            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span>Total Karyawan</span>
                    <span><?php echo $data['total_karyawan']; ?> orang</span>
                </div>
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                    <div style="background: #667eea; height: 100%; border-radius: 4px; width: 100%;"></div>
                </div>
            </div>

            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span>Total Gaji</span>
                    <span>Rp <?php echo number_format($data['total_gaji_per_bulan'], 0, ',', '.'); ?></span>
                </div>
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                    <div style="background: #27ae60; height: 100%; border-radius: 4px; width: 100%;"></div>
                </div>
            </div>

            <div style="margin: 1rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span>Rata-rata Masa Kerja</span>
                    <span><?php echo $data['rata_rata_masa_kerja']; ?> tahun</span>
                </div>
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                    <div style="background: #f39c12; height: 100%; border-radius: 4px; width: <?php echo min(($data['rata_rata_masa_kerja'] / 10) * 100, 100); ?>%;"></div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 1.2rem; color: #666;">Tidak ada data ringkasan karyawan.</p>
        <p style="color: #999;">Pastikan tabel <code>employees</code> sudah berisi data dengan <code>salary</code> dan <code>hire_date</code> yang valid.</p>
    </div>
<?php endif; ?>

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;">
    <strong>Informasi:</strong>
    Data ini diambil dari VIEW PostgreSQL yang menggunakan fungsi agregat
    <code>COUNT()</code>, <code>SUM()</code>, dan <code>AVG()</code>.
</div>

<?php include 'views/footer.php'; ?>
