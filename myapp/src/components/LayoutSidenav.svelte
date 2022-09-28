<script>
  export let detailuser;
  import { createEventDispatcher } from "svelte";
  let dispatch = createEventDispatcher();
  export let activeItem;
  export let stage_daftar;

  $: console.log("stage_daftar", stage_daftar);
</script>

<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
      <div class="nav">
        <div class="sb-sidenav-menu-heading">e-Khairat</div>

        {#if stage_daftar == 0}
          <div
            role="button"
            class="nav-link {activeItem == 'Daftarkariahview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Daftarkariahview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Daftar Kariah
          </div>
        {:else if stage_daftar == 1}
          <div
            role="button"
            class="nav-link {activeItem == 'Daftarkariahview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Daftarkariahview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Daftar Kariah
          </div>
          <div
            role="button"
            class="nav-link {activeItem == 'Dashboardview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Dashboardview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Dashboard
          </div>

          <div
            role="button"
            class="nav-link {activeItem == 'Senaraiahliview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Senaraiahliview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Senarai Ahli
          </div>

          <div
            role="button"
            class="nav-link {activeItem == 'Senaraitanggunganview'
              ? 'active'
              : ''}"
            on:click={() => dispatch("tabChange", "Senaraitanggunganview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Senarai Tanggungan
          </div>

          <div
            role="button"
            class="nav-link {activeItem == 'Penerimakhairatview'
              ? 'active'
              : ''}"
            on:click={() => dispatch("tabChange", "Penerimakhairatview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Penerima Khairat
          </div>

          <div
            role="button"
            class="nav-link {activeItem == 'Rekodbayaranview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Rekodbayaranview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Rekod Bayaran
          </div>

          <div
            role="button"
            class="nav-link {activeItem == 'Laporanview' ? 'active' : ''}"
            on:click={() => dispatch("tabChange", "Laporanview")}
          >
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Laporan
          </div>

          <div class="sb-sidenav-menu-heading">Konfigurasi</div>
          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Info Sistem
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Tetapan Zon
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Pengumuman
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Jenis Yuran
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Kadar Yuran
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            FPX Payment Gateway
          </div>

          <div role="button" class="nav-link">
            <div class="sb-nav-link-icon">
              <i class="fas fa-tachometer-alt" />
            </div>
            Log Akses
          </div>
        {:else}{/if}
      </div>
    </div>
    <div class="sb-sidenav-footer">
      <div class="small">Logged in as:</div>
      {detailuser}
    </div>
  </nav>
</div>
