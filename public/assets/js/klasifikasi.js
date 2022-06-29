/**
 * Get Probabilitas Kategori
 */
let tProbKatSkeleton = document.querySelector("#table_prob_kat #body_skeleton");
let tProbKatMain = document.querySelector("#table_prob_kat #body_main");
  
function getProbKategori() {
    tProbKatSkeleton.classList.remove("hide");
    tProbKatMain.classList.add("hide");

    doXhr(BASE_URL+"/klasifikasi/probabilitas_kategori","GET")
        .then((res) => {
            let row = "";
            tProbKatSkeleton.classList.add("hide");
            tProbKatMain.classList.remove("hide");
            
            if (res.code == 404) {
                
            } else {
                res.data.forEach((element,i) => {
                    row+=`<tr>
                        <td>
                            ${++i}
                        </td>
                        <td>
                            ${element.kategori}
                        </td>
                        <td>
                            ${element.jml_kat}
                        </td>
                        <td>
                            ${element.jml_all}
                        </td>
                        <td>
                            ${element.nilai}
                        </td>
                    </tr>`;
                });
                
            }

            tProbKatMain.innerHTML = row;
        })
        .catch((err) => {
        })
}
getProbKategori()

/**
 * Get Probabilitas Kategori
 */
let tProbDataSkeleton = document.querySelector("#table_prob_data #body_skeleton");
let tProbDataMain = document.querySelector("#table_prob_data #body_main");

async function countProbData() {
    tProbDataSkeleton.classList.remove("hide");
    tProbDataMain.classList.add("hide");

    let httpResponse = await httpRequestGet(BASE_URL+"/klasifikasi/count_dataprob"); 

    tProbDataSkeleton.classList.add("hide");
    tProbDataMain.classList.remove("hide");

    if (httpResponse.data.code == 200) {
        getProbData();
    }
}
countProbData();

async function getProbData() {
    let row = "";
    tProbDataSkeleton.classList.remove("hide");
    tProbDataMain.classList.add("hide");

    let httpResponse = await httpRequestGet(BASE_URL+"/klasifikasi/get_dataprob"); 

    tProbDataSkeleton.classList.add("hide");
    tProbDataMain.classList.remove("hide");

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

       data.forEach((element,i) => {
            row+=`<tr>
                <td>
                    ${++i}
                </td>
                <td>
                    ${element.kategori}
                </td>
                <td>
                    ${element.kata}
                </td>
                <td>
                    ${element.jml_data}
                </td>
                <td>
                   ${element.jml_kategori}
                </td>
                <td>
                    ${element.nilai}
                </td>
            </tr>`;
        });
        
    }

    tProbDataMain.innerHTML = row;    
}