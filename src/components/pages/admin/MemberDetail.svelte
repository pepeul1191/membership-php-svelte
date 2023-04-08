<script>
  import { onMount } from 'svelte';
  import { alertMessage as alertMessageStore} from '../../Stores/alertMessage.js';
  import { getUser } from '../../../services/user_service.js';
  import { saveTicketDetail, getTicketById } from '../../../services/ticket_service.js';
  import InputText from '../../../widgets/InputText.svelte';
  import AlertMessage from '../../../widgets/AlertMessage.svelte';
  import DataTable from '../../../widgets/DataTable.svelte';
  import InputSelect from '../../../widgets/InputSelect.svelte';
  import TextArea from '../../../widgets/TextArea.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let baseURL = BASE_URL;
  let staticURL = STATIC_URL;
  export let workerName = '';
  export let disabled = false;
  export let disabledBranch = true;
  let title = '';
  // service header data
  export let id; let idDisplayed = '';
  export let created = ''; 
  export let edited = ''; 
  let workerId = '';
  let resume = ''; let inputResume; let resumeValid = false;
  let description = ''; let inputDescription; let descriptionValid = false;
  let branchTypeId; let inputBranchType; let branchTypeIdValid = false;
  let branchId; let inputBranch; let branchIdValid = false;
  let stateId; let inputState; let stateIdValid = false;
  let priorityId; let inputPriority; let priorityIdValid = false;
  let ticketTypeId = 1;
  // ticket files
  let ticketDataTable;

  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    var idLength = 10;
    // ajax
    if(id == 'E'){
      title = 'Crear Servicio';
      id = 'E';
      idDisplayed = ''
      disabledProjectType = true;
    }else{
      console.log('else')
      title = 'Editar Servicio';
      loadDetail(id);
      disabledProjectType = false;
    }
    // load worker data
    getUserInfo();
    inputBranchType.list();
    inputPriority.list();
    inputState.list();
    // files
    if(id != 'E'){
      ticketDataTable.urlServices.list = `${baseURL}admin/ticket_file/list?ticket_id=${id}`;
    }else{
      ticketDataTable.data = [];
    }
    ticketDataTable.list();
    ticketDataTable.extraData.ticket_id = id;
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
    getTicketById(id).then((resp) => {
      var data = resp.data;
      id = data.id;
      generatedDisplayedId();
      created = data.created;
      edited = data.edited;
      workerId = data.worker_id;
      branchId = data.branch_id;
      branchTypeId = data.branch_type_id;
      stateId = data.state_id;
      priorityId = data.priority_id;
      resume = data.resume;
      //inputDescription.getWYSIWYGContent() = data.description;
      ticketTypeId = data.ticket_type_id;
    }).catch((resp) =>  {
      disabled = true;
      if(resp.status == 404){
        launchAlert(null, 'Ticket a editar no existe', 'warning');
      }else{
        launchAlert(null, 'Ocurrió un error en obtener los datos del ticket', 'danger');
      }
    })
  };
  
  const getUserInfo = () => {
		getUser().then((resp) => {
      workerName = `${resp.data.last_names}, ${resp.data.names}`;
      workerId = resp.data.worker_id;
			//(resp.data.names != null) ? user.name = resp.data.names : showUser = false;
			//(resp.data.img != null) ? user.img = resp.data.img : user.img = `${staticURL}assets/img/default-user.png`;
			//(resp.data.user != null) ? user.user = resp.data.user : user.user = null;
		}).catch((resp) =>  {
			showUser = false;
		});
	};

  const saveHeader = () => {
    // run validations
    inputDescription.validate();
    inputResume.validate();
    inputDescription.validate();
    inputBranchType.validate();
    inputBranch.validate();
    inputState.validate();
    inputPriority.validate();
    // check if true
    if(resumeValid && descriptionValid && branchTypeIdValid && branchIdValid && stateIdValid && priorityIdValid){
      var params = {
        id: id,
        created: created,
        edited: edited,
        worker_id: workerId,
        branch_id: branchId,
        state_id: stateId,
        priority_id: priorityId,
        resume: resume,
        description: inputDescription.getWYSIWYGContent(),
        ticket_type_id: ticketTypeId,
      };
      // console.log(params);
      saveTicketDetail(params).then((resp) => {
        var data = resp.data;
        //console.log(data);
        if(typeof data === 'string' || data instanceof String){
          edited = data;
          launchAlert(null, 'Se ha editado un ticket', 'success');
        }else{
          id = data.id;
          generatedDisplayedId();
          edited = data.edited;
          created = data.created;
          title = 'Editar Servicio';
          launchAlert(null, 'Se ha creado un nuevo ticket', 'success');
          disabledProjectType = false;
          ticketDataTable.extraData.ticket_id = id;
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso guardar detalle de ticket no existe en el servidor', 'danger');
        }else if(resp.status == 501){ 
          launchAlert(null, resp.data, 'danger');
        }else { 
          launchAlert(null, 'Ocurrió un error en guardar los datos del ticket', 'danger');
        }
      });
    }
  };

  const generatedDisplayedId = () => {
    idDisplayed = id;
    while(idDisplayed.length <= 8){
      idDisplayed = '0' + idDisplayed;
    }
  }
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
    <div class="col-md-6">
      <br>
      <h6>Detalles del Ticket</h6>			
    </div>
    <div class="row">
      <div class="col-md-2">
        <InputText 
          label={'Número de Ticket'}
          bind:value={idDisplayed}
          placeholder={'Por generar'} 
          disabled={true}
          style={'text-align:left;'}
          validations={[
            {type:'notEmpty', message: 'Debe de ingresar un nombre proyecto'},
            {type:'maxLength', length: 100, message: 'Nombre máximo 100 letras'},
          ]}
        />
      </div>
      <div class="col-md-3">
        <InputText 
          label={'Informante'}
          bind:value={workerName}
          placeholder={'Informante'} 
          disabled={true}
          style={''}
          validations={[ ]}
        />
      </div>
      <div class="col-md-2">
        <InputSelect 
          label={'Tipo de Sede'}
          placeholder={'Tipo de Sede'} 
          disabled={disabled}
          url={`${baseURL}admin/branch_type/list`}
          validations={[
            {type:'notEmpty', message: 'Debe seleccionar el tipo de sede'},
          ]}
          key = {{ id: 'id', name: 'name'}}
          customFunctionOnChange={() => {
            var typeName = 'province';
            if(branchTypeId == 1){
              typeName = 'lima'
            }
            inputBranch.data = [];
            inputBranch.url = `${baseURL}admin/branch/list?type_name=${typeName}`;
            inputBranch.list();
            disabledBranch = false;
          }}
          bind:selectedValue={branchTypeId}
          bind:valid={branchTypeIdValid} 
          bind:this={inputBranchType}
        />
      </div>
      <div class="col-md-3">
        <InputSelect 
          label={'Sede'}
          placeholder={'Sede'} 
          disabled={disabledBranch}
          url={''}
          validations={[
            {type:'notEmpty', message: 'Debe seleccionar la sede'},
          ]}
          key = {{ id: 'id', name: 'name'}}
          bind:selectedValue={branchId}
          bind:valid={branchIdValid} 
          bind:this={inputBranch}
        />
      </div>
      <div class="col-md-2">
        <InputText 
          label={'Fecha de Creación'}
          bind:value={created}
          placeholder={'Por generar'} 
          disabled={true}
          style={'text-align:center;'}
          validations={[ ]}
        />
      </div>
    </div>
    <div class="row" style="margin-top:10px;">
      <div class="col-md-2">
        <InputSelect 
          label={'Prioridad'}
          placeholder={'Prioridad'} 
          disabled={disabled}
          url={`${baseURL}admin/priority/list`}
          validations={[
            {type:'notEmpty', message: 'Debe seleccionar la prioridad'},
          ]}
          key = {{ id: 'id', name: 'name'}}
          bind:selectedValue={priorityId}
          bind:valid={priorityIdValid} 
          bind:this={inputPriority}
        />
      </div>
      <div class="col-md-2">
        <InputSelect 
          label={'Estado'}
          placeholder={'Estado'} 
          disabled={disabled}
          url={`${baseURL}admin/state/list`}
          validations={[
            {type:'notEmpty', message: 'Debe seleccionar el estado'},
          ]}
          key = {{ id: 'id', name: 'name'}}
          bind:selectedValue={stateId}
          bind:valid={stateIdValid} 
          bind:this={inputState}
        />
      </div>
      <div class="col-md-6">
        <InputText 
        label={'Resumen del servicio (máxmo 75 letras)'}
        bind:value={resume}
        placeholder={'Resumen'} 
        disabled={disabled}
        validations={[
          {type:'notEmpty', message: 'Debe de ingresar un nombre proyecto'},
          {type:'maxLength', length: 75, message: 'Nombre máximo 100 letras'},
        ]}
        bind:valid={resumeValid} 
        bind:this={inputResume}
      />
      </div>
      <div class="col-md-2">
        <InputText 
          label={'Última Edición'}
          bind:value={edited}
          placeholder={'Por generar'} 
          disabled={true}
          style={'text-align:center;'}
          validations={[ ]}
        />
      </div>
    </div>
    <div class="row" style="margin-top:10px;">
      <div class="col-md-12">
        <TextArea 
          label={'Descripción'}
          bind:value={description}
          placeholder={'Resumen'} 
          disabled={disabled}
          validations={[
            {type:'notEmpty', message: 'Debe de ingresar un nombre proyecto'},
          ]}
          rows={5}
          WYSIWYG={true}
          height={150}
          bind:valid={descriptionValid} 
          bind:this={inputDescription}
        />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 pull-right">
        <button class="btn btn-success btn-actions" disabled="{disabled}" on:click="{saveHeader}"><i class="fa fa-check" aria-hidden="true"></i>{title}</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="padding-right: 25px;"> 
      <h6>Archivos Adjuntos</h6>
      <DataTable bind:this={ticketDataTable} 
				urlServices={{ 
					list: `${baseURL}admin/ticket_file/list`, 
					save: `${baseURL}admin/ticket_file/save` 
				}}
				buttonSave={true},
        buttonAddRow={true},
				rows={{
					id: {
						style: 'color: red; display:none;',
						type: 'id',
					},
					description:{
						type: 'input[text]',
					},
          url:{
						type: 'upload',
            style: 'text-align: center',
            tableKeyURL: 'url',
            tableRecordKey: 'id',
            validationExtension: {
              allowed: ['image/jpeg', 'image/png', 'image/jpg', 'application/x-php'], 
              message: 'Extensión del archivo no es válida'
            },
            url: '/admin/ticket_file/upload',
            extraPOSTData: {
              ticket_id: id,
              ticket_type: 'services'
            },
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
						caption: 'Descripción',
					},
          {
						caption: 'Archivos del Ticket',
            style: 'text-align: center',
					},
          {
						caption: 'Operaciones',
						style:'text-align: center;',
					},
				]}
				messages={{
					notChanges: 'No ha ejecutado cambios en la tabla de imágenes del proyecto',
					list404: 'Rercuso no encontrado para listar los elmentos de la tabla de imágenes del proyecto',
					list500: 'Ocurrió un error en listar los elementos de la tabla de imágenes del proyecto',
					save404: 'Rercuso no encontrado para guardar los cambios de la tabla de imágenes del proyecto',
					save500: 'Ocurrió un error para guardar los cambios de la table de imágenes del proyecto',
					save200: 'Se han actualizado los registros de la tabla de imágenes del proyecto',
				}}
        disabled={disabled}
			/>
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