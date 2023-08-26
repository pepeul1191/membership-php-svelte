<script>
  import { navigate } from 'svelte-routing';
  import queryString from 'query-string';
  import { onMount } from 'svelte';
  export let location;
  // variables
  let message = '';
  let messageColor = '';
  let queryParams;
  // functions
  $: queryParams = queryString.parse(window.location.search);
  onMount(() => {
		// console.log('index');  
    // console.log(CSRF);
    console.log(queryParams);
    if(queryParams.error == 'csrf-mismatch'){
      message = 'Error de autenticación CSRF';
      messageColor = 'text-danger';
    }else if(queryParams.success == 'activate-account'){
      message = 'Correo de confirmación enviado';
      messageColor = 'text-success';
    }else if(queryParams.success == 'reset-key'){
      message = 'Correo para restablecer contraseña enviado';
      messageColor = 'text-success';
    }else if(queryParams.error == 'not-a-member-email'){
      message = 'Correo no pertence a una membresía';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.success == 'change-password'){
      message = 'Contraseña actualizada';
      messageColor = 'text-success';
    }else if(queryParams.error == 'user-pass-mismatch'){
      message = 'Usuario y/o contraseñas incorrectas';
      messageColor = 'text-danger';
    }else{
      message = '';
      messageColor = '';
    }
	});
</script>

<svelte:head>
	<title>Bienvenido al Sistema</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form action="/login" method="post">
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Bienvenido</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="txtUser" placeholder="demo" name="user" required>
      <label for="txtUser">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" id="txtPassord" placeholder="Password" required>
      <label for="txtPassord">Contraseña</label>
    </div>
    <p class="message {messageColor}" style="margin-top:10px; margin-bottom: 0px;" id="message">{message}</p>
    <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Ingresar</button>
    <button class="w-100 btn mt-1 btn-lg btn-success" type="submit"><i class="fa fa-google" aria-hidden="true"></i>
Ingresar con Google</button>
    <div class="row mt-3 links">
      <div class="col-md-5">
        <a href="/login/sign_in" on:click|preventDefault={() => {navigate('/login/sign_in')}} class="text-left">Crear Cuenta</a>
      </div>
      <div class="col-md-7">
        <a href="/login/reset_password" on:click|preventDefault={() => {navigate('/login/reset_password')}} class="text-right">Recuperar Contraseña</a>
      </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a>© 2011–2023</p>
  </form>
</main>

<style>

</style>