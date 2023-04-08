<script>
  import { onMount } from 'svelte';
  import DataTable from '../../widgets/DataTable.svelte';
  import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  const baseURL = BASE_URL;
  export let id;
  export let disabled = false;
  let disabledInCreate = true;
  let title = 'Gestión de Miembros';
  let alertMessage = null;
  let memberDataTable;
  let alertMessageProps = {};

  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    memberDataTable.list();
  });  
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
    <div class="col-md-12">
      <DataTable bind:this={memberDataTable} 
				urlServices={{ 
					list: `${baseURL}admin/member/list`, 
					save: `${baseURL}admin/member/delete` 
				}}
				buttonSave={true}
				buttonAddRecord={'/admin/member/add'}
        colspanFooter={8},
				rows={{
					id: {
						style: 'text-align:center;',
						type: 'id',
					},
					state_name:{
						type: 'td',
					},
          priority_name:{
						type: 'td',
					},
          branch_name:{
						type: 'td',
					},
          created:{
						type: 'td',
					},
          edited:{
						type: 'td',
					},
          worker_name:{
						type: 'td',
					},
          resume:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
              {
								type: 'link', 
								icon: 'fa fa-pencil', 
								style:'font-size:12px; margin-right:10px;',
								url: '/member/edit/',
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
						caption: 'Apellidos',
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
          step: 10,
        }}
			/>
    </div>
  </div>
</div>

<style>

</style>