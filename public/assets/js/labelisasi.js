/**
 * Button Check
 */
const btnCheck = document.querySelector("button#check"); 
btnCheck.addEventListener("click", () => {
    getNullKategori(true);
});

/**
 * Button Run
 */
document.querySelector("button#run").addEventListener("click", () => {
    if (nullkategori.length == 0) {
        return 0;
    }

    showLoadingSpinner();
    
    doXhr(BASE_URL+"/labelisasi/create","POST")
        .then((res) => {
            if (res.code < 300) {
                getNullKategori();
                getEntry();
                showAlert({
                    message:`<b>berhasil!</b> <br> ${res.message}`,
                    type:"success",
                    autohide:true
                });
            } 
            else {
                showAlert({
                    message:`<b>gagal!</b> <br> ${res.message}`,
                    type:"danger",
                    autohide:true
                });
            }
            
            hideLoadingSpinner();
        })
        .catch((err) => {
        })
});

/**
 * Get entry with null kategori
 */
let nullkategori  = "";
const messageEl = document.querySelector("div#nullkategori #message");
function getNullKategori(showLoading = false) {
    if (showLoading) {
        btnCheck.querySelector("#text").classList.add("hide");
        btnCheck.querySelector("#loading").classList.remove("hide");
    }
 
     doXhr(BASE_URL+"/labelisasi/nullkategori","GET")
         .then((res) => {
 
             if (res.code < 300) {
                 nullkategori = res.data;
                 messageEl.innerHTML = `<b>WARNING!</b> terdapat ${nullkategori.length} entry belum diberi label`;
                 messageEl.classList.add("warning");
             } else {
                 if (res.code == 404) {
                     messageEl.innerHTML = `<b>UPDATED!</b> ${res.message}`;
                     messageEl.classList.remove("warning");
                 } else {
                     showAlert({
                         message:res.message,
                         type:"danger",
                         autohide:true
                     });
                 }
             }
 
             btnCheck.querySelector("#text").classList.remove("hide");
             btnCheck.querySelector("#loading").classList.add("hide");
         })
         .catch((err) => {
         })
}
getNullKategori();

/**
 * Get Entry From table preprocessin
 */
let tbodySkeleton = document.querySelector("tbody#body_skeleton");
let tbodyMain = document.querySelector("tbody#body_main");
 
function getEntry() {
    tbodySkeleton.classList.remove("hide");
    tbodyMain.classList.add("hide");

    doXhr(BASE_URL+"/labelisasi/show","GET")
        .then((res) => {
            let row = "";
            tbodySkeleton.classList.add("hide");
            tbodyMain.classList.remove("hide");
            
            if (res.code == 404) {
                
            } else {
                
                res.data.forEach(element => {
                    row+=`<tr>
                        <td>
                            <div style="width:100px;word-wrap: break-word;">
                                ${element.entry_id}
                            </div>
                        </td>
                        <td>
                            ${(element.kategori) ? element.kategori : "" }
                        </td>
                        <td>
                            ${element.data_bersih}
                        </td>
                    </tr>`;
                });
                
                document.querySelector("#total_row").innerHTML = res.data.length;
            }

            tbodyMain.innerHTML = row;
        })
        .catch((err) => {
        })
}
getEntry()