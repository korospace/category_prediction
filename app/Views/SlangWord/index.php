<?= $this->extend('Layout/template') ?>

<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/slangword.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('assets/js/slangword.js'); ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>

    <!-- // Alert Info // -->
	<?= $this->include('Components/alertInfo'); ?>
    <!-- // Loading Spinner // -->
	<?= $this->include('Components/loadingSpinner'); ?>
    <!-- // PoppUp CSV // -->
    <?= $this->include('Components/boxUploadCsv'); ?>

    <!-- // Table Entries // -->
    <div id="container_table">
        <div style="display: flex;justify-content:space-between;align-items:flex-end">
            <div style="margin-bottom: 10px;color:yellow;">total:<span id="total_row"></span></div>
            <div id="add_word">
                <button>tambah</button>
            </div>
        </div>
        <div id="table_wraper">
            <table>
                <thead>
                    <tr>
                        <th>no</th>
                        <th>kata non-baku</th>
                        <th>kata baku</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0;$i < 0;$i++) {?>
                    <tr>
                        <td class="skeleton"><span></span></td>
                        <td class="skeleton"><span></span></td>
                        <td class="skeleton"><span></span></td>
                        <td class="skeleton"><span></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<?= $this->endSection(); ?>