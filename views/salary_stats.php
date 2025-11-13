<?php 
/**
 * FILE: views/salary_stats.php
 * FUNGSI: Menampilkan statistik gaji per departemen dari VIEW salary_stats
 */
include 'views/header.php';
?>

<h2>Statistik Gaji per Departemen</h2>

<p style="margin-bottom: 2rem; color: #666;">
    Data statistik berikut diambil dari VIEW <code>salary_stats</code> di database PostgreSQL.
</p>

<?php if ($stats->rowCount() > 0): ?> 
    <?php 
    $all_stats = $stats->fetchAll(PDO::FETCH_ASSOC); 

    // Hitung rata-rata keseluruhan
    $avg_all = 0;
    if (count($all_stats) > 0) {
        $avg_all = array_sum(array_column($all_stats, 'avg_salary')) / count($all_stats);
    }
    ?>

    <!-- Cards Summary -->
    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Departemen</h3>
            <div class="number"><?php echo count($all_stats); ?></div>
        </div>
        <div class="card">
            <h3>Rata-rata Gaji Keseluruhan</h3>
            <div class="number">Rp <?php echo number_format($avg_all, 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Tertinggi (Seluruh Dept)</h3>
            <div class="number">Rp <?php echo number_format(max(array_column($all_stats, 'max_salary')), 0, ',', '.'); ?></div>
        </div>
        <div class="card">
            <h3>Gaji Terendah (Seluruh Dept)</h3>
            <div class="number">Rp <?php echo number_format(min(array_column($all_stats, 'min_salary')), 0, ',', '.'); ?></div>
        </div>
    </div>

    <!-- Tabel Statistik Detail -->
    <table class="data-table">
        <thead>
            <tr>
                <th>Departemen</th>
                <th>Gaji Rata-rata</th>
                <th>Gaji Tertinggi</th>
                <th>Gaji Terendah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_stats as $row): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['department']); ?></strong></td>
                <td><strong>Rp <?php echo number_format($row['avg_salary'], 0, ',', '.'); ?></strong></td>
                <td>Rp <?php echo number_format($row['max_salary'], 0, ',', '.'); ?></td>
                <td>Rp <?php echo number_format($row['min_salary'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Chart Visualisasi -->
    <div style="margin-top: 3rem;">
        <h3>Visualisasi Data</h3>

        <!-- Chart Gaji Rata-rata -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;">
            <h4>Gaji Rata-rata per Departemen</h4>
            <?php 
            $max_avg = max(array_column($all_stats, 'avg_salary'));
            foreach ($all_stats as $dept): 
            ?>
            <div style="margin: 0.5rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span><?php echo htmlspecialchars($dept['department']); ?></span>
                    <span>Rp <?php echo number_format($dept['avg_salary'], 0, ',', '.'); ?></span>
                </div>
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                    <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo ($dept['avg_salary'] / $max_avg * 100); ?>%;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Chart Perbandingan Gaji Maksimum -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #27ae60;">
            <h4>Gaji Maksimum per Departemen</h4>
            <?php 
            $max_salary = max(array_column($all_stats, 'max_salary'));
            foreach ($all_stats as $dept): 
            ?>
            <div style="margin: 0.5rem 0;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                    <span><?php echo htmlspecialchars($dept['department']); ?></span>
                    <span>Rp <?php echo number_format($dept['max_salary'], 0, ',', '.'); ?></span>
                </div>
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;">
                    <div style="background: #27ae60; height: 100%; border-radius: 4px; width: <?php echo ($dept['max_salary'] / $max_salary * 100); ?>%;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?> 
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;"> 
        <p style="font-size: 1.2rem; color: #666;">Tidak ada data statistik gaji.</p> 
        <p style="color: #999;">Pastikan VIEW <code>salary_stats</code> sudah dibuat dan data karyawan tersedia.</p> 
        <a href="index.php?action=create" class="btn btn-primary" style="margin-top: 1rem;">Tambah Data Karyawan</a> 
    </div> 
<?php endif; ?> 

<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;"> 
    <strong>Informasi:</strong>  
    Data ini diambil dari VIEW PostgreSQL yang menggunakan fungsi agregat  
    <code>AVG()</code>, <code>MIN()</code>, <code>MAX()</code>, dan <code>GROUP BY</code>. 
</div> 

<?php include 'views/footer.php'; ?>
