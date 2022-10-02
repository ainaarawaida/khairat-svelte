<script>
    import { onMount } from "svelte";
    import { createEventDispatcher } from "svelte";
    import moment from "moment" ;

    let dispatch = createEventDispatcher();
    export let fields = {
        ID:"",
        display_name: "",
        user_email: "",
        kata_laluan: "",
        kata_laluan_r: "",
        user_registered_x: "",
        no_ahli: "",
        jenis_ahli: "",
        jenis_ahli_x: "",
        passdata: "",
        tanggungan: [],
    };
    let arraytunggangan = [] ;
    let passdata ;
    let datamodel = {
      tanggungan_nama: "",
      ID: "",
      tanggungan_icno: "",
      tanggungan_pertalian: "",
      tanggungan_telno: "",
    }
  
    let submit = false;
    let errors = [];
  
    let mybaseurl =
      import.meta.env.MODE !== "development"
        ? window.location.origin
        : "http://khairat.test";
    let temp_site_page_url = "";
  
    const submitHandler = async (e) => {
      
      let action = '' ; 
      errors = [];
      for(let i = 0 ; i < e.target.length; i++){
        if(e.target[i].name === 'action'){
            action = e.target[i].value ; 
          break ; 
        }
      }
      // console.log("action e", action);
      if(action === "EditSenaraiahliview"){
            if (fields.kata_laluan !== fields.kata_laluan_r) {
              errors.push({
                key: "kata_laluan",
                text: "Kata Laluan Ulangan tidak sama",
              });
            }

            // console.log('fields.telno.substring',fields.telno.toString().substring(0, 2));
            if (fields.telno.toString().substring(0, 2) != '60') {
              errors.push({
                key: "telno",
                text: "Sila ikut format Nombor Telefon 60XXXXXXXXXX",
              });
            }
        
            // console.log("errors", errors);
        
            // console.log(errors.some((d) => d.key.includes("kata_laluan")));
        
            if (errors.length > 0) {
              submit = true;
              return;
            }
            if (errors.length === 0) {
              let url = `${mybaseurl}/wp-json/api/v1/data`;
              let dataArray = new FormData();
              dataArray.append("action", "EditSenaraiahliview");
              dataArray.append("ID", fields.ID);
              dataArray.append("display_name", fields.display_name);
              dataArray.append("user_email", fields.user_email);
              dataArray.append("user_pass", fields.kata_laluan);
              dataArray.append("icno", fields.icno);
              dataArray.append("telno", fields.telno);
              dataArray.append("jenis_ahli", fields.jenis_ahli);
              dataArray.append("kariah_name", fields.kariah_name);
              dataArray.append("stage_daftar", fields.stage_daftar);
              dataArray.append("alamat_ahli", fields.alamat_ahli);
              dataArray.append("user_registered", fields.user_registered_x);
              
              
              
        
              let apidata = new Promise(function (myResolve, myReject) {
                fetch(url, {
                  // Adding method type
                  method: "POST",
                  // Adding body or contents to send
                  body: dataArray,
                })
                  // Converting to JSON
                  .then((response) => response.json())
        
                  // Displaying results to console
                  .then((result) => {
                    myResolve(result);
                    submit = true;
                    errors =
                      JSON.parse(result).submitpost.error === undefined
                        ? []
                        : JSON.parse(result).submitpost.error;
        
                  //   console.log("errors after submit", errors);
        
                  
        
                    // console.log("post result", JSON.parse(result));
                  })
                  .catch((error) => console.log("error", error));
              });
            }

      }else if(action === "EditSenaraiahliview_save_tanggungan_ahli"){

        if (fields.tanggungan_telno.toString().substring(0, 2) != '60') {
              errors.push({
                key: "tanggungan_telno",
                text: "Sila ikut format Nombor Telefon 60XXXXXXXXXX",
              });
            }
        
            if (errors.length > 0) {
              submit = true;
              return;
            }
            if (errors.length === 0) {

              let url = `${mybaseurl}/wp-json/api/v1/data`;
              let dataArray = new FormData();
              dataArray.append("action", "EditSenaraiahliview_save_tanggungan_ahli");
              dataArray.append("ID", fields.ID);
              dataArray.append("tanggungan_nama", fields.tanggungan_nama);
              dataArray.append("tanggungan_icno", fields.tanggungan_icno);
              dataArray.append("tanggungan_pertalian", fields.tanggungan_pertalian);
              dataArray.append("tanggungan_telno", fields.tanggungan_telno); 
        
              let apidata = new Promise(function (myResolve, myReject) {
                fetch(url, {
                  // Adding method type
                  method: "POST",
                  // Adding body or contents to send
                  body: dataArray,
                })
                  // Converting to JSON
                  .then((response) => response.json())
        
                  // Displaying results to console
                  .then((result) => {
                    myResolve(result);
                    submit = true;
                    errors =
                      JSON.parse(result).submitpost.error === undefined
                        ? []
                        : JSON.parse(result).submitpost.error;

                    //   arraytunggangan.push({
                    //   ID: fields.ID,
                    //   tanggungan_icno: fields.tanggungan_icno.toString() ,
                    //   tanggungan_nama: fields.tanggungan_nama,
                    //   tanggungan_pertalian: fields.tanggungan_pertalian,
                    //   tanggungan_telno: fields.tanggungan_telno.toString()
                    // });

                    // arraytunggangan = arraytunggangan; 
                    arraytunggangan = [...arraytunggangan, {
                      ID: fields.ID,
                      tanggungan_icno: fields.tanggungan_icno.toString() ,
                      tanggungan_nama: fields.tanggungan_nama,
                      tanggungan_pertalian: fields.tanggungan_pertalian,
                      tanggungan_telno: fields.tanggungan_telno.toString()
                    }];

                    fields.tanggungan = arraytunggangan ;
                    
                    
                
        
                  })
                  .catch((error) => console.log("error", error));
              });


            }

      }else if(action === "EditSenaraiahliview_save_tanggungan_ahli_modal"){
        // dispatch("tabChange", "Profilview") ;
        // var myModalEl = document.querySelector("#exampleModal");
        // myModalEl.className = "modal fade";
        // myModalEl.setAttribute('style', '');
        // var body = document.querySelector("body");
        // body.className = "";
        // console.log("myModalEl",myModalEl);
        // var modalbackdrop = document.querySelector("div.modal-backdrop");
        // modalbackdrop.parentNode.removeChild( modalbackdrop );


      }else {
        return;
      }
  

    };
  
    const closealert = async () => {
      errors = [];
      submit = false;
    };




  

  
    onMount(async () => {
         
      passdata = JSON.parse(atob(fields.passdata)) ;
      fields.ID = passdata[1];
      fields.display_name = passdata[2];
      fields.user_email = passdata[8];
      fields.icno = passdata[3];
      fields.telno = passdata[5];
      let year = passdata[7].substring(0, 4);
      let month = passdata[7].substring(5, 7);
      let day = passdata[7].substring(8, 10);
      fields.user_registered_x = [year, month, day].join("-");
      fields.kariah_name = passdata[4];
      fields.kata_laluan = "";
      fields.kata_laluan_r = "";
      fields.no_ahli = `000${passdata[1]}`;
      if (passdata[9].includes("pentadbir")) {
        fields.jenis_ahli = "1";
      } else if (passdata[9].includes("ahli")) {
        fields.jenis_ahli = "2";
      }else if (passdata[9].includes("asnaf")) {
        fields.jenis_ahli = "3";
      }

      fields.stage_daftar= passdata[6];
      fields.alamat_ahli= passdata[10];
      fields.tanggungan = passdata[11];
      arraytunggangan = passdata[11]; ; 


      setTimeout(() => {
              var eleopenmodal = document.querySelectorAll(".openmodal");
            
            for (let i = 0; i < eleopenmodal.length; i++) {
              eleopenmodal[i].addEventListener("click", function () {
                let datamodel = JSON.parse(atob(eleopenmodal[i].getAttribute('data-pass')))  ;
                console.log("dataid",datamodel);
              });
            }
      }, 100)


     

     
    

    });


    function calculateAge(dateString) { // birthday is a date
      let condatey = moment(dateString.substring(0, 2), "YY").format("YYYY");
      let condatem = dateString.substring(2, 4);
      let condated = dateString.substring(4, 6); 
      var today = new Date();
      var birthDate = new Date(`${condatey}-${condatem}-${condated}`);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
      }
      return age;
    }


   
    // $: console.log("arraytunggangan =" ,arraytunggangan);

  </script>
  
  <div class="container-fluid px-4">
    <h3 class="mt-4">Kemaskini Ahli</h3>
    <div class="row alert alert-warning alert-dismissable">
      <div class="col">
        Setiap akaun ahli mempunyai 5 bahagian iaitu ;<br>
