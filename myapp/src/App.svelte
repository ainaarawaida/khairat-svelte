<script>
  import svelteLogo from "./assets/svelte.svg";
  import Counter from "./lib/Counter.svelte";

  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";

  let checkuser = new Promise(function (myResolve, myReject) {
    let url = `${mybaseurl}/wp-json/khai_check_login_user/v1/data/1`;

    fetch(url, {
      // Adding method type
      method: "GET",
      // Adding body or contents to send
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
    console.log("checkuser", await checkuser);
  })();

  let testing = new Promise(function (myResolve, myReject) {
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
</script>

<main>
  <div>
    <a href="https://vitejs.dev" target="_blank">
      <img src="/vite.svg" class="logo" alt="Vite Logo" />
    </a>
    <a href="https://svelte.dev" target="_blank">
      <img src={svelteLogo} class="logo svelte" alt="Svelte Logo" />
    </a>
  </div>
  <h1>Vite + Svelte</h1>

  <div class="card">
    <Counter />
  </div>

  <p>
    Check out <a href="https://github.com/sveltejs/kit#readme" target="_blank"
      >SvelteKit</a
    >, the official Svelte app framework powered by Vite!
  </p>

  <p class="read-the-docs">Click on the Vite and Svelte logos to learn more</p>
</main>

<style>
  .logo {
    height: 6em;
    padding: 1.5em;
    will-change: filter;
  }
  .logo:hover {
    filter: drop-shadow(0 0 2em #646cffaa);
  }
  .logo.svelte:hover {
    filter: drop-shadow(0 0 2em #ff3e00aa);
  }
  .read-the-docs {
    color: #888;
  }
</style>
