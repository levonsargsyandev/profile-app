<template>
    <div>
        <NavBar :is-logged-in="true"></NavBar>
        Dashboard of user
    </div>
</template>

<script>

import NavBar from "../components/NavBar";
import UserService from "../services/UserService";

export default {
    name: "Dashboard",
    components: {NavBar},
    data() {
        return {
            user: null
        }
    },

    mounted() {
        this.authService = new UserService();
        this.getUser();

    },

    methods: {
        getUser(){
            this.authService.getUser().then((response)=>{
                console.log(response, "response");
            })
        }
    }
}
</script>

<style scoped>

</style>
