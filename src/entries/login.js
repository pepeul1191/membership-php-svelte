import Login from '../layouts/Login.svelte';

const login = new Login({
	target: document.body,
	props: {
		name: 'world'
	}
});

export default login;