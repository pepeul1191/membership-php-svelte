<svelte:options accessors={true} />
<script>
  import { onMount } from 'svelte';
  import axios from 'axios';
  import { CSRF } from '../Stores/csrf.js';
  import random from '../Helpers/random.js';
  export let inline = false;
  export let queryParams = {};
  export let disabled = false;
  export let label = '';
  export let url = '';
  export let columnSize = 3;
  export let key = {
    id: 'id',
    name: 'xd',
    exist: 'exist',
  };
  export let messages = {
    list404: 'Rercuso no encontrado para listar los elmentos de la lista',
    list500: 'Ocurrió un error en listar los elementos de la lista',
  };
  export let data = [];
  export let originData = [];

  onMount(() => {

  });

  export const list = () => {
    // console.log(url);    console.log(columnSize);
    axios.get( // url, data, headers
      url, 
      {
        params: queryParams,
        headers:{
          [CSRF.key]: CSRF.value,
        }
      },
    )
    .then(function (response) {
      response.data.forEach(record => {
        //console.log(record);
        record.idDOM = random(10);
        data.push(record);
      });
      data = data;
      originData = JSON.parse(JSON.stringify(data));
    })
    .catch(function (error) {
      console.error(error);
      if (error.response) {
        if(error.response.status == 404){
          launchAlert({
            message: messages.list404,
            type: 'danger',
            timeOut: 5000
          });
        }else{
          launchAlert({
            message: messages.list500,
            type: 'danger',
            timeOut: 5000
          });
        }
        console.log(error.response.data);
        console.log(error.response.status);
        // console.log(error.response.headers);
      }
    })
    .then(function () {
      display = true;
    });
  };

  const checkBoxChange = (event, checkId) => {
    if(event.target.checked){ // 0 -> 1
      for(var i = 0; i < data.length; i++){
        if(data[i][key.id] == checkId){
          data[i][key.exist] = '1';
        }
      }
    }else{ // 1 -> 0
      for(var i = 0; i < data.length; i++){
        if(data[i][key.id] == checkId){
          data[i][key.exist] = '0';
        }
      }
    }
  };

  export const getChanges = () => {
    var resp = [];
    for(var i = 0; i < data.length; i++){
      if(data[i][key.exist] != originData[i][key.exist]){
        resp.push(data[i]);
      }
    }
    return resp;
  };

  export const selectAll = () => {
    for(var i = 0; i < data.length; i++){
      data[i][key.exist] = '1';
    }
  };

  export const unselectAll = () => {
    for(var i = 0; i < data.length; i++){
      data[i][key.exist] = '0';
    }
  };
</script>

{#if label != ''}
  <label>{label}</label><br><br>
{/if}
<div class="row">
  {#each data as record}
    <div class="col-md-{columnSize}">
      <div class="{inline ? 'form-check form-check-inline' : 'form-check'}">
        <input class="form-check-input" type="checkbox" id="{`chk-${record.idDOM}`}" value="{record[key.id]}" checked={record[key.exist] == 1 ? true : false} on:change={() => checkBoxChange(event, record[key.id])} disabled={disabled}>
        <label class="form-check-label" for="{`chk-${record.idDOM}`}">{record[key.name]}</label>
      </div>
    </div>
  {/each}
</div>
<style>

</style>