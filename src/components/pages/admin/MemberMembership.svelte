<script>
  import { onMount } from 'svelte';
	import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import DataTable from '../../widgets/DataTable.svelte';
	import InputSelect from '../../widgets/InputSelect.svelte';
	const baseURL= BASE_URL;
  let alertMessage = null;
  let alertMessageProps = {};
  let membershipMemberTable;
	let packageMembershipTable;
	let packageExerciseTable;
	let disabled = false;
	let hidePackages = 'none';
	let bodyPartId; let bodyPart = ''; let inputBodyPart;
  // search form
	export let memberId;
	export let displayModal = 'none'

  onMount(() => {
    // console.log('index');
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
		// table
		console.log(packageMembershipTable)
    membershipMemberTable.queryParams = {member_id: memberId}
    membershipMemberTable.list();
		// select
    inputBodyPart.list();
		inputBodyPart.data.unshift({id: 'E', name: ''});
  });

	const loadPackages = (memberShip) => {
		hidePackages = 'block';
		packageMembershipTable.urlServices.list = `${baseURL}admin/membership/package?membership_id=${memberShip.id}`;
		packageMembershipTable.list();
		packageMembershipTable.extraData.membership_id = memberShip.id;
  };

	const loadExersices = (membershipPackage) => {
		var packageId = membershipPackage.id;
		displayModal = 'block';
		packageExerciseTable.urlServices.list = `${baseURL}admin/package/exercise?package_id=${packageId}`;
		packageExerciseTable.extraData.package_id = packageId;
		packageExerciseTable.list();
  };

	const deleteExercise = (exercise) => {
		var tmp = [];
		packageExerciseTable.data.forEach((record) =>{
			console.log(record)
			if(record.exercise_id == exercise.exercise_id){
				record.position = 0;
				record.reps = 0;
				record.sets = 0;
				// update observer
				let idKey = 'exercise_id'
				let rowKey = record.exercise_id;
				if(packageExerciseTable.observerSearch(idKey, rowKey, packageExerciseTable.observer.edit) == false){
        	packageExerciseTable.observer.edit.push({exercise_id: exercise.exercise_id})
      	}
			}
			tmp.push(record);
		})
		packageExerciseTable.data = tmp;
  };

	const closeModal = () => {
		displayModal = 'none';
  };

	document.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      displayModal = 'none';
    }
  });

	const search = () => {
		let packageId = packageExerciseTable.extraData.package_id;
		packageExerciseTable.urlServices.list = `${baseURL}admin/package/exercise?package_id=${packageId}&body_part_id=${bodyPartId}`;
		packageExerciseTable.list();
  }
  
  const clean = () => {
		let packageId = packageExerciseTable.extraData.package_id;
		packageExerciseTable.urlServices.list = `${baseURL}admin/package/exercise?package_id=${packageId}`;
		packageExerciseTable.list();
		inputBodyPart.selectedValue = 'E';
  };
</script>

<svelte:head>
	<title>Gestión de Membresias del Miembro</title>
