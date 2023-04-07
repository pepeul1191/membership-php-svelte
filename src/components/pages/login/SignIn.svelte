<script>
  import { navigate } from 'svelte-routing';
</script>

<svelte:head>
	<title>Nueva Cuenta</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form>
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Nueva Cuenta</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="txtUser" placeholder="demo">
      <label for="txtUser">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" id="txtEmail" placeholder="demo">
      <label for="txtEmail">Correo Electrónico</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="txtPassord" placeholder="Password">
      <label for="txtPassord">Contraseña</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="txtPassord2" placeholder="Password">
      <label for="txtPassord2">Repetir Contraseña</label>
    </div>
    <div class="checkbox mt-2">
      <label>
        <input type="checkbox" value="remember-me"> Terminos y Condiciones
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Crear</button>
    <div class="row mt-3 links">
      <div class="col-md-6">
        <a href="/login" on:click|preventDefault={() => {navigate('/login')}} class="text-right">Ingresar al Sistema</a>
      </div>
      <div class="col-md-6">
        <a href="/login/reset-password" on:click|preventDefault={() => {navigate('/login/reset-password')}} class="text-right">Recuperar Contraseña</a>
      </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary">© 2017–2023</p>
  </form>
</main>

<style>

</style>