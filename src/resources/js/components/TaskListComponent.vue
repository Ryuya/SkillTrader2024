<template>
    <div class="container">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Person In Charge</th>
                <th scope="col">Show</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" :key="index">
                    <th scope="row">{{ task.id }}</th>
                    <td>{{ task.title }}</td>
                    <td>{{ task.content }}</td>
                    <td>{{ task.person_in_charge }}</td>
                    <td>
                        <router-link v-bind:to="{name: 'task.show', params: {taskId: task.id }}">
                            <button class="btn btn-primary">Show</button>
                        </router-link>
                    </td>
                    <td>
                        <router-link v-bind:to="{name: 'task.edit', params: {taskId: task.id }}">
                            <button class="btn btn-success">Edit</button>
                        </router-link>
                    </td>
                    <td>
                        <button class="btn btn-danger" v-on:click="deleteTask(task.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';
import { mapState,mapActions } from 'vuex';
export default {
    data() {
        return {
            tasks: []
        };
    },
    computed: {
        ...mapState(['token', 'isLoggedIn']),
    },
    methods: {
        ...mapActions(['loginUser']),
        getTasks() {
            axios.get('sanctum/csrf-cookie', { withCredentials: true })
            .then((response) => {
            axios.get('/api/tasks', {
                headers: {
                    'Authorization': 'Bearer ' + this.token
                }
            })
            .then((res) => {
                this.tasks = res.data;
            })
            .catch((error) => {
                console.error('Error fetching tasks:', error);
            });    
            })
            
        },
        deleteTask(id) {
            axios.delete('/api/tasks/' + id)
            .then((res) => {
                this.getTasks();
            })
            .catch((error) => {
                console.error('Error deleting task:', error);
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
        this.getTasks();
    }
}
</script>
