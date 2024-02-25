<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <!-- <div class="card-header">{{ pageTitle }}</div> -->

                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" v-model="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" v-model="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" v-model="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            password: '',
        };
    },
    computed: {
        ...mapState(['isLoggedIn', 'token']),
    },
    methods: {
        ...mapActions(['loginUser']),
        register() {
            // ユーザー登録の実装
            // ここで、email と password の値を使ってユーザー登録リクエストをサーバーに送信します
            const registerData = {
                name: this.name,
                email: this.email,
                password: this.password,
            };

            // ユーザー登録のAPIリクエストを行うための処理を実装します
            // 例えば、axiosを使用してAPIにPOSTリクエストを送信するなど
            // この例では、axiosを使用してAPIにPOSTリクエストを送信しています
            axios.post('/api/register', registerData, { withCredentials: true })
                .then(response => {
                    // ユーザー登録成功時の処理をここに記述
                    console.log('Registration successful');
                    this.loginUser(response.data.api_token);
                    localStorage.setItem('auth_token', response.data.token);
                    this.$router.push({ name: 'user.edit' });
                })
                .catch(error => {
                    console.error('Error registering:', error);
                });
        }
    }
};

</script>