<template>
	<PageComponent>
		<template v-slot:header>
			<h1 class="text-3xl font-bold tracking-tight text-gray-900">
	          Dashboard
	        </h1>
		</template>
		<template v-slot:content>
			<div v-if="loading" class="flex justify-center">Loading...</div>	
			<div v-else>
				<div class="grid grid-cols-1 gap-5 text-gray-700 md:grid-cols-2 lg:grid-cols-3">
					<div 
						class="bg-white shadow-md p-3 text-center flex flex-col order-1 lg:order-2 animate-fade-in-down" 
						style="animation-delay: 0.1s" 
						>
						<h3 class="text-2xl font-semibold">Total Surveys</h3>
						<div
							class="text-8xl font-semibold flex-1 flex items-center justify-center"
							>
							{{data.totalSurveys}}
						</div>
					</div>
					<div 
						class="bg-white shadow-md p-3 text-center flex flex-col order-2 lg:order-4 animate-fade-in-down" 
						style="animation-delay: 0.2s" 
						>
						<h3 class="text-2xl font-semibold">Total Answers</h3>
						<div
							class="text-8xl font-semibold flex-1 flex items-center justify-center"
							>
							{{data.totalAnswers}}
						</div>
					</div>
					<div
						class="row-span-2 bg-white shadow-md p-4 order-3 lg:order-1 animate-fade-in-down"
						
						>
						<h3 class="text-2xl font-semibold mb-2">Latest Survey</h3>
						<div v-if="data.latestSurveys">
							<img 
								:src="data.latestSurveys.image_url" 
								class="w-[240px] mx-auto"
								alt=""
								>
							<div class="flex justify-between text-sm mb-1">
								<div>Create Date:</div>
								<div>{{data.latestSurveys.created_at}}</div>
							</div>
							<div class="flex justify-between text-sm mb-1">
								<div>Expire Date:</div>
								<div>{{data.latestSurveys.expire_date}}</div>
							</div>
							<div class="flex justify-between text-sm mb-1">
								<div>Status:</div>
								<div>{{data.latestSurveys.status ? 'active' : ''}}</div>
							</div>
							<div class="flex justify-between text-sm mb-1 ">
								<div>Questions:</div>
								<div>{{data.latestSurveys.questions}}</div>
							</div>
							<div class="flex justify-between text-sm mb-3">
								<div>Answers:</div>
								<div>{{data.latestSurveys.answers}}</div>
							</div>
							<div class="flex justify-between">
								<router-link
									:to="{ name: 'SurveyView', params: { id: data.latestSurveys.id } }"
									class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
									>
									Edit Survey
								</router-link>
								<button
									class="flex py-2 px-4 border border-transparent text-sm rounded-md text-indigo-500 hover:bg-indigo-700 hover:text-white transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
									>
									View Answers 
								</button>
							</div>
						</div>
						<div v-else>
							No record
						</div>
					</div>
					<div
						class="row-span-2 bg-white shadow-md p-3 order-4 lg:order-3 animate-fade-in-down"
						style="animation-delay: 0.3s" 
						>
						<div class="flex justify-between items-center mb-3 px-2">
							<h3 class="text-2xl font-semibold">Latest Answers</h3>
							<a v-if="data.latestAnswers.length" href="javascript:void(0)" class="text-sm text-blue-500 hover:decoration-blue-500">View all</a>
						</div>
						<div v-if="data.latestAnswers.length">
							<a href="#"
								v-for="answer in data.latestAnswers"
								:key="answer.id"
								class="block p-2 hover:bg-gray-100/90" 
								>
								<div class="font-semibold">
									{{answer.survey.title}}
								</div>	
								<small>
									Answer Made at: 
									<i class="font-semibold">{{answer.end_date}}</i>
								</small>
							</a>
						</div>
						<div v-else>
							No record
						</div>
					</div>

				</div>
			</div>
		</template>
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