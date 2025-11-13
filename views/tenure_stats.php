<?php 
/** 
 * FILE: views/tenure_stats.php 
 * FUNGSI: Menampilkan statistik masa kerja karyawan (Junior, Middle, Senior)
 */
include 'views/header.php'; 
?> 
 
<h2>Statistik Masa Kerja Karyawan</h2> 
 
<p style="margin-bottom: 2rem; color: #666;"> 
    Data berikut diambil dari VIEW <code>tenure_stats</code> di database PostgreSQL.
    Mengelompokkan karyawan berdasarkan lama masa kerja.
</p> 
 
<?php if ($stats->rowCount() > 0): ?> 
    <?php 
    $stats->execute(); 
    $all_stats = $stats->fetchAll(PDO::FETCH_ASSOC); 
    $total_karyawan = array_sum(array_column($all_stats, 'total_karyawan'));
    ?> 

    <!-- Cards Summary --> 
    <div class="dashboard-cards"> 
        <div class="card"> 
            <h3>Total Karyawan</h3> 
            <div class="number"><?php echo $total_karyawan; ?></div> 
        </div> 
        <div class="card"> 
            <h3>Jumlah Kategori</h3> 
            <div class="number"><?php echo count($all_stats); ?></div> 
        </div> 
    </div> 

    <!-- Tabel Statistik Detail --> 
    <table class="data-table"> 
        <thead> 
            <tr> 
                <th>Kategori Masa Kerja</th> 
                <th>Jumlah Karyawan</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php foreach ($all_stats as $row): ?> 
            <tr> 
                <td><strong><?php echo htmlspecialchars($row['level_kerja']); ?></strong></td> 
                <td style="text-align: center;"> 
                    <span style="padding: 0.25rem 0.75rem; background: #667eea; color: white; border-radius: 20px;"> 
                        <?php echo $row['total_karyawan']; ?> 
                    </span> 
                </td> 
            </tr> 
            <?php endforeach; ?> 
        </tbody> 
    </table> 

    <!-- Chart Visualisasi --> 
    <div style="margin-top: 3rem;"> 
        <h3>Visualisasi Data</h3> 
        <div style="background: white; padding: 1.5rem; border-radius: 8px; margin: 1rem 0; border-left: 4px solid #667eea;"> 
            <h4>Distribusi Karyawan Berdasarkan Masa Kerja</h4> 
            <?php foreach ($all_stats as $row): ?> 
            <div style="margin: 0.5rem 0;"> 
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;"> 
                    <span><?php echo htmlspecialchars($row['level_kerja']); ?></span> 
                    <span><?php echo $row['total_karyawan']; ?> orang</span> 
                </div> 
                <div style="background: #f0f0f0; border-radius: 4px; height: 20px;"> 
                    <div style="background: #667eea; height: 100%; border-radius: 4px; width: <?php echo ($row['total_karyawan'] / max(array_column($all_stats, 'total_karyawan')) * 100); ?>%;"></div> 
                </div> 
            </div> 
            <?php endforeach; ?> 
        </div> 
    </div> 
 
<?php else: ?> 
    <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 8px;"> 
        <p style="font-size: 1.2rem; color: #666;">Tidak ada data masa kerja.</p> 
        <p style="color: #999;">Pastikan tabel <code>employees</code> memiliki data dengan tanggal <code>hire_date</code> valid.</p> 
    </div> 
<?php endif; ?> 
 
<div style="margin-top: 2rem; padding: 1rem; background: #e7f3ff; border-radius: 5px;"> 
    <strong>Informasi:</strong>  
    Data ini diambil dari VIEW PostgreSQL yang menggunakan fungsi agregat  
    <code>COUNT()</code>, <code>CASE WHEN</code>, dan <code>GROUP BY</code>. 
</div> 
 
<?php include 'views/footer.php'; ?>
