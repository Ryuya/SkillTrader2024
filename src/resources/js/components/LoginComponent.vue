<template>
    <div class="container">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" v-model="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
    import axios from 'axios';
    import { mapActions,mapState } from 'vuex';
  export default {
    data() {
      return {
        name: '',
        email: '',
        password: ''
      };
    },
    methods: {
    ...mapActions(['loginUser']),
      login() {
        // ログインのAPIリクエストを行います
        const loginData = {
          email: this.email,
          password: this.password,
        };
        axios.get('/sanctum/csrf-cookie', { withCredentials: true } )
            .then(response => {
                axios.post('/api/login', loginData, { withCredentials: true })
                .then(response => {
                    // ログイン成功時の処理をここに記述
                    // トークンをlocalStorageに保存する
                    console.log('Login successful');
                    this.loginUser(response.data.api_token);
                    localStorage.setItem('auth_token', response.data.api_token);
                    this.$router.push({ name: 'task.list' });
                    
                })
                .catch(error => {
                    console.error('Error logging in:', error);
                });
          })
          .catch(error => {
            console.error('Error logging in:', error);
          });
      }
    },
    
  };
  </script>
  