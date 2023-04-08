import Admin from '../components/layouts/Admin.svelte';

const app = new Admin({
	target: document.body,
	props: {
		name: 'world'
	}
});

export default app;