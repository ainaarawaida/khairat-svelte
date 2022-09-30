<script>
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { createEventDispatcher } from "svelte";
  let dispatch = createEventDispatcher();
  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";
  let url = `${mybaseurl}/wp-json/api/v1/data`;
  let csvdownload;
  let dataTable;
  let senaraiahli = [];

  onMount(async () => {
    dataTable = new simpleDatatables.DataTable("#datatablesSimple", {});

    csvdownload = () => {
      dataTable.export({
        type: "csv",
        filename: "senarai-ahli",
      });
    };

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "Senaraiahliview");
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
          // setTimeout(() => {
          // dataTable.destroy();
          // dataTable = new simpleDatatables.DataTable("#datatablesSimple", {});
          // dataTable.refresh();
          for (let i = 0; i < JSON.parse(result).submitpost.length; i++) {
            console.log("dataTable", JSON.parse(result).submitpost[i]);
            var array = Object.keys(JSON.parse(result).submitpost[i]).map(
              function (key) {
                return JSON.parse(result).submitpost[i][key];
              }
            );
            console.log("array", array);
            array[7] = ` <button
                    class="btn btn-primary btn-sm editahli"
                    ><i class="fa fa-pencil"></i></button
                  >
                  <button
                    
                    class="btn btn-danger btn-sm deleteahli"
                    ><i class="fa fa-trash"></i></button
                  >`;
            array[8] = `<button
                    class="btn btn-warning btn-sm"
                    disabled><i class="fa fa-exclamation-triangle" /></button
                  >`;
            dataTable.rows().add(array);
          }

          // dataTable = new simpleDatatables.DataTable("#datatablesSimple", {});
          // dataTable.refresh();
          // }, 2900);
        })
        .catch((error) => console.log("error", error));
    });

    senaraiahli = JSON.parse(await apidata).submitpost;

    var element = document.querySelectorAll(".editahli");
    console.log("element", element);
    for (let i = 0; i < element.length; i++) {
      element[i].addEventListener("click", function () {
        alert("editahli");
      });
    }
    var element = document.querySelectorAll(".deleteahli");
    console.log("element", element);
    for (let i = 0; i < element.length; i++) {
      element[i].addEventListener("click", function () {
        alert("deleteahli");
      });
    }

    console.log("senaraiahli", senaraiahli);
  });

  onDestroy(() => {});

  let editahli = () => {
    alert("edit ahli");
  };
  let deleteahli = () => {
    alert("edit ahli");
  };
</script>

<div class="container-fluid px-4">
  <h3 class="mt-4">Senarai Ahli</h3>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Senarai Ahli</li>
  </ol>

  <div class="row alert alert-warning alert-dismissable">
    <div class="col">
      Semua ahli yang berdaftar dan telah diluluskan akan dipaparkan dibahagian
      ini. Pentadbir perlu klik edit untuk melihat perincian ahli, bayaran,
      tanggungan dan faedah khairat yang diterima.
    </div>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="alert"
      aria-label="Close"
    />
  </div>

  <div class="row ">
    <div class="col text-end">
      <button
        on:click={() => dispatch("tabChange", "Daftarahliview")}
        class="btn btn-primary"
        href="https://www.e-khairat.com/demo_v3/addNew"
        ><i class="fa fa-plus" /> Daftar Ahli</button
      >
      <button
        class="btn btn-danger"
        href="https://www.e-khairat.com/demo_v3/inActive"
        >Senarai Ahli Tidak Aktif</button
      >
    </div>
  </div>
  <br />

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1" />
      Senarai Ahli
    </div>
    <div class="card-body">
      <button on:click={() => csvdownload()} class="btn btn-primary m-1"
        ><i class="fa fa-download" /></button
      >

      <table id="datatablesSimple">
        <thead>
          <tr>
            <th>ID</th>
            <th>No Ahli</th>
            <th>Nama</th>
            <th>No IC</th>
            <th>Kariah</th>
            <th>Telefon</th>
            <th>Status</th>
            <th>Kemaskini</th>
            <th>Tunggakan</th>
          </tr>
        </thead>
        <!-- <tbody>
          {#if senaraiahli}
            {#each senaraiahli as key, i}
              <tr>
                <td>{i + 1}</td>
                <td>{key.ID}</td>
                <td>{key.display_name}</td>
                <td>{key.icno}</td>
                <td>{key.kariah_name}</td>
                <td>{key.telno}</td>
                <td>{key.status == 1 ? "Aktif" : ""}</td>
                <td>
                  <button
                    on:click={() => editahli()}
                    class="btn btn-primary btn-sm"
                    ><i class="fa fa-pencil" /></button
                  >
                  <button
                    on:click={() => deleteahli()}
                    class="btn btn-danger btn-sm"
                    ><i class="fa fa-trash" /></button
                  >
                </td>
                <td>
                  <button
                    on:click={() => csvdownload()}
                    class="btn btn-warning btn-sm"
                    disabled><i class="fa fa-exclamation-triangle" /></button
                  >
                </td>
              </tr>
            {/each}
          {/if}
        </tbody> -->
        <tfoot>
          <tr>
            <th>ID</th>
            <th>No Ahli</th>
            <th>Nama</th>
            <th>No IC</th>
            <th>Kariah</th>
            <th>Telefon</th>
            <th>Status</th>
            <th>Kemaskini</th>
            <th>Tunggakan</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
