<script>
  import { onMount } from 'svelte';
  import { getMemberUser, updateMemberUser, resetPasswordMemberUser } from '../../../services/UserMemberService.js';
  import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import AlertMessage from '../../widgets/AlertMessage.svelte';
  import InputText from '../../widgets/InputText.svelte';
  import InputPassword from '../../widgets/InputPassword.svelte';
  let baseURL = BASE_URL;
  let staticURL = STATIC_URL;
  let title = 'Gestión de Usuario del Miembro';
  let alertMessage = null;
  let alertMessageProps = {};
  let email = ''; let inputEmail; let emailValid = false;
  let user = ''; let inputUser = ''; let userValid = false;
  let password = ''; let inputPassword = ''; let passwordValid = false;
  let messageRandomPassword = '';
  let changePasswordPressed = false;
  // service header data
  let userId = null;
  export let id;
  export let disabled = false;

  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    loadDetail(id);
  });

  const launchAlert = (event, message, type) => {
    alertMessage = null;
    alertMessage = AlertMessage;
    alertMessageProps = {
      message: message,
      type: type,
      timeOut: 5000
    }
  };


  const loadDetail = (id) => {
    getMemberUser(id).then((resp) => {
      var data = resp.data;
      id = data.id;
      email = data.email;
      user = data.user;
      userId = data.user_id;
      password = data.password;
    }).catch((resp) =>  {
      console.log(resp)
    })
  };

  const saveMemberUser = () => {
    // run validations
    inputUser.validate();
    if(changePasswordPressed){
      inputPassword.validate();
    }else{
      inputPassword.valid = true;
    }
    // check if true
    if(passwordValid && userValid) {
      var params = {
        member_id: id,
        id: userId,
        user: user,
        password: password,
        email: email,
      };
      console.log(params)
      updateMemberUser(params).then((resp) => {
        var data = resp.data;
        if(data == ''){
          // edited
          launchAlert(null, 'Se ha editado el usuario del miembro del gimnasio', 'success');
        }else{
          // created
          userId = data;
          launchAlert(null, 'Se ha creado el usuario del miembro del gimnasio', 'success');
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso asosiar actualizar el usuario del miembro del gimnasio no existe en el servidor', 'danger');
        }else if(resp.status == 501){ 
          launchAlert(null, resp.data, 'danger');
        }else { 
          launchAlert(null, 'Ocurrió un error en asosiar el usuario del miembro del gimnasio', 'danger');
        }
      })
    }
  };

  const generatePassword = () => {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#$%()=¡[]*|@';
    var charactersLength = characters.length;
    for ( var i = 0; i < 10; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    messageRandomPassword = `Contraseña generada: <b style="color: #343434;font-weight: 900;">${result}</b>`;
    password = result;
    changePasswordPressed = true;
    setTimeout(() => {messageRandomPassword = ''}, 5000);
  };

  const sendResetMail = () => {
    resetPasswordMemberUser({user_id: userId}).then((resp) => {
      launchAlert(null, 'Se envió el correo una solicitud de cambio de contraseña.', 'success');
    }).catch((resp) =>  {
      console.log(resp)
      if(resp.status == 404){
        launchAlert(null, 'Recurso resetar contraseña por correo no existe', 'danger');
      }else if(resp.status == 501){ 
        launchAlert(null, resp.data, 'danger');
      }else { 
        launchAlert(null, 'Ocurrió un error en resetear la contraseña del usuario', 'danger');
      }
    })
  };
</script>

<svelte:head>
	<title>{title}</title>
</svelte:head>

<div class="container">
	<div class="row">
		<div class="col-lg-12 page-header">
			<h2>{title}</h2>
      <svelte:component this={alertMessage} {...alertMessageProps} />
		</div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <InputText 
        label={'Correo'}
        bind:value={email}
        placeholder={'Correo del miembro del gimnasio'} 
        disabled={true}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar el correo del miembro del gimnasio'},
          {type:'email'},
        ]}
        bind:valid={emailValid} 
        bind:this={inputEmail}
      />
    </div>
    <div class="col-md-3">
      <InputText 
        label={'Usuario'}
        bind:value={user}
        placeholder={'Usuario de miembro del gimnasio'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un nombre usuario'},
          {type:'maxLength', length: 45, message: 'Nombre máximo 45 letras'},
        ]}
        bind:valid={userValid} 
        bind:this={inputUser}
      />
    </div>
    <div class="col-md-3">
      <InputPassword 
        label={'Contraseña'}
        bind:value={password}
        placeholder={'Contraseña del usuario'} 
        disabled={true}
        validations={[{type:'notEmpty', message: 'Debe de Generar una Contraseña'},]}
        bind:this={inputPassword}
        bind:valid={passwordValid} 
      />
    </div>
  </div>
  <div class="row">
    <div class="col-md-9 pull-right">
      <button class="btn btn-success btn-actions" disabled="{disabled}" on:click="{saveMemberUser}"><i class="fa fa-check" aria-hidden="true"></i>
        Actualizar Datos de Usuario</button>
      <button class="btn btn-primary btn-actions" disabled="{disabled}" on:click="{sendResetMail}"><i class="fa fa-envelope-o" aria-hidden="true"></i>
        Enviar Correo de Cambio de Contraseña</button>
      <button class="btn btn-secondary btn-actions" disabled="{disabled}" on:click="{generatePassword}"><i class="fa fa-random" aria-hidden="true"></i>
        Generar Contraseña</button>
      <label class="btn-actions" style="margin-top: 20px;">{@html messageRandomPassword}</label>
    </div>
  </div> 
</div>

<style>
.btn-actions{
    float:right;
    margin-top:15px;
    margin-left: 10px;
  }
</style>