<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	const base_url = BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let levelDataTable;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    levelDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Niveles de los Paquetes de Ejercicios</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Lista de Niveles de los Paquetes de Ejercicios</h2>
		</div>
		<div class="col-md-5">
			<DataTable bind:this={levelDataTable} 
				urlServices={{ 
					list: `${base_url}admin/level/list`, 
					save: `${base_url}admin/level/save` 
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
						notChanges: 'No ha ejecutado cambios en la tabla de nivles de los paquetes de ejercicios',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de nivles de los paquetes de ejercicios',
						list500: 'Ocurrió un error en listar los elementos de la tabla de nivles de los paquetes de ejercicios',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de nivles de los paquetes de ejercicios',
						save500: 'Ocurrió un error para guardar los cambios de la tabla de nivles de los paquetes de ejercicios',
						save200: 'Se han actualizado los registros de la tabla de nivles de los paquetes de ejercicios',
					}}
			/>
		</div>
	</div>
</div>

<style>

</style>