<script>
  import { onMount } from "svelte";
  import { createEventDispatcher } from "svelte";
  let dispatch = createEventDispatcher();
  export let fieldkariah;

  let fields = { kariah_name: "", alamat_kariah: "" };
  let errors = { all: [], kariah_name: "", alamat_kariah: "" };
  let valid = false;
  let submit = false;
  let apidata;

  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";
  let temp_site_page_url = "";

  const submitHandler = async () => {
    valid = true;
    let url = `${mybaseurl}/wp-json/api/v1/data`;
    let dataArray = new FormData();
    dataArray.append("action", "daftarkariah");
    dataArray.append("kariah_name", fields.kariah_name);
    dataArray.append("alamat_kariah", fields.alamat_kariah);
    dataArray.append("site_page_url", fields.site_page_url);

    apidata = new Promise(function (myResolve, myReject) {
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
          errors.all = JSON.parse(result).submitpost.error;
          temp_site_page_url = fields.site_page_url
            .replace(/\s+/g, "-")
            .toLowerCase();

          console.log("errors.all after submit", JSON.parse(result).submitpost);

          if (errors.all.length === 0) {
            fields.post_title = fields.kariah_name;
            fields.post_name = fields.site_page_url;
            console.log("submitkariah", fields);
            dispatch("submitkariah", fields);
          }

          console.log("post result", JSON.parse(result));
        })
        .catch((error) => console.log("error", error));
    });
  };

  const closealert = async () => {
    errors.all = [];
    submit = false;
  };

  onMount(async () => {
    console.log("fieldkariah[0]", fieldkariah);
    fields.kariah_name = fieldkariah[0].post_title;
    fields.alamat_kariah = fieldkariah[0].alamat_kariah;
    fields.site_page_url = fieldkariah[0].post_name;
    temp_site_page_url = fieldkariah[0].post_name;
  });

  $: console.log("errors.all", errors.all.length);
</script>

<div class="container-fluid px-4">
  <h1 class="mt-4">Daftar Kariah</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Daftar Kariah</li>
  </ol>
  {submit}
  <br />
  {errors.all}
  {#if submit === true}
    {#if errors.all.length > 0}
      {#each errors.all as cat}
        <div
          class="alert alert-danger alert-dismissible fade show"
          role="alert"
        >
          <strong>{cat}</strong>
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
          type="button"
          class="btn-close"
          data-bs-dismiss="alert"
          aria-label="Close"
          on:click={() => closealert()}
        />
      </div>
    {/if}
  {/if}

  <form
    class="woocommerce-EditAccountForm edit-account"
    on:submit|preventDefault={() => submitHandler()}
  >
    <p
      class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
    >
      <label for="kariah_name"
        >Nama Kariah&nbsp;<span class="required">*</span></label
      >
      <input
        type="text"
        class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.all.includes(
          'Nama Kariah telah wujud'
        )
          ? 'is-invalid'
          : ''}"
        name="kariah_name"
        id="kariah_name"
        bind:value={fields.kariah_name}
        required
      />
    </p>
    <div class="clear" />

    <p
      class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
    >
      <label for="alamat_kariah"
        >Alamat Kariah&nbsp;<span class="required">*</span></label
      >
      <textarea
        class="form-control woocommerce-Input form-control"
        id="alamat_kariah"
        name="alamat_kariah"
        rows="4"
        cols="50"
        required
        bind:value={fields.alamat_kariah}
      />
    </p>
    <div class="clear" />

    <p
      class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
    >
      <label for="site_page_url"
        >Site Page URL&nbsp;<span class="required">*</span></label
      >
      <input
        type="text"
        class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.all.includes(
          'Site URL telah wujud'
        )
          ? 'is-invalid'
          : ''}"
        name="site_page_url"
        id="site_page_url"
        bind:value={fields.site_page_url}
        required
      />
      <span
        ><em
          >{mybaseurl}/{temp_site_page_url == ""
            ? "[Your_Site_Page_URL]"
            : temp_site_page_url}</em
        ></span
      >
    </p>
    <div class="clear" />

    <p>
      <button
        type="submit"
        class="btn btn-primary"
        name="submit_site_details"
        value="Save changes">Save changes</button
      >
      <input type="hidden" name="action" value="save_site_details" />
    </p>
  </form>
</div>
