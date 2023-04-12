<script>
  import { onMount } from 'svelte';
  import { getMemberUser } from '../../../services/UserService.js';
  let baseURL = BASE_URL;
  let staticURL = STATIC_URL;
  let title = 'Gestión de Usiario del Miembro';
  // service header data
  export let id;

  onMount(() => {    
    loadDetail(id);
  });


  const loadDetail = (id) => {
    getMemberUser(id).then((resp) => {
      var data = resp.data;
      id = data.id;
      
    }).catch((resp) =>  {
      console.log(resp)
    })
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
  </div>
</div>

<style>
.btn-actions{
    float:right;
    margin-top:15px;
    margin-left: 10px;
  }
</style>