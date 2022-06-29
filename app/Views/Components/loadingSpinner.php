<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <style>
        #loading-spinner-wraper{
            display: none;
            position: fixed !important;
            align-items: center !important;
            justify-content: center !important;
            top:0 !important;
            left:0 !important;
            right:0 !important;
            bottom:0 !important;
            z-index:100 !important;
            background-color:rgba(0,0,0,0.9) !important;
        }
        #loading-spinner-wraper.show{
            display: flex !important;
        }
        .loading{
            width: 110px !important;
            height: 110px !important;
            border-radius: 6px !important;
            background-color: yellow !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .fade-in{
            animation: fade-in .4s !important;
        }
        
        .fade-out{
            animation: fade-out .2s !important;
        }
        
        .bounce-in {
            animation: bounce-in .5s !important;
        }

        /* Animasi */
        @keyframes fade-in {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes fade-out {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.7);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        const spinnerWraper = document.querySelector("#loading-spinner-wraper");
        const divLoading    = document.querySelector("#loading-spinner-wraper div.loading");

        // show spinner
        function showLoadingSpinner() {
            spinnerWraper.classList.add("show");
            spinnerWraper.classList.add("fade-in");
            divLoading.classList.add("bounce-in");
        }

        // hide spinner
        function hideLoadingSpinner() {
            spinnerWraper.classList.add("fade-out");
            setTimeout(() => {
                spinnerWraper.classList.remove("show");
                spinnerWraper.classList.remove("fade-in");
                spinnerWraper.classList.remove("fade-out");
                divLoading.classList.remove("bounce-in");
            }, 50);
        }
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>
    <div
      id="loading-spinner-wraper">
        <div 
          class="loading">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; display: block; shape-rendering: auto;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#000000" stroke-width="10" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.5952380952380952s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                </circle>
            </svg>
        </div>
    </div>
<?= $this->endSection(); ?>