<script>
  import { onMount } from 'svelte';
  import { setObjectives } from '../../../services/MemberObjectiveService.js';
  import InputCheckGroup from '../../widgets/InputCheckGroup.svelte';
  import { alertMessage as alertMessageStore} from '../../../stores/alertMessage.js';
  import AlertMessage from '../../widgets/AlertMessage.svelte';
  let alertMessage = null;
  let alertMessageProps = {};
  let baseURL = BASE_URL;
  let staticURL = STATIC_URL;
  let title = 'Asociación de Objetivos a Miembro';
  // service header data
  let memberObjective;
  export let id;

  onMount(() => {    
    alertMessageStore.subscribe(value => {
      if(value != null){
        alertMessage = value.component;
        alertMessageProps = value.props;
      }
    });
    loadDetail(id);
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
    memberObjective.url = `${baseURL}admin/member/objective?member_id=${id}`;
    memberObjective.list();
  };

  const saveObjectives = (objective) => {
    var dataChanged = objective.getChanges();
    if(id != 'E'){
      var params = {
        id: id,
        data: dataChanged,
      };
      setObjectives(params).then((resp) => {
        var data = resp.data;
        //branch.originData = JSON.parse(JSON.stringify(branch.data));
        if(data == ''){
          launchAlert(null, 'Se ha asociado el sedes al trabajador', 'success');
          objective.updateOriginData();
        }
      }).catch((resp) =>  {
        if(resp.status == 404){
          launchAlert(null, 'Recurso asosiar los trabajores a sedes no existe en el servidor', 'danger');
        }else if(resp.status == 501){ 
          launchAlert(null, resp.data, 'danger');
        }else { 
          launchAlert(null, 'Ocurrió un error en asosiar las sedes a los trabajadores', 'danger');
        }
      })
    }
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
    <svelte:component this={alertMessage} {...alertMessageProps} />
    <div class="col-md-12">
      <InputCheckGroup bind:this={memberObjective} 
        url={`${baseURL}admin/member/objective?member_id=${id}`}
        key = {{ id: 'id', name: 'name', exist: 'exist' }}
        inline = {true}
        label = {'Objetivos del Miembro'}
        disabled = {false}
        columnSize = {3}
      />
    </div>
    <div class="col-md-12 pull-right">
      <button class="btn btn-success btn-actions" style="" disabled="{false}" on:click="{saveObjectives(memberObjective)}"><i class="fa fa-list" aria-hidden="true"></i>
        Asosiar Objectivos</button>
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