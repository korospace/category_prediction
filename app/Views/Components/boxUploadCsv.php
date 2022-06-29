<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
    <style>
        #bg_box{
            display: none;
            position: fixed !important;
            z-index: 50;
            align-items: start !important;
            justify-content: center !important;
            padding-top: 40px;
            top:0 !important;
            left:0 !important;
            right:0 !important;
            bottom:0 !important;
            z-index:90 !important;
            background-color:rgba(0,0,0,0.9) !important;
        }
        #bg_box.show{
            display: flex !important;
        }
        #box{
            border-radius: 6px !important;
            background-color: yellow !important;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }
        #box #close{
            text-align: right;
            margin-bottom: 20px;
        }
        #box #close span{
            color: black;
            padding: 10px 0;
            font-weight: bolder;
            opacity: 0.9;
            cursor: pointer;
        }
        #box #close span:hover,#box #close span:active{
            opacity: 1;
        }
        #box button{
            background-color: black;
            color: yellow;
            padding: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.9;
            border: 0px;
            border-radius: 4px;
            margin-top: 10px;
            cursor: pointer;
        }
        #box button:hover,#box button:active{
            opacity: 1;
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
        const bgBox = document.querySelector("#bg_box");
        const box   = document.querySelector("#bg_box #box");

        function showPopUpCsv() {
            bgBox.classList.add("show");
            bgBox.classList.add("fade-in");
            box.classList.add("bounce-in");
        }

        function hidePopUpCsv() {
            bgBox.removeAttribute("class");
        }

        // close span
        document.querySelector("#close span").addEventListener("click",() => {
            hidePopUpCsv();
        })

        // upload csv
        document.querySelector("form#box").addEventListener("submit",(e) => {
            e.preventDefault();
            let form = new FormData(e.target);

            if (form.get("slangcsv").size == 0) {
                showAlert({
                    message:"file tidak boleh kosong",
                    type:"warning",
                    autohide:true
                });
                return 0;
            }

            showLoadingSpinner();
            doXhr(BASE_URL+"/slangWord/create","POST",form)
            .then((res) => {
                let message = "";
                let type    = "";
                
                if (res.code < 300) {
                    document.querySelector("form#box input").value = "";
                    let entries = res.data;
                    message = `<b>success!</b> ${res.message}`;
                    type    = "success";
                    getAllSlangWord();
                }
                else if (res.code == 400) {
                    message = `<b>gagal!</b> ${res.message.slangcsv}`;
                    type    = "danger";
                } 
                else {
                    message = `<b>gagal!</b> ${res.message}`;
                    type    = "danger";
                }

                hideLoadingSpinner();
                showAlert({
                    message:message,
                    type:type,
                    autohide:true
                });
            })
        })
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>
    <div
      id="bg_box">
        <form 
          id="box">
            <div id="close">
                <span>X</span>
            </div>
            <input type="file" name="slangcsv">
            <button>kirim</button>
        </form>
    </div>
<?= $this->endSection(); ?>