<?= $this->extend('Layout/template') ?>

<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/classify.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('assets/js/classify.js'); ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>
    <!-- // Loading Spinner // -->
	<?= $this->include('Components/loadingSpinner'); ?>
    <!-- // Alert Info // -->
	<?= $this->include('Components/alertInfo'); ?>
    
        <div style="display: flex;justify-content:center;">
            <div id="akurasi">
                ....
            </div>
        </div>

        <div style="display: flex;justify-content:center;">
            <div id="container_master">
                <!-- // Input Link // -->
                <form id="form_input_tes">
                    <select id="id_actual" class="inputs" name="id_actual">
                        <option value="">-- pilih kategori --</option>
                    </select>
                    <textarea id="text" class="inputs" name="text" placeholder="masukan text" cols="30" rows="10"></textarea>
                    <button>
                        <div>
                            simpan
                        </div>
                    </button>
                </form>
            
                <!-- // Link Option // -->
                <div id="container_result">
                    <div class="separator">
                        <h1>hasil</h1>
                        <div class="line"></div>
                    </div>
                    <div id="result"></div>
                </div>
            </div>
        </div>

<?= $this->endSection(); ?>