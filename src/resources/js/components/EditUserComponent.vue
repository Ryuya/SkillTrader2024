<!-- EditUser.vue -->
<template>
    <div>
      <h1>ユーザー編集</h1>
      <form @submit.prevent="updateUser">
        <label for="name">名前:</label>
        <input type="text" v-model="user.name" id="name">
        
        <label for="email">メールアドレス:</label>
        <input type="email" v-model="user.email" id="email">
        
        <label>学びたいスキル:</label>
        <select multiple v-model="selectedLearnableSkills">
          <option v-for="skill in skills" :key="skill.id" :value="skill.id">{{ skill.name }}</option>
        </select>
        
        <label>教えられるスキル:</label>
        <select multiple v-model="selectedTeachableSkills">
          <option v-for="skill in skills" :key="skill.id" :value="skill.id">{{ skill.name }}</option>
        </select>
        
        <button type="submit">更新</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: {},
        skills: [],
        selectedLearnableSkills: [],
        selectedTeachableSkills: [],
      };
    },
    methods: {
      async fetchUserData(userId) {
        try {
          const response = await axios.get(`/api/users/${userId}`);
          this.user = response.data;
          this.selectedLearnableSkills = this.user.learnable_skills.map(skill => skill.id);
          this.selectedTeachableSkills = this.user.teachable_skills.map(skill => skill.id);
        } catch (error) {
          console.error('ユーザーデータの取得に失敗しました:', error);
        }
      },
      async fetchSkills() {
        try {
          const response = await axios.get('/api/skills');
          this.skills = response.data;
        } catch (error) {
          console.error('スキルの取得に失敗しました:', error);
        }
      },
      async updateUser() {
        try {
          const response = await axios.put(`/api/users/${this.user.id}`, {
            name: this.user.name,
            email: this.user.email,
            learnable_skills: this.selectedLearnableSkills,
            teachable_skills: this.selectedTeachableSkills,
          });
          console.log('ユーザーが更新されました:', response.data);
          // 更新成功の場合の処理を追加
        } catch (error) {
          console.error('ユーザーの更新に失敗しました:', error);
          // 更新失敗の場合の処理を追加
        }
      },
    },
    mounted() {
      const userId = this.$route.params.id;
      this.fetchUserData(userId);
      this.fetchSkills();
    },
  };
  </script>
  