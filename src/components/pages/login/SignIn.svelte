<script>
  import { navigate } from 'svelte-routing';
  import { Modal } from 'bootstrap';
  import { onMount } from 'svelte';
  import queryString from 'query-string';
  export let location;
  // variables
  let message = '';
  let messageColor = '';
  let queryParams;
  const enterpiseData = ENTERPRISE_DATA;
  let modal;
  let disabled = true;
  let termsChecked = false;
  // functions
  $: queryParams = queryString.parse(window.location.search);
  const termsAndContiditions = () => {
    const myModal = document.getElementById('termsAndConditionsModal');
    modal = new Modal(myModal);
    modal.show();
  };
  const closeModal = () => {
    modal.hide();
  };
  onMount(() => {
		// console.log('index');  
    // console.log(CSRF);
    // console.log(queryParams);
    if(queryParams.error == 'csrf-mismatch'){
      message = 'Error de autenticación CSRF';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'fill-all'){
      message = 'Debe de llenar todos los campos';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'email-invalid'){
      message = 'Debe ingresar un correo válido';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'passwords-mismatch'){
      message = 'Contraseñas no coinciden';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'not-a-member-email'){
      message = 'Correo no pertence a una membresía';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'email-with-member'){
      message = 'Correo ya pertenece a una cuenta de usuario';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.success == 'activate-account'){
      message = 'Correo de confirmación enviado';
      messageColor = 'text-success';
      disabled = false;
      termsChecked = true;
    }else if(queryParams.error == 'user-named-used'){
      message = 'Nombre de usuario ya en uso';
      messageColor = 'text-danger';
      disabled = false;
      termsChecked = true;
    }else{
      message = '';
      messageColor = '';
    }
	});
</script>

<svelte:head>
	<title>Nueva Cuenta</title>
</svelte:head>

<main class="form-signin w-100 m-auto text-center">
  <form action="/sign_in" method="post">
    <img class="mb-4" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Nueva Cuenta</h1>
    <div class="form-floating">
      <input type="text" name="user" class="form-control" id="txtUser" placeholder="Usuario" disabled={disabled} required>
      <label for="txtUser">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="text" name="email" class="form-control" id="txtEmail" placeholder="Correo Electrónico" disabled={disabled} required>
      <label for="txtEmail">Correo Electrónico</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="txtPassord" placeholder="Contraseña" disabled={disabled} required>
      <label for="txtPassord">Contraseña</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password2" class="form-control" id="txtPassord2" placeholder="Repita Contraseña" disabled={disabled} required>
      <label for="txtPassord2">Repetir Contraseña</label>
    </div>
    <div class="checkbox mt-2">
      <label class="cb-label">
        <input type="checkbox" bind:checked={termsChecked} data-target="#my-dropdown" on:click|preventDefault="{termsAndContiditions}"> Terminos y Condiciones
      </label>
    </div>
    <p class="message {messageColor}" style="margin-top:10px;" id="message">{message}</p>
    <button class="w-100 btn btn-lg btn-primary mt-2" type="submit" disabled={disabled}>Crear</button>
    <div class="row mt-3 links">
      <div class="col-md-6">
        <a href="/login" on:click|preventDefault={() => {navigate('/login')}} class="text-right">Ingresar al Sistema</a>
      </div>
      <div class="col-md-6">
        <a href="/login/reset_password" on:click|preventDefault={() => {navigate('/login/reset_password')}} class="text-right">Recuperar Contraseña</a>
      </div>
    </div>
    <p class="mt-5 mb-3 text-body-secondary">Powered By <a href="http://softweb.pe/"> Softtware Web Perú</a>© 2011–2023</p>
  </form>
</main>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="termsAndConditionsModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Términos y Condiciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" on:click={() =>{closeModal();}}>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Introducción</h2>
        <p>Estos términos y condiciones se aplican al uso del sitio web y los servicios ofrecidos por <b>{enterpiseData.enterprise_name}</b>. Al acceder a este sitio web y utilizar los servicios, usted acepta estar sujeto a estos términos y condiciones.</p>
        
        <h2>Uso del sitio web</h2>
        <p>El uso de este sitio web está sujeto a las siguientes restricciones:</p>
        <ul>
          <li>No utilizar el sitio web para fines ilegales o no autorizados.</li>
          <li>No interferir con el funcionamiento normal del sitio web.</li>
          <li>No intentar acceder a información o datos que no están destinados al acceso público.</li>
        </ul>
        
        <h2>Propiedad intelectual</h2>
        <p>Todos los contenidos y materiales en este sitio web, incluyendo pero no limitado a, textos, gráficos, imágenes, diseños, iconos, software y códigos, son propiedad de <b>{enterpiseData.enterprise_name}</b> y están protegidos por las leyes de propiedad intelectual aplicables.</p>
        
        <h2>Limitación de responsabilidad</h2>
        <p>En la medida permitida por la ley, <b>{enterpiseData.enterprise_name}</b> no será responsable por daños directos, indirectos, incidentales, especiales o consecuentes que surjan del uso o la imposibilidad de usar el sitio web o los servicios ofrecidos en él.</p>
        
        <h2>Modificaciones</h2>
        <p><b>{enterpiseData.enterprise_name}</b> se reserva el derecho de modificar estos términos y condiciones en cualquier momento y sin previo aviso. Al continuar utilizando el sitio web y los servicios después de que se hayan realizado modificaciones, usted acepta estar sujeto a los términos y condiciones actualizados.</p>
        
        <h2>Disposiciones generales</h2>
        <p>Estos términos y condiciones constituyen el acuerdo completo entre <b>{enterpiseData.enterprise_name}</b> y usted en relación con el uso del sitio web y los servicios ofrecidos. Si alguna disposición de estos términos y condiciones se considera inválida o inaplicable, esa disposición se interpretará de manera consistente con la ley aplicable para reflejar, en la medida de lo posible, la intención original de las partes, y las demás disposiciones seguirán siendo válidas y aplicables.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" on:click={() =>{disabled=false; termsChecked = true; closeModal();}}><i class="fa fa-check" aria-hidden="true"></i>Aceptar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" on:click={() =>{disabled=true; termsChecked = false; closeModal();}}><i class="fa fa-times" aria-hidden="true"></i>Declinar</button>
      </div>
    </div>
  </div>
</div>

<style>
  .close{
    background: transparent;
    border-color: transparent;
    font-size: 25px;
  }

  .modal-body h2 {
    font-size: 16px;
  }

  .modal-header{
    padding-top: 5px;
    padding-bottom: 5px;
  }
</style>