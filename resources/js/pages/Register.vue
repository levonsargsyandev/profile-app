<template>
    <div class="register-form-block">
        <h3 class="text-center mb-4">Register</h3>
        <b-form @submit.prevent="onSubmit">
            <b-form-group label="First Name *">
                <b-form-input
                    v-model="form.firstName"
                    placeholder="First Name"
                ></b-form-input>
                <p v-if="errors.firstName" class="text-danger small px-1 pt-1">{{ errors.firstName[0] }}</p>
            </b-form-group>
            <b-form-group label="Email *">
                <b-form-input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    required
                ></b-form-input>
                <p v-if="errors.email" class="text-danger small px-1 pt-1">{{ errors.email[0] }}</p>
            </b-form-group>
            <b-form-group label="Password (min 6 symbols) *">
                <b-form-input
                    v-model="form.password"
                    placeholder="Password (min 6 symbols)"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group>
                <b-form-input
                    v-model="form.password_confirmation"
                    placeholder="Confirm password"
                    required
                ></b-form-input>
                <p v-if="errors.password" class="text-danger small px-1 pt-1">{{ errors.password[0] }}</p>
            </b-form-group>

            <div class="mt-4">
                <p class="text-muted small float-left">Already have an account? <router-link to="/login">Login</router-link></p>
                <b-button type="submit" size="sm" variant="primary" class="float-right">Register</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
import AuthService from "../services/AuthService";

export default {
    name: "Register",
    data() {
        return {
            form: {
                firstName: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            authService: null,
            errors: []
        }
    },

    mounted() {
        this.authService = new AuthService();
    },

    methods: {
        onSubmit() {
            this.authService.register(this.form).then((response) => {
                if(response.data.success){
                    this.authService.auth().then(()=> {
                        this.authService.login(this.form).then((response) => {
                            if (response.data.success) {
                                let user = JSON.stringify(response.data.user);
                                localStorage.setItem('user', user);
                                this.$router.push('/dashboard');
                            }
                        })
                    })
                }
            }).catch((error) => {
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>

<style scoped>
.register-form-block {
    width: 500px;
    margin: 10% auto 0;
}
</style>
