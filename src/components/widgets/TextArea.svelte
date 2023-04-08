<svelte:options accessors={true} />
<script>
  import { onMount } from 'svelte';
  import random from '../Helpers/random.js';
  export let validationMessage = '';
  export let placeholder = '';
  export let value = '';
  export let valid = true;
  export let validations = [];
  export let label = '';
  export let disabled = false;
  export let rows = 3;
  export let WYSIWYG = false;
  export let height = 150;
  let frame;
  let randId;
  let validationMessageClass = '';

  onMount(() => {
    randId = random(20);
    console.log(randId)
    if(WYSIWYG){
      //document.getElementById(randId).contentDocument.designMode = "on";
      frame.addEventListener('load', loadEditor());
    }
  });

  export const getWYSIWYGContent = () => {
    return frame.contentDocument.body.innerHTML;
  };

  const loadEditor = () => {
    frame.contentDocument.designMode = 'on';
    frame = frame;
  };

  export const validate = async () => {
    validations.forEach(validation => {
      if(validation.type == 'notEmpty'){
        // console.log('notEmpty')
        var content = value;
        if(WYSIWYG){
          content = getWYSIWYGContent();
        }
        if(content == ''){
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
      if(validation.type == 'emptyOrMaxLength'){
        //console.log('emptyOrMaxLength')
        if(value.length > validation.length){
          var message = `Máximo ${validation.length} carácteres`;
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
      if(validation.type == 'maxLength' && valid == true){
        //console.log('maxLength')
        if(value.length > validation.length){
          var message = `Máximo ${validation.length} carácteres`;
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

  const bold = () => {
    frame.contentDocument.execCommand('bold', false, null);
  }

  const italic = () => {
    frame.contentDocument.execCommand('italic', false, null);
  }

  const underline = () => {
    frame.contentDocument.execCommand('underline', false, null);
  }

  const unorderedList = () => {
    frame.contentDocument.execCommand('insertUnorderedList', false, null);
  }

  const orderedList = () => {
    frame.contentDocument.execCommand('insertOrderedList', false, null);
  }
</script>

<label for="{randId}" class="form-label {validationMessageClass}">{label}</label>
{#if WYSIWYG}
  <div class="btn-row {(validationMessageClass == 'text-danger') ? 'is-invalid' : ''}">
    <button class="btn" on:click="{bold}">
      <i class="fa fa-bold" aria-hidden="true"></i>
    </button>
    <button class="btn" on:click="{italic}">
      <i class="fa fa-italic" aria-hidden="true"></i>
    </button>
    <button class="btn" on:click="{underline}">
      <i class="fa fa-underline" aria-hidden="true"></i>
    </button>
    <button class="btn" on:click="{unorderedList}">
      <i class="fa fa-list-ul" aria-hidden="true"></i>
    </button>
    <button class="btn" on:click="{orderedList}">
      <i class="fa fa-list-ol" aria-hidden="true"></i>
    </button>
  </div>
  <iframe bind:this={frame} style="height: {height}px;"  class="form-control {(validationMessageClass == 'text-danger') ? 'is-invalid' : ''}" id="{randId}" frameborder="0" ></iframe>
{:else}
  <textarea class="form-control {(validationMessageClass == 'text-danger') ? 'is-invalid' : ''}" rows="{rows}"  disabled={disabled} id="{randId}" placeholder="{placeholder}" bind:value={value} on:input="{validate}"></textarea>
{/if}
<small id="randIdHelp" class="{validationMessageClass}">
  {validationMessage}
</small>

<style>
  .btn-row{
    border-top: 1px solid #ced4da;
    border-left: 1px solid #ced4da;
    border-right: 1px solid #ced4da;
  }

  .is-invalid{
    border-top: 1px solid #dc3545;
    border-left: 1px solid #dc3545;
    border-right: 1px solid #dc3545;
  }

  .form-control{
    border-radius: 0px;
  }
</style>