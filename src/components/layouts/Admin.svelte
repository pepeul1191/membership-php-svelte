<script>
  import { onMount } from 'svelte';
  import Navigation from './../widgets/Navigation.svelte'
  import Footer from './../widgets/Footer.svelte';
  import 'bootstrap/dist/css/bootstrap.min.css';
	import 'font-awesome/css/font-awesome.min.css';
  import '../../stylesheets/global.css';
	import '../../stylesheets/admin.css';
  import { Router, Route } from 'svelte-routing';
  import Member from '../pages/admin/Member.svelte';
  // variables
  export let url = '';
  export let basepath = '/admin';
  // functions
  onMount(() => { /* TODO? */  });
</script>

<Navigation />

<Router url="{url}" basepath="{basepath}">
  <Route path="/" component="{Member}" />
  <!--
    <Route path="/*" component="{Redirect404}" />
  -->
</Router>

<Footer />

<style>

</style>