<script>
  import svelteLogo from "./assets/svelte.svg";
  import Counter from "./lib/Counter.svelte";
  import Navbarmenu from "./components/Navbarmenu.svelte";
  import LayoutSidenav from "./components/LayoutSidenav.svelte";
  import Daftarkariahview from "./components/Daftarkariahview.svelte";
  import Dashboardview from "./components/Dashboardview.svelte";
  import Senaraiahliview from "./components/Senaraiahliview.svelte";
  import Senaraitanggunganview from "./components/Senaraitanggunganview.svelte";
  import Penerimakhairatview from "./components/Penerimakhairatview.svelte";
  import Rekodbayaranview from "./components/Rekodbayaranview.svelte";
  import Laporanview from "./components/Laporanview.svelte";
  import Infosistemview from "./components/Infosistemview.svelte";
  import Tetapanzonview from "./components/Tetapanzonview.svelte";
  import Pengumumanview from "./components/Pengumumanview.svelte";
  import Profilview from "./components/Profilview.svelte";
  import Daftarahliview from "./components/Daftarahliview.svelte";
  import EditSenaraiahliview from "./components/EditSenaraiahliview.svelte";
  import KemaskiniTanggunganview from "./components/KemaskiniTanggunganview.svelte";
  

  // import Jenisyuranview from "./components/Jenisyuranview.svelte";
  // import Kadaryuranview from "./components/Kadaryuranview.svelte";

  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";

  let logout_url;
  let detailuser;
  let allapidata;
  let activeItem = "";
  let stage_daftar;
  let fields ;


  // let apidata_testing = new Promise(function (myResolve, myReject) {
  //   let url = `${mybaseurl}/wp-json/khai_api/v1/data`;

  //   fetch(url, {
  //     // Adding method type
  //     method: "GET",
  //     // Adding body or contents to send
  //   })
  //     // Converting to JSON
  //     .then((response) => response.json())

  //     // Displaying results to console
  //     .then((result) => {
  //       myResolve(JSON.stringify(result));
  //       // logout_url = result["logout_url"];
  //       // detailuser = result["user_id"];
  //       // console.log("xx", result);
  //       // console.log("xx", result.length);
  //     })
  //     .catch((error) => console.log("error", error));
  // });

  let apidata = new Promise(function (myResolve, myReject) {
    let url = `${mybaseurl}/wp-json/api/v1/data`;
    const dataArray = new FormData();
    dataArray.append("actionname", "sendMessage");

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
      })
      .catch((error) => console.log("error", error));
  });

  (async () => {
    allapidata = JSON.parse(await apidata);
    detailuser = JSON.parse(await apidata).user_id.data.display_name;
    logout_url = JSON.parse(await apidata)["logout_url"];
    stage_daftar = JSON.parse(await apidata).stage_daftar;
    // console.log("allapidata.stage_daftar", allapidata.stage_daftar);
    if (allapidata.stage_daftar == 0) {
      activeItem = "Daftarkariahview";
    }
    if (allapidata.stage_daftar == 1) {
      activeItem = "Dashboardview";
    }
  })();

  const tabChange = (e, data) => {
   
    if(Array.isArray(e.detail) === true){
      // console.log('tabChange',   e.detail[1]);
      fields = {passdata: e.detail[1]} ; 
      activeItem = e.detail[0];
    }else{
      activeItem = e.detail;
    }
    
  };

  const submitkariah = (e) => {
    allapidata.kariah = [e.detail];
    allapidata.user_id.data.kariah_name = e.detail.kariah_name ;
    

    // console.log("allapidata.kariah", allapidata.kariah);
  };

  const submitprofil = (e) => {
    allapidata.user_id.data = e.detail;
  };

  // $: console.log("all api data", allapidata);
</script>

<Navbarmenu {logout_url} on:tabChange={tabChange} />

<div id="layoutSidenav">
  <LayoutSidenav
    {detailuser}
    {activeItem}
    {stage_daftar}
    on:tabChange={tabChange}
  />

  <div id="layoutSidenav_content">
    <main>
      {#if activeItem === "Daftarkariahview"}
        <Daftarkariahview
          fieldkariah={allapidata.kariah === undefined ? [] : allapidata.kariah}
          on:submitkariah={submitkariah}
        />
      {:else if activeItem === "Dashboardview"}
        <Dashboardview />
      {:else if activeItem === "Senaraiahliview"}
        <Senaraiahliview on:tabChange={tabChange} />
      {:else if activeItem === "EditSenaraiahliview"}
        <EditSenaraiahliview {fields} on:tabChange={tabChange} />
      {:else if activeItem === "Daftarahliview"}
        <Daftarahliview fields={allapidata.kariah} on:tabChange={tabChange} />
      {:else if activeItem === "KemaskiniTanggunganview"}
        <KemaskiniTanggunganview {fields} on:tabChange={tabChange} />
      {:else if activeItem === "Senaraitanggunganview"}
        <Senaraitanggunganview />
      {:else if activeItem === "Penerimakhairatview"}
        <Penerimakhairatview />
      {:else if activeItem === "Rekodbayaranview"}
        <Rekodbayaranview />
      {:else if activeItem === "Laporanview"}
        <Laporanview />
      {:else if activeItem === "Infosistemview"}
        <Infosistemview />
      {:else if activeItem === "Tetapanzonview"}
        <Tetapanzonview />
      {:else if activeItem === "Pengumumanview"}
        <Pengumumanview />
      {:else if activeItem === "Jenisyuranview"}
        <Jenisyuranview />
      {:else if activeItem === "Kadaryuranview"}
        <Kadaryuranview />
      {:else if activeItem === "Profilview"}
        <Profilview
          fields={allapidata.user_id.data}
          on:submitprofil={submitprofil}
        />
      {:else}
      <div class="d-flex justify-content-center"> <img class="" src="/assets/img/loading.gif" alt=""></div>
     {/if}
    </main>
    <footer class="py-4 bg-light mt-auto">
      <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; Your Website 2022</div>
          <div>
            <a href="#">Privacy Policy</a>
            &middot;
            <a href="#">Terms &amp; Conditions</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</div>
