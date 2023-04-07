<script>
	import 'bootstrap/dist/css/bootstrap.min.css';
  import '../../stylesheets/global.css';
  import '../../stylesheets/login.css';
  import Login from '../pages/login/Login.svelte'
  import SignIn from '../pages/login/SignIn.svelte'
  import ResetPassword from '../pages/login/ResetPassword.svelte'
  import { Router, Route } from 'svelte-routing';
  // variables
  export let url = '';
  export let basepath = '/login';
</script>

<Router url="{url}" basepath="{basepath}">
  <Route path="/" component="{Login}" />
  <Route path="/sign-in" component="{SignIn}" />
  <Route path="/reset-password" component="{ResetPassword}" />
  <!--
    <Route path="/*" component="{Redirect404}" />
  -->
</Router>

<style>
</style>