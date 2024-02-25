   <template>
    <div>
      <div class="container" v-if="user">
        <div class="container">
          <div class="row justify-content-center">
            
              <div class="col-md-12">
                  <div class="card mt-5" style="border-style: none;">
                      <div class="card-body">
                        <vue-simple-suggest v-model="tmpSearchSkill" :list="suggestedSkills" :filter-by-query="true" label="name" @input="suggestSkills" @select="addSkill"></vue-simple-suggest>
                      </div>
                  </div>
              </div>

              <div class="col-md-12 mt-5">
                <div class="card" style="border-style: none; background-color:transparent;">
                  <div class="card-body">
                      <div class="row d-flex align-item-center" >
                          <div class="col-md-5 d-flex align-items-center">
                            <div class="card col-md-12 bg-none" style="border-style: none;background-color:transparent;">
                                <div class="card-body text-center " style="background-color:transparent;">
                                  <span class="tag" v-for="(skill, index) in user.teachable_skills" :key="index">
                                    <span>{{ skill.name }}</span>
                                  </span>

                                </div>
                            </div>
                          </div>
                          <div class="col-md-2 d-flex align-items-center justify-content-center"><!-- マッチングした人のカード -->
                              <img  width="86px" src="https://s3.amazonaws.com/optionalphafiles/wp-content/uploads/2015/06/15190517/Arrows-56.png" />
                          </div><!-- END マッチングした人のカード -->
                          <div class="col-md-5 d-flex align-items-center"><!-- マッチングした人のカード -->
                            <div class="card col-md-12 bg-none" style="border-style: none;background-color:transparent;">
                                <div class="card-body text-center skillArea" style="background-color:transparent;">
                                  <span class="tag" v-for="skill in searchSkills">
                                    <span>{{ skill }}</span>
                                  </span>

                                </div>
                            </div>
                          </div><!-- END マッチングした人のカード -->
                      </div>
                  </div>
                </div><!-- マッチングした人のリストの枠 -->
              </div>
          </div>
        </div>
        <div class="col-md-12 mt-5">
          <div class="card"> <!-- マッチングした人のリストの枠 -->
            <div class="card-header bg-info" style="color:white">ユーザー一覧</div>
            <div class="card-body">
              <div class="row d-flex align-item-center">
                <div v-for="(user, index) in filteredUsers" :key="index" class="col-md-6">
                  <div class="card">
                    <div class="card-header" style="background-color:rgba(0, 0, 0,0.02)">
                      <div><h6><b>{{ user.name }}</b></h6></div>
                      <div><h6><b>{{ user.email }}</b></h6></div>
                      <div>マッチングスコア: {{ user.score }}</div>
                      <div>
                        誰でも大歓迎です！discordで勉強配信するので気軽にサーバーに参加してください。たまにApexやるかドミニオンやるかもしれないです。学びたいスキルが被っている人は是非discord入ってきてください！
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-2 d-flex">
                          <a :href="'https://twitter.com/'+user.unique_id"><img class="rounded-circle" width="100" height="100" :src="'https://dnsk.jp/wp/wp-content/uploads/2018/05/blog_01.jpg'"></a>
                        </div>
                        <div class="col-md-10">
                          <h6 class="text-center"><b>提供できるスキル</b></h6>
                          <div class="card col-md-12 d-flex justify-content-around" style="border-style: none; background-color:transparent;">
                            <div class="card-body col-md-12 text-center" style="border-style:none;background-color:transparent;">
                              <span class="tag" v-for="(skill, index) in user.teachable_skills" :key="index">{{ skill.name }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="bg-info border-2 border-top border-gray">
                      <div class="col-md-12">
                        <h6><b>学びたいスキル</b></h6>
                        <div class="col-md-12 d-flex justify-content-around">
                          <div class="card col-md-12" style="border-style: none; background-color:transparent;">
                            <div class="card-body col-md-12 text-center" style="border-style:none;background-color:transparent;">
                              <span class="tag" v-for="(skill, index) in user.learnable_skills" :key="index">{{ skill.name }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 d-flex justify-content-around mt-1">
                        <p style="font-size:18px;" class='fab fa-twitter'><a class="ml-1" target="_blank" :href="'https://twitter.com/'+user.unique_id">Twitter</a></p>
                        <p style="font-size:18px;" class='fab fa-discord'><a class="ml-1" target="_blank" :href="'https://twitter.com/'+user.unique_id">Discord</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- マッチングした人のリストの枠 -->
        </div>
      </div>
      <div v-else>
        <div class="col-md-12 mt-5">
          <div class="card"> <!-- マッチングした人のリストの枠 -->
            <div class="card-header bg-info" style="color:white">ユーザー一覧</div>
            <div class="card-body">
              <div class="row d-flex align-item-center">
                <div v-for="(user, index) in users" :key="index" class="col-md-6">
                  <div class="card">
                    <div class="card-header" style="background-color:rgba(0, 0, 0,0.02)">
                      <div><h6><b>{{ user.name }}</b></h6></div>
                      <div><h6><b>{{ user.email }}</b></h6></div>
                      <div>マッチングスコア: {{ user.score }}</div>
                      <div>
                        誰でも大歓迎です！discordで勉強配信するので気軽にサーバーに参加してください。たまにApexやるかドミニオンやるかもしれないです。学びたいスキルが被っている人は是非discord入ってきてください！
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-2 d-flex">
                          <a :href="'https://twitter.com/'+user.unique_id"><img class="rounded-circle" width="100" height="100" :src="'https://dnsk.jp/wp/wp-content/uploads/2018/05/blog_01.jpg'"></a>
                        </div>
                        <div class="col-md-10">
                          <h6 class="text-center"><b>提供できるスキル</b></h6>
                          <div class="card col-md-12 d-flex justify-content-around" style="border-style: none; background-color:transparent;">
                            <div class="card-body col-md-12 text-center" style="border-style:none;background-color:transparent;">
                              <span class="tag" v-for="(skill, index) in user.teachable_skills" :key="index">{{ skill.name }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr class="bg-info border-2 border-top border-gray">
                      <div class="col-md-12">
                        <h6><b>学びたいスキル</b></h6>
                        <div class="col-md-12 d-flex justify-content-around">
                          <div class="card col-md-12" style="border-style: none; background-color:transparent;">
                            <div class="card-body col-md-12 text-center" style="border-style:none;background-color:transparent;">
                              <span class="tag" v-for="(skill, index) in user.learnable_skills" :key="index">{{ skill.name }}</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 d-flex justify-content-around mt-1">
                        <p style="font-size:18px;" class='fab fa-twitter'><a class="ml-1" target="_blank" :href="'https://twitter.com/'+user.unique_id">Twitter</a></p>
                        <p style="font-size:18px;" class='fab fa-discord'><a class="ml-1" target="_blank" :href="'https://twitter.com/'+user.unique_id">Discord</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- マッチングした人のリストの枠 -->
        </div>
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
        users: [],
        searchSkills: [], // ユーザーが入力したスキルを格納する配列
        skills: [],
        suggestedSkills: [],
        tmpSearchSkill: '',
      };
    },
    computed: {
      ...mapState(['user']),
      filteredUsers() {
        return this.users
          .map(user => ({
            ...user,
            score: this.calculateMatchingScore(user) // 各ユーザーのスコアを計算
          }))
          .filter(user => user.score > 0) // スコアが0より大きいユーザーのみを表示
          .sort((a, b) => b.score - a.score); // スコアが高い順にソート
      }
    },
    mounted() {
      this.fetchUsers();
      this.fetchSkills();
      this.searchSkills.push(...this.user.learnable_skills.map(skill => skill.name));
      console.log('さいしょ'+this.user.learnable_skills);
    },
    methods: {
      async fetchSkills() {
        try {
          const response = await axios.get('/api/skills');
          this.skills = response.data.skills.map(skill => skill.name);
        } catch (error) {
          console.error('スキルの取得に失敗しました:', error);
        }
      },
      fetchUsers() {
        axios.get('/api/users')
          .then(response => {
            this.users = response.data;
            console.log('Users:', this.users);
          })
          .catch(error => {
            console.error('Error fetching users:', error);
          });
      },
      async suggestSkills(term) {
        try {
          const response = await axios.get(`/api/skills?search=${term}`);
          this.suggestedSkills = response.data.map(skill => skill.name);
        } catch (error) {
          console.error('学びたいスキルのサジェストに失敗しました:', error);
        }
      },
      addSkill(skill) {
        if (skill.trim() !== '') {
          this.searchSkills.push(skill);
        }
        // this.clearSuggestLearnableSkills();
      },
      calculateMatchingScore(user) {
        let score = 0;

        // 教えられるスキルが、
        // user.teachable_skills.forEach(skill => {
        //   if (this.user.learnable_skills.some(learnableSkill => learnableSkill.name === skill.name)) {
        //     score += 1;
        //   }
        // });

        //自分の持っているスキルが相手の学びたいスキルと一致するかチェック
        this.user.teachable_skills.forEach(skill => {
          if (user.learnable_skills.some(learnableSkill => learnableSkill.name === skill.name)) {
            score += 1;
          }
        });

        // 学びたいスキルが、検索したスキルと一致するかチェック
        this.searchSkills.forEach(skill => {
          if (user.teachable_skills.some(teachableSkill => teachableSkill.name === skill)) {
            score += 1;
          }
        });

        return score;
      }, 
      // async clearSuggestLearnableSkills() {
      //   await this.$nextTick();
      //   this.newLearnableSkill = '';
      //   this.suggestedLearnableSkills = [];
      // },
    }
  }
  </script>

<style>
.tag {
  display: inline-block;
  margin: 0 .1em .6em 0;
  padding: .6em;
  line-height: 1;
  text-decoration: none;
  color: rgb(0, 71, 171);
  background-color: #fff;
  border: 1px solid rgb(0, 71, 171);
  border-radius: 2em;
}
</style>
  