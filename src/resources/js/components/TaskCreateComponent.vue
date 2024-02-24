 <template>
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-sm-6">
                    <form v-on:submit.prevent="submit">
                         <div class="form-group row">
                             <label for="title" class="col-sm-3 col-form-label">Title</label>
                                     <input type="text" class="col-sm-9 form-control" id="title" v-model="task.title">
                         </div>
                         <div class="form-group row">
                             <label for="content" class="col-sm-3 col-form-label">Content</label>
                                     <input type="text" class="col-sm-9 form-control" id="content" v-model="task.content">
                         </div>
                         <div class="form-group row">
                             <label for="person-in-charge" class="col-sm-3 col-form-label">Person In Charge</label>
                                     <input type="text" class="col-sm-9 form-control" id="person-in-charge" v-model="task.person_in_charge">
                         </div>
                         <button type="submit" class="btn btn-primary">Submit</button>
                     </form>
                 </div>
             </div>
         </div>
     </template>
     
     <script>
            import axios from 'axios';
            import { mapState,mapActions } from 'vuex';
            export default {
                data: function () {
                    return {
                        task: {}
                    }
                },
                computed: {
                    ...mapState(['token', 'isLoggedIn']),
                },
                methods: {
                    ...mapActions(['loginUser']),
                    submit() {
                        axios.get('sanctum/csrf-cookie', { withCredentials: true })
                        .then((response) => {
                            axios.post('/api/tasks', this.task ,{
                                headers: {
                                    'Authorization': 'Bearer ' + this.token
                                }
                            })
                                .then((res) => {
                                    this.$router.push({name: 'task.list'});
                                });
                        }
                        ).catch(error => {
                            console.error('Error creating task:', error);
                        });
                    }
                },
                mounted() {
                    console.log(localStorage.getItem('auth_token'));
                    const token = localStorage.getItem('auth_token');
                    if (token) {
                        // トークンがあれば自動的にログイン状態にする処理を実行
                        this.loginUser(token);
                    }
                },
            }
     </script>
    