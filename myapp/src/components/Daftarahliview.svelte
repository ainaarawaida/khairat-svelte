<script>
  import { onMount } from "svelte";
  import { createEventDispatcher } from "svelte";
  let dispatch = createEventDispatcher();
  export let fields = {
    display_name: "",
    user_email: "",
    kata_laluan: "",
    kata_laluan_r: "",
    user_registered_x: "",
    no_ahli: "",
    jenis_ahli: "",
    jenis_ahli_x: "",
  };

  let submit = false;
  let errors = [];

  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";
  let temp_site_page_url = "";

  const submitHandler = async (e) => {
    // console.log("form e", e.target);
    // console.log("form e", e.target[0].value);
    errors = [];

    if (fields.kata_laluan !== fields.kata_laluan_r) {
      errors.push({
        key: "kata_laluan",
        text: "Kata Laluan Ulangan tidak sama",
      });
    }

    console.log("errors", errors);

    console.log(errors.some((d) => d.key.includes("kata_laluan")));

    if (errors.length > 0) {
      submit = true;
      return;
    }
    if (errors.length === 0) {
      let url = `${mybaseurl}/wp-json/api/v1/data`;
      let dataArray = new FormData();
      dataArray.append("action", "pendaftaranAhli");
      dataArray.append("display_name", fields.display_name);
      dataArray.append("user_email", fields.user_email);
      dataArray.append("user_pass", fields.kata_laluan);
      dataArray.append("icno", fields.icno);
      dataArray.append("telno", fields.telno);

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

            console.log("errors after submit", errors);

            if (errors.length === 0) {
              dispatch("submitprofil", fields);
            }

            // console.log("post result", JSON.parse(result));
          })
          .catch((error) => console.log("error", error));
      });
    }
  };

  const closealert = async () => {
    errors = [];
    submit = false;
  };

  onMount(async () => {
    console.log("field", fields);
    // console.log("field", fields.user_registered);
    let year = new Date().toISOString().substring(0, 4);
    let month = new Date().toISOString().substring(5, 7);
    let day = new Date().toISOString().substring(8, 10);
    fields.user_registered_x = [year, month, day].join("-");
    fields.kariah_name = fields[0].post_title;
    fields.kata_laluan = "";
    fields.kata_laluan_r = "";
    // fields.no_ahli = `000${fields.ID}`;
    // if (fields.jenis_ahli == "1") {
    //   fields.jenis_ahli_x = "Pentadbir";
    // } else if (fields.jenis_ahli == "2") {
    //   fields.jenis_ahli_x = "Ahli";
    // }
  });
</script>

<div class="container-fluid px-4">
  <h3 class="mt-4">Pendaftaran Ahli</h3>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Maklumat Peribadi Ahli</li>
  </ol>

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
    on:submit|preventDefault={(e) => submitHandler(e)}
  >
    <p
      class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
    >
      <label for="display_name">Nama Penuh<span class="required">*</span></label
      >
      <input
        type="text"
        class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.includes(
          'Nama Kariah telah wujud'
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
        class="woocommerce-Input woocommerce-Input--text input-text form-control {errors.includes(
          'Nama Kariah telah wujud'
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
          <label for="user_registered"
            >Tarikh Daftar<span class="required">*</span>
          </label>
          <input
            readonly
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
            >Jenis Ahli<span class="required">*</span>
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