</svelte:head>

	<!-- svelte-ignore a11y-click-events-have-key-events -->
	<div class="modal fade show" tabindex="-1" style="display: {displayModal};">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h3>Ejercicios del Paquete</h3>
					<button type="button" class="btn-close" on:click={closeModal}></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<svelte:component this={alertMessage} {...alertMessageProps} />
						<div class="row mb-12">
							<div class="col-md-4">
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
							<div class="col-md-8" style="padding-top:29px;">
								<button class="btn btn-warning" style="margin-right: 10px;" on:click="{clean}"><i class="fa fa-eraser" aria-hidden="true"></i>
									Limpiar y Mostrar Ejercicios del Paquete</button>
								<button class="btn btn-success" on:click="{search}"><i class="fa fa-search" aria-hidden="true"></i>
									Filtrar Ejercicios</button>
							</div>
						</div>
						<hr style="margin-top: 20px; margin-bottom: 20px;">
						<div class="col-md-12">
							<DataTable bind:this={packageExerciseTable} 
								urlServices={{ 
									list: `${baseURL}admin/package/exercise`, 
									save: `${baseURL}admin/package/exercise` 
								}}
								buttonSave={true},
								colspanFooter=6,
								rows={{
									exercise_id: {
										style: 'color: red; display:none;',
										type: 'id',
									},
									body_part_name:{
										type: 'td',
									},
									exercise:{
										type: 'td',
									},
									position:{
										type: 'input[text]',
										style: 'text-align: center;'
									},
									reps:{
										type: 'input[text]',
										style: 'text-align: center;'
									},
									sets:{
										type: 'input[text]',
										style: 'text-align: center;'
									},
									actions:{
										type: 'actions',
										buttons: [
											{
												type: 'custom', 
												icon: 'fa fa-times', 
												style:'font-size:12px; margin-right:8px;',
												key: 'id',
												customFunction: deleteExercise,
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
										caption: 'Parte del Cuerpo',
										style: 'width: 175px;'
									},
									{
										caption: 'Ejercicio',
									},
									{
										caption: 'Posición',
										style: 'width: 70px; text-align: center;'
									},
									{
										caption: 'Repeticiones',
										style: 'width: 70px; text-align: center;'
									},
									{
										caption: 'Series',
										style: 'width: 70px; text-align: center;'
									},
									{
										caption: 'Operaciones',
										style:'text-align: center; width: 100px;',
									},
								]}
									messages={{
										notChanges: 'No ha ejecutado cambios en la tabla de ejercicios de la membersía.',
										list404: 'Rercuso no encontrado para listar los elmentos de la tabla de ejercicios de la membersía.',
										list500: 'Ocurrió un error en listar los elementos de la tabla de ejercicios de la membersía.',
										save404: 'Rercuso no encontrado para guardar los cambios de la tabla de ejercicios de la membersía.',
										save500: 'Ocurrió un error para guardar los cambios de la tabla de ejercicios de la membersía.',
										save200: 'Se han actualizado los registros de la tabla de ejercicios de la membersía.',
								}}
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade show" style="display: {displayModal};"></div>

<div class="container">
	<div class="row">
		<svelte:component this={alertMessage} {...alertMessageProps} />
		<div class="col-lg-12 page-header">
			<h2>Historial de Membresias y Ejercicios del Miembro</h2>
		</div>
		<div class="col-md-6">
			<h3>Membresias</h3>
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
								type: 'custom', 
								icon: 'fa fa-list', 
								style:'font-size:12px; margin-right:8px;',
                key: 'id',
								customFunction: loadPackages,
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
						caption: 'codigo',
						style: 'display:none;',
					},
					{
						caption: 'Fecha de Inicio',
					},
          {
						caption: 'Fecha de Fin',
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
		<div class="col-md-6" style="display: {hidePackages}">
			<h3>Paquetes Registrados a Esa Membresía</h3>
			<DataTable bind:this={packageMembershipTable} 
				urlServices={{ 
					list: `${baseURL}admin/membership/package`, 
					save: `${baseURL}admin/membership/package` 
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
					actions:{
						type: 'actions',
						buttons: [
							{
								type: 'custom', 
								icon: 'fa fa-list-ol', 
								style:'font-size:12px; margin-right:8px;',
                key: 'id',
								customFunction: loadExersices,
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
						notChanges: 'No ha ejecutado cambios en la tabla de paquetes de la membresía.',
						list404: 'Rercuso no encontrado para listar los elmentos de la tabla de paquetes de la membresía.',
						list500: 'Ocurrió un error en listar los elementos de la tabla de paquetes de la membresía.',
						save404: 'Rercuso no encontrado para guardar los cambios de la tabla de paquetes de la membresía.',
						save500: 'Ocurrió un error para guardar los cambios de la tabla de paquetes de la membresía.',
						save200: 'Se han actualizado los registros de la tabla de paquetes de la membresía.',
					}}
			/>
		</div>
	</div>
</div>

<style>
  @media (min-width: 992px){
		.modal-lg, .modal-xl {
			--bs-modal-width: 900px;
		}
	}
</style>