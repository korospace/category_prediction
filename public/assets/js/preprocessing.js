/**
 * Button Check
 */
const btnCheck = document.querySelector("button#check"); 
btnCheck.addEventListener("click", () => {
    getDirtyEntry(true);
});

/**
 * Button Clean
 */
document.querySelector("button#clean").addEventListener("click", () => {
    if (dirtyentry.length == 0) {
        return 0;
    }

    showLoadingSpinner();
    
    doXhr(BASE_URL+"/preprocessing/create","POST")
        .then((res) => {
            if (res.code < 300) {
                getDirtyEntry();
                getCleanEntry();
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

let dirtyentry  = "";
const messageEl = document.querySelector("div#dirtyentry #message");
function getDirtyEntry(showLoading = false) {
    if (showLoading) {
        btnCheck.querySelector("#text").classList.add("hide");
        btnCheck.querySelector("#loading").classList.remove("hide");
    }

    doXhr(BASE_URL+"/preprocessing/dirtyentry","GET")
        .then((res) => {
            // getCleanEntry();

            if (res.code < 300) {
                dirtyentry = res.data;
                messageEl.innerHTML = `<b>WARNING!</b> terdapat ${dirtyentry.length} entry belum dibersihkan`;
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
getDirtyEntry();

let tbodySkeleton = document.querySelector("tbody#body_skeleton");
let tbodyMain = document.querySelector("tbody#body_main");

function getCleanEntry() {
    tbodySkeleton.classList.remove("hide");
    tbodyMain.classList.add("hide");

    doXhr(BASE_URL+"/preprocessing/show","GET")
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
                            ${element.p_cf}
                        </td>
                        <td>
                            ${element.p_simbol}
                        </td>
                        <td>
                            ${element.p_stopword}
                        </td>
                        <td>
                            ${element.p_stemming}
                        </td>
                        <td>
                            ${element.p_tokenisasi}
                        </td>
                        <td>
                            ${element.p_stemming}
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
getCleanEntry()