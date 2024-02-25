<template>
  <div class="container">  
    <div class="w-75" v-if="user">
      <h1>プロフィール</h1>
      <form @submit.prevent="updateUser">
        <label for="name">名前:</label>
        <input type="text" v-model="user.name" id="name">
        <label for="email">メールアドレス:</label>
        <input type="email" v-model="user.email" id="email">
        <p><strong>学びたいスキル:</strong></p>
        <span class="tag" v-for="(skill, index) in user.learnable_skills" :key="index">
          <span>{{ skill.name }}</span>
          <button type="button" @click="removeLearnableSkill(index)" class="remove-btn">✕</button>
        </span>

        <label for="newLearnableSkill">新しい学びたいスキルを追加:</label>
        <vue-simple-suggest v-model="newLearnableSkill" :list="suggestedLearnableSkills" :filter-by-query="true" label="name" @input="suggestLearnableSkills" @select="addLearnableSkill"></vue-simple-suggest>
        
        <p><strong>教えられるスキル:</strong></p>
        <span class="tag" v-for="(skill, index) in user.teachable_skills" :key="index">
          <span>{{ skill.name }}</span>
          <button type="button" @click="removeTeachableSkill(index)" class="remove-btn">✕</button>
        </span>

        <label for="newTeachableSkill">新しい教えられるスキルを追加:</label>
        <vue-simple-suggest v-model="newTeachableSkill" :list="suggestedTeachableSkills" :filter-by-query="true" label="name" @input="suggestTeachableSkills" @select="addTeachableSkill"></vue-simple-suggest>

        <button class = "btn btn-primary" type="submit">更新</button>
      </form>
    </div>
    <div v-else>
      <p>プロフィール情報を取得中...</p>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import { mapState,mapActions } from 'vuex';
import VueSimpleSuggest from 'vue-simple-suggest';
import 'vue-simple-suggest/dist/styles.css';
export default {
  components: {
    VueSimpleSuggest,
  },
  data() {
    return {
      newLearnableSkill: '',
      newTeachableSkill: '',
      suggestedLearnableSkills: [],
      suggestedTeachableSkills: [],
      skills: [],
    };
  },
  computed: {
    ...mapState(['user']),
  },
  methods: {
    ...mapActions(['setUser','loginUser']),
    async updateUser() {
      try {
       // 新しい学びたいスキルが入力されているかチェック
    if (this.newLearnableSkill.trim() !== '') {
        this.user.learnable_skills.push({ name: this.newLearnableSkill });
    }

    // 新しい教えられるスキルが入力されているかチェック
    if (this.newTeachableSkill.trim() !== '') {
        this.user.teachable_skills.push({ name: this.newTeachableSkill });
    }

        // ユーザー情報を更新
        await axios.put(`/api/users/${this.user.id}`, this.user);
        console.log('ユーザー情報を更新しました:', this.user);
        this.$router.push({ name: 'user.show' });
      } catch (error) {
        console.error('ユーザー情報の更新に失敗しました:', error);
      }
    },
    async suggestLearnableSkills(term) {
      try {
        const response = await axios.get(`/api/skills?search=${term}`);
        this.suggestedLearnableSkills = response.data.map(skill => skill.name);
      } catch (error) {
        console.error('学びたいスキルのサジェストに失敗しました:', error);
      }
    },
    async suggestTeachableSkills(term) {
      try {
        const response = await axios.get(`/api/skills?search=${term}`);
        this.suggestedTeachableSkills = response.data.map(skill => skill.name);
      } catch (error) {
        console.error('教えられるスキルのサジェストに失敗しました:', error);
      }
    },
    addLearnableSkill(skill) {
      if (skill.trim() !== '') { // スキル名が空でないことを確認
        this.user.learnable_skills.push({ name: skill });
      }
      this.clearSuggestLearnableSkills();
    },
    addTeachableSkill(skill) {
      if (skill.trim() !== '') { // スキル名が空でないことを確認
        this.user.teachable_skills.push({ name: skill });
      }
      this.clearSuggestTeachableSkills();
    },
    async clearSuggestLearnableSkills() {
      await this.$nextTick();
      this.newLearnableSkill = '';
      this.suggestedLearnableSkills = [];
    },
    async clearSuggestTeachableSkills() {
      await this.$nextTick();
      this.newTeachableSkill = '';
      this.suggestedTeachableSkills = [];
    },
    async fetchUserData(userId) {
      try {
        const response = await axios.get(`/api/users/${userId}`);
        this.user = response.data;
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
    removeLearnableSkill(index) {
      this.user.learnable_skills.splice(index, 1);
    },
    removeTeachableSkill(index) {
      this.user.teachable_skills.splice(index, 1);
    },
  },
  created() {

    const token = localStorage.getItem('auth_token');
    if (token) {
        this.loginUser(token);
    } else {
        this.user = null;
    }
    this.fetchSkills();
  },
};
</script>
<style scoped>
.tag {
  display: inline-block;
  padding: 5px 10px;
  background-color: #f2f2f2;
  border-radius: 20px;
  margin-right: 10px;
  margin-bottom: 10px;
}

.tag:hover {
  background-color: red;
  color: white;
  cursor: pointer;
}

.remove-btn {
  margin-left: 5px;
  background-color: transparent;
  border: none;
  color: red;
  cursor: pointer;
}
</style>