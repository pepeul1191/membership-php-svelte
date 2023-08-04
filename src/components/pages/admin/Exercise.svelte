<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	const baseURL= BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let exerciseDataTable;

  onMount(async() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    await exerciseDataTable.getSelect({
      rowKey: 'body_part_id', 
      respond: {
        key: 'id',
        value: 'name',
      }, 
      url: `${baseURL}admin/body_part/list`,
    });
    exerciseDataTable.list();
  });
</script>

<svelte:head>
	<title>Gestión de Ejercicios</title>
</svelte:head>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Lista de Ejercicios</h2>
		</div>
		<div class="col-md-12">
			<DataTable bind:this={exerciseDataTable} 
				urlServices={{ 
					list: `${baseURL}admin/exercise/list`, 
					save: `${baseURL}admin/exercise/save` 
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
          body_part_id:{
						type: 'input[select]',
            style: 'width:130px;',
					},
          video_url:{
						type: 'input[text]',
					},
          image_url:{
						type: 'upload',
            style: 'text-align: center',
            tableKeyURL: 'url',
            tableRecordKey: 'id',
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
						caption: 'Parte del Cuerpo',
					},
          {
						caption: 'Video URL',
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