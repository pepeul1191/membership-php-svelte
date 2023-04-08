<script>
	import 'bootstrap/dist/css/bootstrap.min.css';
  import 'font-awesome/css/font-awesome.min.css';
  import '../../stylesheets/global.css';
  import '../../stylesheets/login.css';
  import Login from '../pages/login/Login.svelte'
  import SignIn from '../pages/login/SignIn.svelte'
  import ResetPassword from '../pages/login/ResetPassword.svelte'
  import ChangePassword from '../pages/login/ChangePassword.svelte'
  import { Router, Route } from 'svelte-routing';
  // variables
  export let url = '';
  export let basepath = '/login';
</script>

<Router url="{url}" basepath="{basepath}">
  <Route path="/" component="{Login}" />
  <Route path="/sign_in" component="{SignIn}" />
  <Route path="/reset_password" component="{ResetPassword}" />
  <Route path="/change_password/:userId/:resetKey" component="{ChangePassword}" />
  <!--
    <Route path="/*" component="{Redirect404}" />
  -->
</Router>

<style>
</style>