1. Maklumat Ahli <br>
2. Maklumat Tanggungan <br>
3. Rekod Bayaran <br>
4. Rekod Maanfaat <br>
5. Muatnaik Dokumen <br>
      </div>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      />
    </div>
   
    {#if submit === true}
      {#if errors.length > 0}
        {#each errors as key}
          <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
          >
            <strong>{key.text}</strong>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="alert"
              aria-label="Close"
              on:click={() => closealert()}
            />
          </div>
        {/each}
      {:else}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <strong>Successul Update</strong>
          <button
            on:click={() => dispatch("tabChange", "Senaraiahliview")}
            class="btn btn-primary"
           
            >Lihat Senarai Ahli</button
          >
  
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
            on:click={() => closealert()}
          />
        </div>
      {/if}
    {/if}
  



    <div class="accordion" id="accordionExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
            <b>Maklumat Peribadi Ahli</b> 
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
          <div class="accordion-body">
          
            <form
            class="woocommerce-EditAccountForm edit-account"
            on:submit|preventDefault={(e) => submitHandler(e)}
          >
      
          <input
          type="hidden"
          class=""
          name="ID"
          id="ID"
          bind:value={fields.ID}
          
          />
        
          <div class="">
            <p
            class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
          >
            <label for="display_name">Nama Penuh<span class="required">*</span></label
            >
            <input
              type="text"
              class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                (d) => d.key.includes('display_name')
              )
                ? 'is-invalid'
                : ''}"
              name="display_name"
              id="display_name"
              bind:value={fields.display_name}
              required
            />
          </p>
          <div class="clear" />
      
          <p
            class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
          >
            <label for="user_email">Emel <span class="required">*</span></label>
            <input
              type="email"
              class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                (d) => d.key.includes('user_email')
              )
                ? 'is-invalid'
                : ''}"
              name="user_email"
              id="user_email"
              bind:value={fields.user_email}
              required
            />
          </p>
          <div class="clear" />
      
          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="user_pass"
                  >Kata Laluan<span class="required">*</span>
                  <i>(Kosongkan jika tidak ingin ubah)</i>
                </label>
                <input
                  type="password"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('kata_laluan')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="user_pass"
                  id="user_pass"
                  bind:value={fields.kata_laluan}
                />
              </p>
            </div>
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="user_pass_r"
                  >Ulang Kata laluan<span class="required">*</span>
                  <i>(Kosongkan jika tidak ingin ubah)</i>
                </label>
                <input
                  type="password"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('kata_laluan')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="user_pass_r"
                  id="user_pass_r"
                  bind:value={fields.kata_laluan_r}
                />
              </p>
            </div>
          </div>
          <div class="clear" />
      
          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="icno"
                  >No. Kad Pengenalan Baru<span class="required">*</span>
                </label>
                <input
                  type="number"
                  min="100000000000"
                  max="999999999999"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('icno')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="icno"
                  id="icno"
                  bind:value={fields.icno}
                  required
                />
              </p>
            </div>
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="telno"
                  >Nombor Telefon<span class="required">*</span>
                </label>
                <input
                  type="number"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('telno')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="telno"
                  id="telno"
                  bind:value={fields.telno}
                  required
                />
              </p>
            </div>
          </div>
          <div class="clear" />
      
          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="alamat_ahli"
                  >Alamat<span class="required"
                    >*</span
                  >
                </label>
                <textarea class="form-control" name="alamat_ahli" id="alamat_ahli" rows="2" bind:value={fields.alamat_ahli} required></textarea>
              </p>
            </div>
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="kariah_name"
                  >Nama Kariah <span class="required">*</span>
                </label>
                <input
                  readonly
                  type="text"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('kariah_name')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="kariah_name"
                  id="kariah_name"
                  bind:value={fields.kariah_name}
                  required
                />
              </p>
            </div>
          </div>
          <div class="clear" />
    
    
          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="user_registered"
                  >Tarikh Daftar<span class="required"
                    >*</span
                  >
                </label>
                <input
                  
                  type="date"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('user_registered')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="user_registered"
                  id="user_registered"
                  bind:value={fields.user_registered_x}
                  required
                />
              </p>
            </div>
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="no_ahli"
                  >Nombor Keahlian<span class="required">*</span>
                </label>
                <input
                  readonly
                  type="number"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('no_ahli')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="no_ahli"
                  id="no_ahli"
                  bind:value={fields.no_ahli}
                  required
                />
              </p>
            </div>
          </div>
          <div class="clear" />
      
          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="jenis_ahli"
                  >Jenis Ahli <span class="required">*</span>
                </label>
      
                <select
                  bind:value={fields.jenis_ahli}
                  class="form-control required valid"
                  id="jenis_ahli"
                  name="jenis_ahli"
                  aria-required="true"
                  aria-invalid="false"
                  required
                >
                  <option value="">Pilih Ahli</option>
                  <option value="1">Pentadbir Sistem</option>
                  <option value="2">Ahli Biasa</option>
                  <option value="3">Ahli Asnaf</option>
                </select>
              </p>
            </div>
      
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="stage_daftar"
                  >Status Ahli <span class="required">*</span>
                </label>
      
                <select
                  bind:value={fields.stage_daftar}
                  class="form-control required valid"
                  id="stage_daftar"
                  name="stage_daftar"
                  aria-required="true"
                  aria-invalid="false"
                  required
                >
                  <option value="1">Aktif</option>
                  <option value="2">Tidak Aktif</option>
                </select>
              </p>
            </div>
          </div>
          <div class="clear" />
    
         
    
    
          </div>
    
          <p>
            <button
              type="submit"
              class="btn btn-primary"
              name="submit_site_details"
              value="Save changes">Save changes</button
            >
            <input type="hidden" name="action" value="EditSenaraiahliview" />
          </p>
        </form>
    
        
          </div> <!--accordion-body -->
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <b>Maklumat Tanggungan</b> 
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            
            <form
          class="woocommerce-EditAccountForm edit-account"
          on:submit|preventDefault={(e) => submitHandler(e)}
        >
          <input
          type="hidden"
          class=""
          name="tanggungan_ID"
          id="tanggungan_ID"
          bind:value={fields.ID} />


          <div class="row">
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="tanggungan_nama">Nama Penuh<span class="required">*</span></label
                >
                <input
                  type="text"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('tanggungan_nama')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="tanggungan_nama"
                  id="tanggungan_nama"
                  bind:value={fields.tanggungan_nama}
                  required
                />
              </p>
      

            </div>
            <div class="col">
              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="tanggungan_icno"
                  >No. Kad Pengenalan Baru<span class="required">*</span>
                </label>
                <input
                  type="number"
                  min="100000000000"
                  max="999999999999"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('tanggungan_icno')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="tanggungan_icno"
                  id="tanggungan_icno"
                  bind:value={fields.tanggungan_icno}
                  required
                />
              </p>

            </div>

          </div>

          <div class="clear" />
          <div class="row">
            <div class="col">

              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="tanggungan_pertalian"
                  >Pertalian Keluarga <span class="required">*</span>
                </label>
      
                <select
                  bind:value={fields.tanggungan_pertalian}
                  class="form-control required valid"
                  id="tanggungan_pertalian"
                  name="tanggungan_pertalian"
                  aria-required="true"
                  aria-invalid="false"
                  required
                >
                  <option value="">Sila Pilih</option>
                  <option value="PASANGAN">PASANGAN</option>
                  <option value="ANAK">ANAK</option>
                  <option value="IBU/BAPA">IBU/BAPA</option>
                  <option value="DATUK/NENEK">DATUK/NENEK</option>
                  <option value="LAIN-LAIN">LAIN-LAIN</option>
                </select>
              </p>


          

            </div>
            <div class="col">

              <p
                class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
              >
                <label for="tanggungan_telno"
                  >Nombor Telefon<span class="required">*</span>
                </label>
                <input
                  type="number"
                  class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                    (d) => d.key.includes('tanggungan_telno')
                  )
                    ? 'is-invalid'
                    : ''}"
                  name="tanggungan_telno"
                  id="tanggungan_telno"
                  bind:value={fields.tanggungan_telno}
                  required
                />
              </p>

            </div>
          </div>
          <p>
            <button
              type="submit"
              class="btn btn-success"
              name="submit_site_details"
              value="Save changes">Tambah</button
            >
            <input type="hidden" name="action" value="EditSenaraiahliview_save_tanggungan_ahli" />
          </p>
        </form>
     
        <div class="m-3"></div>
        <table class="table table-striped table-hover">
          <thead>
            <tr class="table-dark">
              <th scope="col">#</th>
              <th scope="col">Nama</th>
              <th scope="col">Pertalian</th>
              <th>No. KP</th>
              <th>Telefon</th>
              <th>Umur</th>
              <th>Yuran</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
            {#if fields.tanggungan}
            {#each fields.tanggungan as key, i}
            <tr>
              <th scope="row">{i+1}</th>
              <td>{key.tanggungan_nama}</td>
              <td>{key.tanggungan_pertalian}</td>
              <td>{key.tanggungan_icno}</td>
              <td>{key.tanggungan_telno}</td>
              <td>{calculateAge(key.tanggungan_icno)}</td>
              
              <th>Yuran</th>
              <th><button
                on:click={() => dispatch("tabChange", ["KemaskiniTanggunganview",btoa(JSON.stringify(key))])}
                class="btn btn-primary btn-sm"
                ><i class="fa fa-search"></i></button
              ></th>
            </tr>
            {/each}
            {/if}
          </tbody>
        </table>


          <!-- Modal -->
          <form
              class="woocommerce-EditAccountForm edit-account"
              on:submit|preventDefault={(e) => submitHandler(e)}
            >
        
            <input
            type="hidden"
            class=""
            name="ID"
            id="ID"
            bind:value={fields.ID}
            
            />

          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">MAKLUMAT TANGGUNGAN</h5>
                  <button type="button" class="btn-close btnclosemaklumattanggungan" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="dm_tanggungan_nama">Nama Penuh<span class="required">*</span></label
                        >
                        <input
                          type="text"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                            (d) => d.key.includes('dm_tanggungan_nama')
                          )
                            ? 'is-invalid'
                            : ''}"
                          name="dm_tanggungan_nama"
                          id="dm_tanggungan_nama"
                          bind:value={datamodel.tanggungan_nama}
                          required
                        />
                      </p>


                    </div>
                   
                  </div>
                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="dm_tanggungan_icno"
                          >No. Kad Pengenalan Baru<span class="required">*</span>
                        </label>
                        <input
                          type="number"
                          min="100000000000"
                          max="999999999999"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.some(
                            (d) => d.key.includes('dm_tanggungan_icno')
                          )
                            ? 'is-invalid'
                            : ''}"
                          name="dm_tanggungan_icno"
                          id="dm_tanggungan_icno"
                          bind:value={datamodel.tanggungan_icno}
                          required
                        />
                      </p>

                    </div>
                   
                  </div>
                  <div class="row">
                    <div class="col">

                      <p
                          class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                        >
                          <label for="dm_tanggungan_pertalian"
                            >Pertalian Keluarga <span class="required">*</span>
                          </label>
                
                          <select
                            bind:value={datamodel.tanggungan_pertalian}
                            class="form-control required valid"
                            id="dm_tanggungan_pertalian"
                            name="dm_tanggungan_pertalian"
                            aria-required="true"
                            aria-invalid="false"
                            required
                          >
                            <option value="">Sila Pilih</option>
                            <option value="PASANGAN">PASANGAN</option>
                            <option value="ANAK">ANAK</option>
                            <option value="IBU/BAPA">IBU/BAPA</option>
                            <option value="DATUK/NENEK">DATUK/NENEK</option>
                            <option value="LAIN-LAIN">LAIN-LAIN</option>
                          </select>
                        </p>

                    </div>
                   
                  </div>

                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="display_name">Nama Penuh<span class="required">*</span></label
                        >
                        <input
                          type="text"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control"
                          name="tanggungan_nama"
                          id="tanggungan_nama"
                          bind:value={fields.tanggungan_nama}
                          readonly
                        />
                      </p>

                    </div>
                   
                  </div>

                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="display_name">Nama Penuh<span class="required">*</span></label
                        >
                        <input
                          type="text"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control"
                          name="tanggungan_nama"
                          id="tanggungan_nama"
                          bind:value={fields.tanggungan_nama}
                          readonly
                        />
                      </p>

                    </div>
                   
                  </div>

                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="display_name">Nama Penuh<span class="required">*</span></label
                        >
                        <input
                          type="text"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control"
                          name="tanggungan_nama"
                          id="tanggungan_nama"
                          bind:value={fields.tanggungan_nama}
                          readonly
                        />
                      </p>

                    </div>
                   
                  </div>

                  <div class="row">
                    <div class="col">

                      <p
                        class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
                      >
                        <label for="display_name">Nama Penuh<span class="required">*</span></label
                        >
                        <input
                          type="text"
                          class="woocommerce-Input woocommerce-Input--text input-text form-control"
                          name="tanggungan_nama"
                          id="tanggungan_nama"
                          bind:value={fields.tanggungan_nama}
                          readonly
                        />
                      </p>

                    </div>
                   
                  </div>
                 
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary" name="submit_site_details" value="Save changes">Kemaskini</button>
                </div>
              </div>
            </div>
          </div>
            <input type="hidden" name="action" value="EditSenaraiahliview_save_tanggungan_ahli_modal" />
         
        </form>

          <!-- End Modal -->

          
          </div><!-- accordian-body -->
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Accordion Item #3
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
          </div>
        </div>
      </div>
    </div>

   


    <div class="m-3"></div>

    
  </div>
  