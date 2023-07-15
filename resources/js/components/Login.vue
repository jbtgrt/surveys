<template>
	<div>
		<div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <!-- <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" /> -->
      <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Login To Your Account</h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Or
        {{ ' ' }}
        <router-link :to="{name: 'Register'}" class="font-medium text-indigo-600 hover:text-indigo-500">Register For Free</router-link>
      </p>
    </div>

	    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
	      <form className="mt-8 space-y-6" @submit="login">
	      	<Alert v-if="errorMsg">
	      			{{errorMsg}}
	      			<span class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer transition-colors hover:bg-[0,0,0,0.2]" @click="errorMsg = ''">
		      			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
		      		</span>
	      	</Alert> 
					<input type="hidden" name="remember" defaultValue="true" />
					<div className="rounded-md shadow-sm -space-y-px">
					<div>
					<label htmlFor="email-address" className="sr-only">
					Email address
					</label>
					<input	
					id="email-address"
					name="email"
					type="email"
					autoComplete="email"
					required
					v-model="user.email"
					className="appearance-none rounded-none relative block
					w-full px-3 py-2 border border-gray-300
					placeholder-gray-500 text-gray-900 rounded-t-md
					focus:outline-none focus:ring-indigo-500
					focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="Email address"
					/>
					</div>
					<div>
					<label htmlFor="password" className="sr-only">
					Password
					</label>
					<input
					id="password"
					name="password"
					type="password"
					autoComplete="current-password"
					required
					v-model="user.password"
					className="appearance-none rounded-none relative block
					w-full px-3 py-2 border border-gray-300
					placeholder-gray-500 text-gray-900 rounded-b-md
					focus:outline-none focus:ring-indigo-500
					focus:border-indigo-500 focus:z-10 sm:text-sm"
					placeholder="Password"
					/>
					</div>
					</div>
					<div className="flex items-center justify-between">
					<div className="flex items-center">
					<input
					id="remember-me"
					name="remember-me"
					type="checkbox"
					v-model="user.remember"
					className="h-4 w-4 text-indigo-600 focus:ring-indigo-500
					border-gray-300 rounded"
					/>
					<label htmlFor="remember-me" className="ml-2 block text-sm text-gray-900">
					Remember me
					</label>
					</div>
					<div className="text-sm">
					<a href="#" className="font-medium text-indigo-600 hover:text-indigo-500">
					Forgot your password?</a>
					</div>
					</div>
					<div>
					<button
					:disabled="loading"
					type="submit"
					className="group relative w-full flex justify-center
					py-2 px-4 border border-transparent text-sm font-medium
					rounded-md text-white bg-indigo-600 hover:bg-indigo-700
					focus:outline-none focus:ring-2 focus:ring-offset-2
					focus:ring-indigo-500"

					>
					
					<span className="absolute left-0 inset-y-0 flex items-center pl-3">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
						</svg>
					</span>
					<div
						v-if="loading"
						class="mr-2 inline-block h-5 w-5 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
						role="status">
						<span
						  class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
						  >Loading...</span
						>
					</div>
					Sign in
					</button>
					</div>
				</form>

	      <!-- <p class="mt-10 text-center text-sm text-gray-500">
	        Not a member?
	        {{ ' ' }}
	        <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Start a 14 day free trial</a>
	      </p> -->
	    </div>
	</div>
</template>

<script setup>
	import store from "../store.js";
	import {useRouter} from "vue-router";
	import {ref} from "vue";
	import Alert from "./Alert.vue";

	const router = useRouter();

	const user = {
		model: 'user',
		email: '',
		password: '',
		remember: false
	};

	const loading = ref(false);

	let errorMsg = ref('');

	function login(ev) {
		ev.preventDefault();
			loading.value = true;
		store
			.dispatch('login', user)
			.then((res) => {
				loading.value = false;
				router.push({
					name: 'Dashboard'
				});
			})
			.catch(err => {
				loading.value = false;
				errorMsg.value = err.response.data.error;
			});
	}

</script>