<script>
  import svelteLogo from "./assets/svelte.svg";
  import Counter from "./lib/Counter.svelte";

  let mybaseurl =
    import.meta.env.MODE !== "development"
      ? window.location.origin
      : "http://khairat.test";

  let checkuser = new Promise(function (myResolve, myReject) {
    let url = `${mybaseurl}/wp-json/khai_check_login_user/v1/data`;

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


