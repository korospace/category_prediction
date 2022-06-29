<?= $this->extend('Layout/template') ?>

<?= $this->section('contentCss'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/galertentry.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('contentJs'); ?>
    <script src="<?= base_url('assets/js/galertentry.js'); ?>"></script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>
    <!-- // Loading Spinner // -->
	<?= $this->include('Components/loadingSpinner'); ?>
    <!-- // Alert Info // -->
	<?= $this->include('Components/alertInfo'); ?>

    <div style="display: flex;justify-content:center;margin-top: 40px;">
        <div style="max-width: 500px;">
            <!-- // Input Link // -->
            <form id="form_input_link">
                <input type="text" name="link" placeholder="masukan link" autocomplete="off">
                <button>scrap</button>
            </form>
        
            <!-- // Link Option // -->
            <div id="container_link_options">
                <table>
                    <tr>
                        <td>
                            <input
                              type="radio" id="kuliner" name="link_options" 
                              value="https://www.google.com/alerts/feeds/00935439505349949810/1059760259113753686">
                        </td>
                        <td>
                            <label for="kuliner"><b>Kuliner</b> <br> https://www.google.com/alerts/feeds/00935439505349949810/1059760259113753686</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input
                              type="radio" id="militer" name="link_options" 
                              value="https://www.google.com/alerts/feeds/00935439505349949810/13394363770201522996">
                        </td>
                        <td>
                            <label for="militer"><b>Militer</b> <br> https://www.google.com/alerts/feeds/00935439505349949810/13394363770201522996</label>
                        </td>
                    </tr><tr>
                        <td>
                            <input
                              type="radio" id="teknologi" name="link_options" 
                              value="https://www.google.com/alerts/feeds/00935439505349949810/13394363770201524166">
                        </td>
                        <td>
                            <label for="teknologi"><b>Teknologi</b> <br> https://www.google.com/alerts/feeds/00935439505349949810/13394363770201524166</label>
                        </td>
                    </tr>
                </table>
            </div>
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
                        <th>id</th>
                        <th>link</th>
                        <th>author</th>
                        <th>title</th>
                        <th>content</th>
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
    </div>

<?= $this->endSection(); ?>