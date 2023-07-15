<template>
	<PageComponent title='Dashboard'>
		<pre>{{loading}}</pre>
		<pre>{{data}}</pre>
	</PageComponent>
</template>

<script setup>
	import PageComponent from "../layouts/PageComponent.vue";
	import { computed } from "vue";
	import { useStore } from "vuex";

	const store = useStore();

	const loading = computed(() => store.state.dashboard.loading);
	const data = computed(() => store.state.dashboard.data);

	store.dispatch("getDashboardData");

</script>