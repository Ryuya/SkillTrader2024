<template>
    <div class="container-fluid bg-dark mb-3">
      <div class="container">
        <nav class="navbar navbar-dark">
          <span class="navbar-brand mb-0 h1"> {{this.user != null ? 'Welcome! ' + this.user.name : 'Welcome'}}</span>
          <div>
            <router-link v-bind:to="{name: 'task.list'}">
              <button class="btn btn-success">List</button>
            </router-link>
            <router-link v-bind:to="{name: 'task.create'}">
              <button class="btn btn-success">ADD</button>
            </router-link>
            
            <template v-if="isLoggedIn">
              <!-- ログイン中の場合はログアウトボタンを表示 -->
              <button class="btn btn-danger" @click="logout">Logout</button>
            </template>
            <template v-else>
              <!-- ログアウト中の場合はログインボタンを表示 -->
              <button class="btn btn-primary" @click="login">Login</button>
              <router-link v-bind:to="{name: 'register'}">
                <button class="btn btn-light">Register</button>
                </router-link>
            </template>
            
          </div>
        </nav>
      </div>
    </div>


  </template>
  
  <script>
  import axios from 'axios';
  import { mapState, mapActions } from 'vuex';

  export default {
    data() {
      return {
      };
    },
    computed: {
        ...mapState(['isLoggedIn', 'token', 'user']),
        
    },
    methods: {
        ...mapActions(['logoutUser', 'loginUser']),
        logout() {
            this.$router.push({ name: 'users' }); // ログインページにリダイレクト
            this.logoutUser(); // Vuexストアからログアウト
        },
        login() {
            this.$router.push({ name: 'login' }); // ログインページにリダイレクト
        },
        getUser() {
            axios.get('/sanctum/csrf-cookie', { withCredentials: true })
            .then((response) => {
            axios.post('/api/getAuthUser/' + this.token, this.token, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'X-XSRF-TOKEN': this.$cookies.get('XSRF-TOKEN') // CSRF トークンをヘッダーに含める
                }
            }).then((res) => {
                console.log(res.data);
                this.user = res.data;
            }).catch((error) => {
                console.error('Error fetching user:', error);
            });
            });
        },
    },
    created() 
    {
        const token = localStorage.getItem('auth_token');
        if (token) {
            this.loginUser(token);
        } else {
            this.user = null;
        }
        console.log(this.token);
    }
  };
  </script>
  