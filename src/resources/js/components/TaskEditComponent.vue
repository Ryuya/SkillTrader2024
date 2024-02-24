 <template>
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-sm-6">
                    <form v-on:submit.prevent="submit">
                         <div class="form-group row">
                             <label for="id" class="col-sm-3 col-form-label">ID</label>
                             <input type="text" class="col-sm-9 form-control-plaintext" readonly id="id" v-model="task.id">
                         </div>
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
             props: {
                taskId: {
                    type: [String, Number],
                    required: true
                }
             },
                     data: function () {
            return {
                task: {}
            }
        },
        computed: {
            ...mapState(['token', 'isLoggedIn']),
        },

        methods: {
            getTask() {
                axios.get('sanctum/csrf-cookie', { withCredentials: true })
                .then((response) => {
                axios.get('/api/tasks/' + this.taskId, {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                }).then((res) => {
                        this.task = res.data;
                    });
                });
            },
            submit() {
                axios.get('sanctum/csrf-cookie', { withCredentials: true })
                .then((response) => {
                axios.put('/api/tasks/' + this.taskId, this.task, {
                    headers: {
                    'Authorization': 'Bearer ' + this.token
                }}).then((res) => {
                        this.$router.push({name: 'task.list'})
                    });
                });
            }
        },
        mounted() {
            this.getTask();
        }
         }
     </script>
    