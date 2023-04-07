<script>
</script>

<svelte:head>
	<title>Bienvenido al Sistema</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form>
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Bienvenido</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="txtUser" placeholder="demo">
      <label for="txtUser">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="txtPassord" placeholder="Password">
      <label for="txtPassord">Contraseña</label>
    </div>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
    <p class="mt-5 mb-3 text-body-secondary">© 2017–2023</p>
  </form>
</main>

<style>

</style>