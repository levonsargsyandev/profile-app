<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="dark">
            <b-navbar-brand href="#">Profile App</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav v-if="!isLoggedIn" class="ml-auto">
                    <router-link to="/login" class="navbar-dark navbar-nav nav-link">Log In</router-link>
                    <router-link to="/register" class="navbar-dark navbar-nav nav-link">Register</router-link>
                </b-navbar-nav>
                <b-navbar-nav v-if="isLoggedIn" class="ml-auto">
                    <b-nav-item @click="logout" class="navbar-dark navbar-nav nav-link">Log Out</b-nav-item>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
import AuthService from "../services/AuthService";

export default {
    name: "NavBar",
    props: {
        isLoggedIn: {
            type: Boolean,
            required: true
        }
    },

    data(){
        return{
            authService: null

        }
    },

    mounted() {
        this.authService = new AuthService();
    },

    methods: {
        logout() {
            this.authService.logout(this.form).then(() => {
                this.$router.push('/');
            })
        },
    }

}
</script>

<style scoped>

</style>
