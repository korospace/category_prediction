
/**
 * Form Scrap
 */
const formScrap = document.querySelector("#form_input_link");
const inputLink = formScrap.querySelector("input");

formScrap.addEventListener('submit',(e) => {
    e.preventDefault();
    let form = new FormData(formScrap);

    if (form.get("link") == "") {
        showAlert({
            message:`masukan link galert!`,
            type:"warning",
            autohide:true
        });
    } 
    else {
        showLoadingSpinner();

        doXhr(BASE_URL+"/galertEntry/create","POST",form)
            .then((res) => {
                let message = "";
                let type    = "";
                
                if (res.code < 300) {
                    let entries = res.data;
                    message = `<b>success!</b> ${entries.length} baris berhasil ditambah`;
                    type    = "success";
                    getAllEntries();

                    // clean input
                    inputLink.value = "";
                    options.forEach(e => {
                        e.checked = false;
                    })
                } else {
                    if (res.code == 400) {
                        message = `<b>gagal!</b> google alert belum diupdate, coba lain hari`;
                        type    = "warning";
                    } else {
                        message = res.message;
                        type    = "danger";
                    }
                }

                hideLoadingSpinner();
                showAlert({
                    message:message,
                    type:type,
                    autohide:true
                });
            })
            .catch((err) => {
            })
    }

})

/**
 * Link Options
 */
const options = document.querySelectorAll("#container_link_options input");

options.forEach(e => {
    e.addEventListener('change', () => {
        formScrap.querySelector("input").value = e.value;
    })
})

/**
 * Get All Entries
 */
let tbodySkeleton = document.querySelector("tbody#body_skeleton");
let tbodyMain = document.querySelector("tbody#body_main");

function getAllEntries() {
    tbodySkeleton.classList.remove("hide");
    tbodyMain.classList.add("hide");

    doXhr(BASE_URL+"/galertEntry/show","GET")
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
                            <a href="${element.entry_link}" target="_blank" style="color:yellow">
                                click
                            </a>
                        </td>
                        <td>
                            ${element.entry_author}
                        </td>
                        <td>
                            ${element.entry_title}
                        </td>
                        <td>
                            ${element.entry_content}
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
getAllEntries();