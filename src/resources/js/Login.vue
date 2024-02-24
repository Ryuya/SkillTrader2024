<template>
    <div>
      <h2>ログイン</h2>
      <form @submit.prevent="login">
        <div>
          <label>Email:</label>
          <input type="email" v-model="email" required>
        </div>
        <div>
          <label>パスワード:</label>
          <input type="password" v-model="password" required>
        </div>
        <button type="submit">ログイン</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      login() {
        axios.get('/sanctum/csrf-cookie').then(res => {
            axios.post('/api/login', {
            email: this.email,
            password: this.password
            })
            .then(response => {
            // ログイン成功時の処理
            console.log('Login successful');
            // トークンをlocalStorageに保存
            localStorage.setItem('auth_token', response.data.token);
            // リダイレクトなど、適切な処理を追加
            this.$router.push({ name: 'task.list' });
            })
            .catch(error => {
            console.error('Error logging in:', error);
            });
      }
        ).catch(error => {
            console.error('Error logging in:', error);
        });
        }

    }
  }
  </script>
  