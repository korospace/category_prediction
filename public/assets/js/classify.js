/**
 * Get Kategori
 */
 async function getAkurasi() {
    let httpResponse = await httpRequestGet(BASE_URL+"/classify/akurasi"); 

    if (httpResponse.data.code == 200) {
        document.querySelector("#akurasi").innerHTML = httpResponse.data.message;    
    }

}
getAkurasi();

/**
 * Get Kategori
 */
async function getKategori() {
    let row = `<option value="">-- pilih kategori --</option>`;

    let httpResponse = await httpRequestGet(BASE_URL+"/classify/kategori"); 

    if (httpResponse.data.code == 200) {
       let data = httpResponse.data.data;
       
       data.sort(function (a,b) {
           if (a.kata > b.kata) {
               return 1;
           }
           if (b.kata > a.kata) {
               return -1;
           }
           return 0;
       })

       data.forEach(element => {
            row+=`<option value="${element.id}">${element.name}</option>`;
        });
        
    }

    document.querySelector("#id_actual").innerHTML = row;    
}
getKategori();

/**
 * Predict The Text
 */
document.querySelector("#form_input_tes").addEventListener("submit", function (e) {
    e.preventDefault();

    let form = new FormData(e.target);

    showLoadingSpinner();
    document.querySelector("#result").innerHTML="";

    doXhr(BASE_URL+"/classify/predict","POST",form)
        .then((res) => {
            hideLoadingSpinner();

            let message = "";
            let type    = "";
            
            if (res.code < 300) {
                let row = "";
                res.data.forEach(e => {
                    row += `<tr>
                        <td>${e.name}</td>
                        <td>${e.nilai}</td>
                        <td>${e.tmp_nilai}</td>
                    </tr>`;
                });

                document.querySelector("#result").innerHTML=`
                    <table id="table_result">
                        <thead>
                            <tr>
                                <th>kategori</th>
                                <th>nilai</th>
                                <th>tmp_nilai</th>
                            </tr>
                        <thead>
                        <thead>
                            ${row}
                        <thead>
                    </table>
                    ${res.message}
                `;

                getAkurasi();
                // clean input
                document.querySelector("#id_actual").value="";
                document.querySelector("#text").value="";
                
            } else {
                if (res.code == 400) {
                    let msg = "";

                    for (const key in res.message) {
                        msg += `<li>${res.message[key]}</li>`
                    }

                    type    = "warning";
                    message = `<ul style="padding:0 20px;">${msg}</ul>`;
                } 
                else {
                    type    = "danger";
                    message = res.message;
                }

                showAlert({
                    message:message,
                    type:type,
                    autohide:true
                });
            }

        })
        .catch((err) => {
        })
})