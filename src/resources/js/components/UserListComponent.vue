<template>
    <div>
      <h2>ユーザー一覧</h2>
      <ul>
        <li v-for="user in users" :key="user.id">{{ user.name }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        users: []
      };
    },
    mounted() {
      this.fetchUsers();
    },
    methods: {
      fetchUsers() {
        axios.get('/api/users')
          .then(response => {
            this.users = response.data;
            console.log(this.users);
          })
          .catch(error => {
            console.error('Error fetching users:', error);
          });
      }
    }
  }
  </script>
  