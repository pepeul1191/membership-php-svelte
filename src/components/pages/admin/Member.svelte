<script>
  import { onMount } from 'svelte';
  import DataTable from '../../widgets/DataTable.svelte';
  import InputText from '../../widgets/InputText.svelte';
  import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  const baseURL = BASE_URL;
  export let id;
  export let disabled = false;
  let disabledInCreate = true;
  let title = 'Gestión de Miembros';
  let alertMessage = null;
  let memberDataTable;
  let alertMessageProps = {};
  let inputName = '';
  let inputEmail = '';
  let inputCode = '';

  onMount(async () => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    await memberDataTable.getSelect({
      rowKey: 'discipline_id', 
      respond: {
        key: 'id',
        value: 'name',
      }, 
      url: `${baseURL}admin/discipline/list`,
    });
    memberDataTable.list();
  });
  const search = () => {
    // run validations
    memberDataTable.queryParams = {
      name: inputName,
      email: inputEmail,
      code: inputCode
    };
    memberDataTable.list();
  }
  
  const clean = () => {
    inputName = '';
    inputEmail = '';
    inputCode = '';
    memberDataTable.queryParams = {
      name: inputName,
      email: inputEmail,
      code: inputCode
    };
    memberDataTable.list();
  };
</script>

<svelte:head>
	<title>{title}</title>
</svelte:head>

<div class="container">
	<div class="row">
		<div class="col-lg-12 page-header">
			<h2>{title}</h2>
		</div>
  </div>
  <div class="row">
    <svelte:component this={alertMessage} {...alertMessageProps} />
    <div class="row mb-3">
      <div class="col-md-2">
        <InputText 
          label={'Código'}
          bind:value={inputCode}
          placeholder={'Ingrese el código de miembro'} 
        />
      </div> 
      <div class="col-md-3">
        <InputText 
          label={'Nombre'}
          bind:value={inputName}
          placeholder={'Ingrese el nombre de miembro'} 
        />
      </div> 
      <div class="col-md-3">
        <InputText 
          label={'Correo'}
          bind:value={inputEmail}
          placeholder={'Ingrese el correo de miembro'} 
        />
      </div> 
      <div class="col-md-4" style="padding-top:27px;">
        <button class="btn btn-warning" on:click="{clean}"><i class="fa fa-eraser" aria-hidden="true"></i>
          Limpiar</button>
        <button class="btn btn-success" on:click="{search}"><i class="fa fa-search" aria-hidden="true"></i>
          Buscar Miembros</button>
      </div>
    </div>
    <hr>
    <div class="col-md-12">
      <DataTable bind:this={memberDataTable} 
				urlServices={{ 
					list: `${baseURL}admin/member/list`, 
					save: `${baseURL}admin/member/save` 
				}}
				buttonSave={true}
				buttonAddRow={true}
        colspanFooter={8},
				rows={{
					id: {
						style: 'text-align:center; display:none;',
						type: 'id',
					},
					code:{
						type: 'input[text]',
            style: 'width:100px;',
					},
          last_names:{
						type: 'input[text]',
            style: 'width:200px;',
					},
          names:{
						type: 'input[text]',
            style: 'width:150px;',
					},
          email:{
						type: 'input[text]',
            style: 'width:200px;',
					},
          phone:{
						type: 'input[text]',
            style: 'width:130px;',
					},
          medical_obs:{
						type: 'input[text]',
            style: 'width:220px;',
					},
          discipline_id:{
						type: 'input[select]',
            style: 'width:130px;',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-bullseye', 
								style:'font-size:12px; margin-right:1px;',
								url: '/admin/member/objective/',
                key: 'id',
							},
              {
								type: 'link', 
								icon: 'fa fa-user', 
								style:'font-size:12px; margin-right:1px;',
								url: '/admin/member/user/',
                key: 'id',
							},
              {
								type: 'link', 
								icon: 'fa fa-bookmark', 
								style:'font-size:12px; margin-right:7px;',
								url: '/admin/member/membership/',
                key: 'id',
							},
							{
								type: 'delete',
							},
						],
						style: 'text-align:center;'
					},
				}}
				headers={[
					{
						caption: 'Código',
					},
					{
						caption: 'Apellidos ',
					},
          {
						caption: 'Nombres',
					},
          {
						caption: 'Correo',
					},
          {
						caption: 'Teléfono',
					},
          {
						caption: 'Observaciones Médicas',
					},
          {
						caption: 'Disciplina',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
        messages={{
          notChanges: 'No ha ejecutado cambios en la tabla de miembros',
          list404: 'Rercuso no encontrado para listar los elmentos de la tabla de miembros',
          list500: 'Ocurrió un error en listar los elementos de la tabla de miembros',
          save404: 'Rercuso no encontrado para guardar los cambios de la tabla de miembros',
          save500: 'Ocurrió un error para guardar los cambios de la table de miembros',
          save200: 'Se han actualizado los registros de la tabla de miembros',
        }}
        pagination={{
          step: 20,
        }}
			/>
    </div>
  </div>
</div>

<style>

</style>