/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router';
import HeaderComponent from "./components/HeaderComponent";
import TaskListComponent from "./components/TaskListComponent";
import TaskShowComponent from "./components/TaskShowComponent";
import TaskCreateComponent from "./components/TaskCreateComponent";
import TaskEditComponent from "./components/TaskEditComponent";
import RegisterComponent from "./components/RegisterComponent";
import UserListComponent from "./components/UserListComponent";
import LoginComponent from "./components/LoginComponent";
import ProfileComponent from "./components/ProfileComponent";
import ProfileEditComponent from "./components/ProfileEditComponent";
import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import VueCookies from 'vue-cookies'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        isLoggedIn: false,
        token: null,
        user : null
      },

      mutations: {
        login(state, token) {
          state.isLoggedIn = true;
          state.token = token;
        },
        logout(state) {
          state.isLoggedIn = false;
          localStorage.removeItem('auth_token');
          state.token = null;
        },
        toggleIsLoggedIn(state) {
            state.isLoggedIn = !state.isLoggedIn;
        },
        setUser(state, user) {
            state.user = user;
        }
      },
      actions: {
        loginUser({ commit }, token) {
          commit('login', token);
          axios.get('/sanctum/csrf-cookie', { withCredentials: true })
            .then((response) => {
            axios.post('/api/getAuthUser/' + token, token, {
                headers: {
                    'Authorization': 'Bearer ' + token,
                }
            }).then((res) => {
                //userをセット
                commit('setUser', res.data);
                console.log('User!!!:', res.data);
            }).catch((error) => {
                console.error('Error fetching user:', error);
            });
            });

        },
        logoutUser({ commit }) {
            axios.get('/sanctum/csrf-cookie')
            .then(() => {
                axios.post('/api/logout') // Laravelのログアウトルートを呼び出す
                    .then(() => {
                        commit('logout');
                        localStorage.removeItem('auth_token'); // トークンをローカルストレージから削除
                    })
                    .catch(error => {
                        console.error('Error logging out:', error);
                });
            });
            commit('setUser', null);
            
            
        }
    },
      modules: {}
});




// Laravel SanctumのCSRFトークンを設定
axios.defaults.withCredentials = true;

require('./bootstrap');

window.Vue = require('vue').default;
 Vue.use(VueCookies);
 Vue.config.productionTip = false;
 Vue.use(VueRouter);
 
 const router = new VueRouter({
     mode: 'history',
     routes: [
        {
            path: '/',
            name: 'home',
            component: LoginComponent,
        },
        {
            path: '/users/:userId',
            name: 'user.show',
            component: ProfileComponent,
            props: true,
        },
        {
            path: '/users/:userId/edit',
            name: 'user.edit',
            component: ProfileEditComponent,
            props: true,
        },
         {
            path: '/tasks',
            name: 'task.list',
            component: TaskListComponent,
         },
         {
            path: '/tasks/:taskId',
            name: 'task.show',
            component: TaskShowComponent,
            props: true,
         },
            {
                path: '/tasks/create',
                name: 'task.create',
                component: TaskCreateComponent,
            }
        ,
        {
            path: '/tasks/:taskId/edit',
            name: 'task.edit',
            component: TaskEditComponent,
            props: true,
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterComponent
        },
        {
            path: '/login',
            name: 'login',
            component: LoginComponent
        },
        {
            path: '/users',
            name: 'users',
            component: UserListComponent,
        }
        // {
        //     path: '/profile',
        //     name: 'profile',
        //     component: ProfileComponent
        // },
        // {
        //     path: '/profile/edit',
        //     name: 'profile.edit',
        //     component: ProfileEditComponent
        // },
     ]
 });


 // ナビゲーションガードの設定
// router.beforeEach((to, from, next) => {
//     const isAuthenticated = false; // ユーザーがログインしているかどうかのロジック

//     // ログインしていない場合はユーザー登録画面にリダイレクトする
//     if (!isAuthenticated && to.path !== '/register') {
//         next('/register');
//     } else {

//     }
// });

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('header-component', HeaderComponent);

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.getters.isLoggedIn; // ストアのgetterを使用してログイン状態を取得

    if (to.meta.requiresAuth && !isAuthenticated) {
        if (to.path !== '/login') { // 現在のルートが既に '/login' にリダイレクトされていないかを確認
            next('/login'); // ログインページにリダイレクト
        } else {
            next(false); // 既にログインページにいる場合は何もしない
        }
    } else {
        next();
    }
  });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
