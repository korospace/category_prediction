<?= $this->extend('Layout/template') ?>

<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/labelisasi.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('assets/js/labelisasi.js'); ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>

    <!-- // Alert Info // -->
	<?= $this->include('Components/alertInfo'); ?>
    <!-- // Loading Spinner // -->
	<?= $this->include('Components/loadingSpinner'); ?>

    <div id="nullkategori">
        <div id="message">
            ....
        </div>
        <div id="btn_wraper">
            <button id="check">
                <span id="text">
                    check
                </span>
                <span id="loading" class="hide">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="18px" height="18px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" fill="none" stroke="#ffffff" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.5952380952380952s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                    </svg>
                </span>
            </button>
            <button id="run">
                run
            </button>
        </div>
    </div>

    <!-- // Table Entries // -->
    <div id="container_table">
        <div style="color: yellow;margin-bottom:10px;">
            total: <span id="total_row"></span>
        </div>
        <div id="table_wraper">
            <table>
                <thead>
                    <tr>
                        <th>entry id</th>
                        <th>kategori</th>
                        <th>data bersih</th>
                    </tr>
                </thead>
                <tbody id="body_skeleton">
                    <?php for ($i = 0;$i < 5;$i++) {?>
                    <tr>
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
    </div>

<?= $this->endSection(); ?>