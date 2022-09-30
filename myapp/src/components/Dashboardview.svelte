<script>
  import { onMount } from "svelte";

  onMount(async () => {
    const datatablesSimple2 = document.getElementById("datatablesSimple2");
    if (datatablesSimple2) {
      new simpleDatatables.DataTable(datatablesSimple2);
    }
  });
</script>

<div class="container-fluid px-4">
  <h1 class="mt-4">Dashboard</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h4><b>110</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col"><h6>Jumlah Bayaran (RM)</h6></div>
          </div>
          <div class="row">
            <div class="col small">Bayaran selesai</div>
          </div>
        </div>

        <div
          class="card-footer d-flex align-items-center justify-content-between"
        >
          <a class="small text-white stretched-link" href="#">Lihat Perincian</a
          >
          <div class="small text-white">
            <i class="fas fa-angle-right" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-warning text-white mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h4><b>110</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col"><h6>Jumlah Bayaran (RM)</h6></div>
          </div>
          <div class="row">
            <div class="col small">Bayaran selesai</div>
          </div>
        </div>
        <div
          class="card-footer d-flex align-items-center justify-content-between"
        >
          <a class="small text-white stretched-link" href="#">Lihat Perincian</a
          >
          <div class="small text-white">
            <i class="fas fa-angle-right" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success text-white mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h4><b>110</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col"><h6>Jumlah Bayaran (RM)</h6></div>
          </div>
          <div class="row">
            <div class="col small">Bayaran selesai</div>
          </div>
        </div>
        <div
          class="card-footer d-flex align-items-center justify-content-between"
        >
          <a class="small text-white stretched-link" href="#">Lihat Perincian</a
          >
          <div class="small text-white">
            <i class="fas fa-angle-right" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-danger text-white mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <h4><b>110</b></h4>
            </div>
          </div>
          <div class="row">
            <div class="col"><h6>Jumlah Bayaran (RM)</h6></div>
          </div>
          <div class="row">
            <div class="col small">Bayaran selesai</div>
          </div>
        </div>
        <div
          class="card-footer d-flex align-items-center justify-content-between"
        >
          <a class="small text-white stretched-link" href="#">Lihat Perincian</a
          >
          <div class="small text-white">
            <i class="fas fa-angle-right" />
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row alert alert-warning alert-dismissable">
    <div class="col">
      Setiap pendaftaran permohonan ahli melalui sistem akan disenaraikan di
      ruangan ini untuk diluluskan/ditolak oleh Pentadbir sistem.
    </div>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="alert"
      aria-label="Close"
    />
  </div>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table me-1" />
      Pendaftaran Online
    </div>
    <div class="card-body">
      <table id="datatablesSimple2">
        <thead>
          <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Age</th>
            <th>Start date</th>
            <th>Salary</th>
          </tr>
        </tfoot>
        <tbody>
          <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011/04/25</td>
            <td>$320,800</td>
          </tr>
          <tr>
            <td>Garrett Winters</td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>63</td>
            <td>2011/07/25</td>
            <td>$170,750</td>
          </tr>

          <tr>
            <td>Michael Bruce</td>
            <td>Javascript Developer</td>
            <td>Singapore</td>
            <td>29</td>
            <td>2011/06/27</td>
            <td>$183,000</td>
          </tr>
          <tr>
            <td>Donna Snider</td>
            <td>Customer Support</td>
            <td>New York</td>
            <td>27</td>
            <td>2011/01/25</td>
            <td>$112,000</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
