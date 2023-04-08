<svelte:options accessors={true} />
<script>
  import { onMount } from 'svelte';
  import random from '../Helpers/random.js';
  import axios from 'axios';
  import { CSRF } from '../Stores/csrf.js';
  export let data = [];
  export let validationMessage = '';
  export let placeholder = '';
  export let value = '';
  export let valid = true;
  export let validations = [];
  export let label = '';
  export let disabled = false;
  export let url = '';
  export let queryParams = {};
  export let selectedValue = 'E';
  export let customFunctionOnChange = null;
  export let key = {
    id: 'id',
    name: 'name',
  };
  let randId;
  let validationMessageClass = '';

  onMount(() => {
    randId = random(20);
  });

  export const validate = async () => {
    validations.forEach(validation => {
      if(validation.type == 'notEmpty'){
        // console.log('notEmpty')
        if(selectedValue == '' || selectedValue == 'E'){
          var message = 'Este campo debe de estar lleno';
          if (typeof validation.message !== 'undefined'){
            message = validation.message;
          }
          validationMessage = message;
          valid = false;
          validationMessageClass = 'text-danger';
        }else{
          validationMessage = '';
          validationMessageClass = '';
          valid = true;
        }
      }
    });
  };

  export const list = () => {
    // console.log(url);    console.log(columnSize);
    if(url == ''){
      data = [];
    }else{
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
          data.push(record);
        });
        data = data;
        // console.log(data);
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
    }
  };

  const selectChange = (event) => {
    // console.log(event);
    selectedValue = document.getElementById(randId).value;
    if(customFunctionOnChange != null){
      customFunctionOnChange()
    }
    if(selectedValue == '' || selectedValue == 'E'){
      var message = 'Este campo debe de estar lleno';
      if (typeof validation.message !== 'undefined'){
        message = validation.message;
      }
      validationMessage = message;
      valid = false;
      validationMessageClass = 'text-danger';
    }else{
      validationMessage = '';
      validationMessageClass = '';
      valid = true;
    }
  };
</script>

<label for="{randId}" class="form-label {validationMessageClass}">{label}</label>
<!--
<input type="text" class="form-control {(validationMessageClass == 'text-danger') ? 'is-invalid' : ''}" disabled={disabled} id="{randId}" placeholder="{placeholder}" bind:value={value} on:input="{validate}" style={style}>
-->
<select id="{randId}" class="form-select" aria-label="{placeholder}" disabled={disabled} bind:value={selectedValue} on:change|preventDefault={() => selectChange(event)}>
  {#each data as record}
    <option value="{record[key.id]}">{record[key.name]}</option>
  {/each}
</select>
<small id="randIdHelp" class="{validationMessageClass}">
  {validationMessage}
</small>

<style>
  .form-select{
    border-radius: 0px;
  }
</style>