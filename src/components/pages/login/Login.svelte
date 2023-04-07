<script>
  import { navigate } from 'svelte-routing';
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
    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Ingresar</button>
    <button class="w-100 btn mt-1 btn-lg btn-success" type="submit">Ingresar con Google</button>
    <div class="row mt-3 links">
      <div class="col-md-5">
        <a href="/login/sign-in" on:click|preventDefault={() => {navigate('/login/sign-in')}} class="text-left">Crear Cuenta</a>
      </div>
      <div class="col-md-7">
        <a href="/login/reset-password" on:click|preventDefault={() => {navigate('/login/reset-password')}} class="text-right">Recuperar Contraseña</a>
      </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary">© 2017–2023</p>
  </form>
</main>

<style>

</style>