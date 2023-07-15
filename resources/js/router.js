import { createRouter, createWebHistory } from "vue-router";

import Welcome from './components/Welcome.vue';
import DefaultLayout from './layouts/DefaultLayout.vue';
import AuthLayout from './layouts/AuthLayout.vue';
import Dashboard from './components/Dashboard.vue';
import Surveys from './components/Surveys.vue';
import SurveyView from './components/SurveyView.vue';
import ErrorHeader from './components/ErrorHeader.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

//views
import SurveyPublicView from './views/SurveyPublicView.vue';

import store from './store.js';

const routes = [
   	{
      path: '/',
        redirect: '/dashboard',
        component: DefaultLayout,
        meta: {requiresAuth: true},
        children: [
            { path: '/dashboard', name: 'Dashboard', component: Dashboard},
            { path: '/surveys', name: 'Surveys', component: Surveys },
            { path: '/surveys/create', name: 'SurveyCreate', component: SurveyView },
            { path: '/surveys/:id', name: 'SurveyView', component: SurveyView },
            { path: '/welcome', name: 'Welcome', component: Welcome },
            { path: '/error',  name: 'Error', component: ErrorHeader },
        ]
    },
    {
        path: '/view/survey/:slug',
        name: 'SurveyPublicView',
        component: SurveyPublicView
    },
    {
      path: '/auth',
        redirect: '/login',
        component: AuthLayout,
        meta: {isGuest: true},
        children: [
            { path: '/login', name: 'Login', component: Login},
            { path: '/register', name: 'Register', component: Register },
        ]
    },
   
];

const router = createRouter({
	// mode: 'history',
	// base: '/',
  fallback: true,
  history: createWebHistory(),
  routes: routes,
  linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token){
        next({name: 'Login'});
    } else if (store.state.user.token && (to.meta.isGuest)) {
        next({name: 'Dashboard'});
    } else {
        next()
    }
});


export default router;

