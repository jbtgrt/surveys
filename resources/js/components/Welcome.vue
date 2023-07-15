<template>
  <div>
    <h2>Counter: {{ count }}</h2>
    <button @click="increment">Increment</button>
    <button @click="decrement">Decrement</button>
  </div>
</template>

<script>
	import { mapState, mapActions } from 'vuex';

	export default {
	  computed: {
	    ...mapState(['count']),
	  },
	  methods: {
	    ...mapActions(['increment', 'decrement']),
	  },
	};
</script>
