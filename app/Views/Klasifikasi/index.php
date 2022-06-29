<?= $this->extend('Layout/template') ?>

<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/klasifikasi.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('assets/js/klasifikasi.js'); ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>

    <!-- // Alert Info // -->
	<?= $this->include('Components/alertInfo'); ?>
    <!-- // Loading Spinner // -->
	<?= $this->include('Components/loadingSpinner'); ?>

    <h1 class="judul_table">
        Probabilitas Kategori
    </h1>
    <div id="table_prob_kat" class="table_wraper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Frekuensi Dokumen Pada Setiap Kategori</th>
                    <th>Jumlah Dokumen Yang Ada</th>
                    <th>Nilai Probabilitas</th>
                </tr>
            </thead>
            <tbody id="body_skeleton">
                <?php for ($i = 0;$i < 5;$i++) {?>
                <tr>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                </tr>
                <?php } ?>
            </tbody>
            <tbody id="body_main">
                
            </tbody>
        </table>
    </div>

    <h1 class="judul_table">
        Probabilitas Data
    </h1>
    <div id="table_prob_data" style="width:100%;overflow:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Kata</th>
                    <th>Jumlah Kata Per Kategori</th>
                    <th>Jumlah Data Per Kategori</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody id="body_skeleton">
                <?php for ($i = 0;$i < 5;$i++) {?>
                <tr>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                    <td class="skeleton"><span></span></td>
                </tr>
                <?php } ?>
            </tbody>
            <tbody id="body_main">
                
            </tbody>
        </table>
    </div>
<?= $this->endSection(); ?>