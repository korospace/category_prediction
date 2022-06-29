<?= $this->extend('Layout/template') ?>

<!-- Css -->
<?= $this->section('contentCss'); ?>
	<style>
        #alert{
            display: none;
            opacity: 0;
            position: fixed;
            z-index: 100;
            left: 40px;
            right: 40px;
            bottom: 0px;
            padding: .75rem 1.25rem;
            border-radius: .25rem;
            transition: all 0.5s;
        }
        #alert.block{
            display: block;
        }
        #alert.show{
            opacity: 1;
            bottom: 40px;
        }
        #alert.success{
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        #alert.warning{
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
        #alert.danger{
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
<?= $this->endSection(); ?>

<!-- JS -->
<?= $this->section('jsComponent'); ?>
    <script>
        const myAlert = document.querySelector("#alert");
        const myAlertMsg = document.querySelector("#alert #message");

        function showAlert(data) {
            myAlertMsg.innerHTML = data.message;
            myAlert.classList.add(`${data.type}`);
            myAlert.classList.add("block")

            setTimeout(() => {
                myAlert.classList.add("show")
                if (data.autohide) {
                    setTimeout(() => {
                        myAlert.classList.remove("show");
                        setTimeout(() => {
                            myAlert.removeAttribute("class");
                        }, 500);
                    }, 3000);    
                }   
            }, 50);  
        }
        
        if(!navigator.onLine){
            showAlert({
                message: `<strong>Ups . . .</strong> koneksi anda terputus!`,
                autohide: true,
                type:'danger'
            })
        }
        window.onoffline = () => {
            showAlert({
                message: `<strong>Ups . . .</strong> koneksi anda terputus!`,
                autohide: true,
                type:'danger'
            })
        };
        window.ononline = () => {
        };
    </script>
<?= $this->endSection(); ?>

<?= $this->section('contentHtml'); ?>
  <div id="alert" class="success">
      <span id="message">custom text</span>
  </div>
<?= $this->endSection(); ?>