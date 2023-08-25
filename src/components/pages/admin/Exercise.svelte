<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	import InputText from '../../widgets/InputText.svelte';
	import InputSelect from '../../widgets/InputSelect.svelte';
	const baseURL= BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let exerciseDataTable;
	let disabled = false;
  // search form
	let inputName; 
  let bodyPartId; let bodyPart = ''; let inputBodyPart;

  onMount(async() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
		// select
    inputBodyPart.list();
		// table
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

	const search = () => {
    // run validations
    exerciseDataTable.queryParams = {
      name: inputName,
      body_part_id: bodyPartId,
    };
    exerciseDataTable.list();
  }
  
  const clean = () => {
    inputName = '';
    bodyPartId = '';
    exerciseDataTable.queryParams = {
    };
    exerciseDataTable.list();
  };
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
		<div class="row mb-3">
      <div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<InputText 
							label={'Nombre'}
							bind:value={inputName}
							placeholder={'Ingrese el nombre de un ejercicio'} 
						/>
					</div> 
					<div class="col-md-6">
						<InputSelect 
							label={'Parte del Cuerpo'}
							bind:value={bodyPart}
							placeholder={'Nombre de la parte del cuerpo'} 
							disabled={disabled}
							url={`${baseURL}admin/body_part/list`}
							validations={[
							]}
							key = {{ id: 'id', name: 'name'}}
							bind:selectedValue={bodyPartId}
							bind:this={inputBodyPart}
						/>
					</div>
				</div>
      </div> 
      <div class="col-md-4" style="padding-top:27px;">
        <button class="btn btn-warning" on:click="{clean}"><i class="fa fa-eraser" aria-hidden="true"></i>
          Limpiar</button>
        <button class="btn btn-success" on:click="{search}"><i class="fa fa-search" aria-hidden="true"></i>
          Buscar Ejercicios</button>
      </div>
    </div>
    <hr>
		<div class="col-md-12">
			<DataTable bind:this={exerciseDataTable} 
				urlServices={{ 
					list: `${baseURL}admin/exercise/list`, 
					save: `${baseURL}admin/exercise/save` 
				}}
				buttonAddRow={true},
				buttonSave={true},
				colspanFooter=5,
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
            tableKeyURL: 'image_url',
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
						caption: 'Imágen',
						style:'text-align: center;',
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