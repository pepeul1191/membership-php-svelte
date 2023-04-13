<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	const base_url = BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let bodyPartDataTable;

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    bodyPartDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Partes del Cuerpo a Ejercitar</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Lista de Partes del Cuerpo a Ejercitar</h2>
		</div>
		<div class="col-md-5">
			<DataTable bind:this={bodyPartDataTable} 
				urlServices={{ 
					list: `${base_url}admin/body_part/list`, 
					save: `${base_url}admin/body_part/save` 
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
						notChanges: 'No ha ejecutado cambios en la tabla de partes del cuerpo a ejercitar',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de partes del cuerpo a ejercitar',
						list500: 'Ocurrió un error en listar los elementos de la tabla de partes del cuerpo a ejercitar',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de partes del cuerpo a ejercitar',
						save500: 'Ocurrió un error para guardar los cambios de la tabla de partes del cuerpo a ejercitar',
						save200: 'Se han actualizado los registros de la tabla de partes del cuerpo a ejercitar',
					}}
			/>
		</div>
	</div>
</div>

<style>

</style>