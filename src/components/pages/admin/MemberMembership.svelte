<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	import InputText from '../../widgets/InputText.svelte';
	import InputSelect from '../../widgets/InputSelect.svelte';
	const baseURL= BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let membershipMemberTable;
	let disabled = false;
  // search form
	export let memberId;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
		// table
    membershipMemberTable.queryParams = {member_id: memberId}
    membershipMemberTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Membresias del Miembro</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Historial de Membresias del Miembro</h2>
		</div>
		<div class="col-md-12">
			<DataTable bind:this={membershipMemberTable} 
				urlServices={{ 
					list: `${baseURL}admin/member/membership`, 
					save: `${baseURL}admin/member/membership` 
				}}
				buttonAddRow={true},
				buttonSave={true},
				colspanFooter=5,
        queryParams= {{
          member_id: memberId
        }}
        extraData= {{
          member_id: memberId
        }}
        extraReplace= {
          ['membership_state_name']
        }
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					beginning:{
						type: 'input[date]',
					},
          ending:{
						type: 'input[date]',
					},
          membership_state_name:{
						type: 'td',
					},
					actions:{
						type: 'actions',
						buttons: [
							{
								type: 'delete',
							},
						],
						style: 'text-align:center;'
					},
				}}
				headers={[
					{
						caption: 'codigo',
						style: 'display:none;',
					},
					{
						caption: 'Inicio (yyyy/mm/dd)',
					},
          {
						caption: 'Fin (yyyy/mm/dd)',
					},
          {
						caption: 'Estado',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de membresías.',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de membresías.',
						list500: 'Ocurrió un error en listar los elementos de la tabla de membresías.',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de membresías.',
						save500: 'Ocurrió un error para guardar los cambios de la tabla de membresías.',
						save200: 'Se han actualizado los registros de la tabla de membresías.',
					}}
			/>
		</div>
	</div>
</div>

<style>

</style>