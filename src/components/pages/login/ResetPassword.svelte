<script>
  import { navigate } from 'svelte-routing';
</script>

<svelte:head>
	<title>Restablecer Contraseña</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form>
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Restablecer Contraseña</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="txtEmail" placeholder="demo">
      <label for="txtEmail">Correo electrónico</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Enviar Correo</button>
    <div class="row mt-3 links">
      <div class="col-md-6">
        <a href="/login" on:click|preventDefault={() => {navigate('/login')}} class="text-right">Ingresar al Sistema</a>
      </div>
      <div class="col-md-6">
        <a href="/login/sign_in" on:click|preventDefault={() => {navigate('/login/sign_in')}} class="text-left">Crear Cuenta</a>
      </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a>© 2011–2023</p>
  </form>
</main>

<style>

</style>