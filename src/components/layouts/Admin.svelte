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
  import Discipline from '../pages/admin/Discipline.svelte';
  import MemberUser from '../pages/admin/MemberUser.svelte';
  import Objective from '../pages/admin/Objective.svelte';
  import BodyPart from '../pages/admin/BodyPart.svelte';
  import Level from '../pages/admin/Level.svelte';
  // variables
  export let url = '';
  export let basepath = '/admin';
  // functions
  onMount(() => { /* TODO? */  });
</script>

<Navigation />

<Router url="{url}" basepath="{basepath}">
  <Route path="/" component="{Member}" />
  <Route path="/member" component="{Member}" />
  <Route path="/discipline" component="{Discipline}" />
  <Route path="/objective" component="{Objective}" />
  <Route path="/body_part" component="{BodyPart}" />
  <Route path="/level" component="{Level}" />
  <Route path="/member/user/:id" let:params><MemberUser id={params.id}/></Route>
  <!--
    <Route path="/*" component="{Redirect404}" />
  -->
</Router>

<Footer />

<style>

</style>