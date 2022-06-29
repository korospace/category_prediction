/**
 * Button Show PopUp
 */
document.querySelector("#add_word button").addEventListener('click',() => {
    showPopUpCsv();
});

/**
 * Get All Entries
 */
function getAllSlangWord() {
    doXhr(BASE_URL+"/slangWord/show","GET")
        .then((res) => {
            let row = "";
            
            if (res.code == 404) {
                
            } else {
                let data = res.data;
                
                data.sort(function (a,b) {
                    if (a.kata_nonbaku > b.kata_nonbaku) {
                        return 1;
                    }
                    if (b.kata_nonbaku > a.kata_nonbaku) {
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
                            ${element.kata_nonbaku}
                        </td>
                        <td>
                            ${element.kata_baku}
                        </td>
                        <td>
                        </td>
                    </tr>`;
                });
                
                document.querySelector("#total_row").innerHTML = res.data.length;
            }
            
            document.querySelector("#container_table table tbody").innerHTML = row;
        })
        .catch((err) => {
        })
}
getAllSlangWord();