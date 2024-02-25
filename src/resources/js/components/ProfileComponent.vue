<template>
    <div  class="container-sm  mx-auto">
      <h1>プロフィール</h1>
      <div v-if="user">
        <p><strong>名前:</strong> {{ this.user.name }}</p>
        <p><strong>メールアドレス:</strong> {{ this.user.email }}</p>
        <!-- <p><strong>学びたいスキル:</strong> {{ user.learnable_skills.join(', ') }}</p> -->
        <!-- <p><strong>教えられるスキル:</strong> {{ user.teachable_skills.join(', ') }}</p> -->
        <!-- edit button -->
        <router-link :to="{ name: 'user.edit' }">
            <button class = "btn btn-primary">プロフィールを編集</button>
        </router-link>
      </div>
      <div v-else>
        <p>プロフィール情報を取得中...</p>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { mapState } from 'vuex';
  
  export default {
    data() {
        return {

        };
    },
    computed: {
        ...mapState(['user']),
    },
  };
  </script>
  
  <style scoped>
  /* 必要なスタイルを追加 */
  </style>
  