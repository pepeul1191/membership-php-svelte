<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	const base_url = BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let objetiveDataTable;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    objetiveDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Niveles de los Objetivos de Rutinas</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Lista de Niveles de los Objetivos de Rutinas</h2>
		</div>
		<div class="col-md-5">
			<DataTable bind:this={objetiveDataTable} 
				urlServices={{ 
					list: `${base_url}admin/objective/list`, 
					save: `${base_url}admin/objective/save` 
				}}
				buttonAddRow={true},
				buttonSave={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					name:{
						type: 'input[text]',
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
						caption: 'Nombre',
					},
					{
						caption: 'Operaciones',
						style:'text-align: center;',
					},]}
					messages={{
						notChanges: 'No ha ejecutado cambios en la tabla de nivles de los objetivos de Rutinas',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de nivles de los objetivos de Rutinas',
						list500: 'Ocurrió un error en listar los elementos de la tabla de nivles de los objetivos de Rutinas',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de nivles de los objetivos de Rutinas',
						save500: 'Ocurrió un error para guardar los cambios de la tabla de nivles de los objetivos de Rutinas',
						save200: 'Se han actualizado los registros de la tabla de nivles de los objetivos de Rutinas',
					}}
			/>
		</div>
	</div>
</div>

<style>

</style>