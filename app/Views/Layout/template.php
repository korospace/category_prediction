<!DOCTYPE html>
<html lang="en">
<head>
  <title>pemketir | <?= $title ?></title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- Render Css -->
  <?= $this->renderSection('contentCss'); ?>

  <style>
    *{
      padding: 0;
      margin: 0;
    }
    body{
      font-family: 'sans';
      background-color: black;
      height: 100vh;
    }
    #body_container{
      display: flex;
      flex-direction: column;
      max-width: 1200px;
      height: 100%;
      margin: auto;
      padding: 0 30px;
    }
    #navbar #href_wraper{
        display: block;
        margin: auto;
        padding: 20px 0;
    }
    #navbar #href_wraper a{
        display: inline-block;
        color: yellow;
        text-decoration: none;
        width: max-content;
        margin: 0 8px 15px 0;
        padding: 6px 16px;
        border: 1px solid yellow;
        border-radius: 16px;
    }
    .active{
      background-color: yellow;
      color: black !important;
    }
  </style>

</head>

<body>
  
  <div id="body_container">
    <!-- // Navbar // -->
    <?= $this->include('Components/navbar'); ?>
    <!-- // Render Html // -->
    <?= $this->renderSection('contentHtml'); ?>
  </div>
  
  <!-- Render Js -->
  <?= $this->renderSection('jsComponent'); ?>

  <script src="<?= base_url('assets/js/plugins/axios.min.js'); ?>"></script>

  <script>
    const BASE_URL = "<?= base_url() ?>";

    const httpRequestGet = (url) => {

      return axios
        .get(url,{
            headers: {
            }
        })
        .then((response) => {
            return {
                'status':200,
                'data':response.data
            };
        })
        .catch((error) => {
            if (error.response.status == 500){
                showAlert({
                    message:`<b>gagal!</b> <br> ${error.response.message}`,
                    type:"danger",
                    autohide:true
                });
            }
            
            return {
                'status':error.response.status,
            };
        })
    };
    
    function doXhr(url,method = null,form = null){
      return new Promise((resolve,rejected) => {
          let xhr  = new XMLHttpRequest();

          xhr.open(method,url,true);
          xhr.send(form);
          xhr.timeout   = 15000;
          xhr.ontimeout = () => {
              rejected(Error("Ups, request timeout")); 
          }
          xhr.onload = () => {
              let result = JSON.parse(xhr.responseText);
              resolve(result);
          }
      })
    }
  </script>
  <?= $this->renderSection('contentJs'); ?>

</body>

</html>