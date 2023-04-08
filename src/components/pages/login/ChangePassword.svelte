<script>
  import { onMount } from 'svelte';
  import queryString from 'query-string';
  import { checkUserIdResetKey } from '../../../services/UserService';
  export let location;
  export let userId;
  export let resetKey;
  // variables
  let message = '';
  let messageColor = '';
  let queryParams;
  let disabled = false;
  $: queryParams = queryString.parse(location.search);
  // functions
  onMount(async () => {
		// console.log('index');  
    // check userId and key 
    await checkUserIdResetKey(userId, resetKey);
    if(queryParams.error == 'csrf-mismatch'){
      message = 'Error de autenticación CSRF';
      messageColor = 'text-danger';
      disabled = false;
    }else if(queryParams.error == 'user-id-reset-key-mismatch'){
      message = 'No coincide las crendenciales para cambiar la contraseña';
      disabled = true;
      messageColor = 'text-danger';
    }else if(queryParams.error == 'passwords-mismatch'){
      message = 'Contraseñas no coinciden';
      messageColor = 'text-danger';
      disabled = false;
    }else{
      message = '';
      messageColor = '';
    }
	});
</script>

<svelte:head>
	<title>Restablecer Contraseña</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form action="/change_password" method="post">
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Restablecer Contraseña</h1>
    <div class="form-floating">
      <input type="hidden" name="user_id" value={userId}>
      <input type="hidden" name="reset_key" value={resetKey}>
      <input type="password" name="password" disabled={disabled} class="form-control" id="txtPassord" placeholder="Contraseña" required>
      <label for="txtPassord">Contraseña</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password2" disabled={disabled} class="form-control" id="txtPassord2" placeholder="Repita Contraseña" required>
      <label for="txtPassord2">Repetir Contraseña</label>
    </div>
    <p class="message {messageColor}" style="margin-top:10px; margin-bottom: 0px;" id="message">{message}</p>
    <button class="w-100 btn btn-lg btn-primary mt-2" disabled={disabled} type="submit">Cambiar Contraseña</button>
    <p class="mt-5 mb-3 text-body-secondary">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a>© 2011–2023</p>
  </form>
</main>

<style>
</style>