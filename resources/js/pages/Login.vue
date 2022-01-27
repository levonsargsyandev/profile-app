<template>
    <div class="login-form-block">
        <h3 class="text-center mb-4">Login</h3>
        <b-form @submit.prevent="login">
            <b-form-group label="Email *">
                <b-form-input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group label="Password *">
                <b-form-input
                    v-model="form.password"
                    placeholder="Password"
                    required
                ></b-form-input>
                <p v-if="isIncorrect" class="text-danger small px-1 pt-1">{{isIncorrect}}</p>
            </b-form-group>

            <div class="mt-4">
                <p class="text-muted small float-left">Don't have an account? <router-link to="/register">Register</router-link></p>
                <b-button type="submit" size="sm" variant="primary" class="float-right">Login</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
import AuthService from "../services/AuthService";

export default {
    name: "Login",
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            isIncorrect: '',
            authService: null
        }
    },

    mounted() {
        this.authService = new AuthService();
    },

    methods: {
        login() {
            this.authService.auth().then(()=> {
                this.authService.login(this.form).then((response) => {
                    if (response && response.data.success) {
                        this.isIncorrect = '';
                        let user = JSON.stringify(response.data.user);
                        localStorage.setItem('user', user);
                        this.$router.push('/dashboard');
                    } else {
                        this.isIncorrect = 'The given data was invalid.';
                    }
                }).catch((error) => {
                    this.isIncorrect = error.response.data.message;
                })
            })
        },
    }
}
</script>

<style scoped>
.login-form-block {
    width: 500px;
    margin: 10% auto 0;
}
</style>
