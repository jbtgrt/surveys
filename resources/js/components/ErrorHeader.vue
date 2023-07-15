
<template>
	<div>
		<img class="rounded-full" :src="imageUrl" alt="" />
	</div>
</template>

<script>
	import illustration from '@images/illustration.png'
	import myImage from '@images/jobet.png'

	export default {
	  components: {
	    
	  },
	  data() {
	    return {
	      imageUrl: myImage,
	    };
	  },
	  setup() {

	  },
	};

</script>

