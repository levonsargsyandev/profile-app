<template>
    <div>
        <NavBar></NavBar>
    </div>
</template>

<script>
import NavBar from "../components/NavBar";

export default {
    name: "Home",
    components: {NavBar},

    mounted() {
        this.getUser();
    },

    methods: {
        getUser() {
            this.user = JSON.parse(localStorage.getItem('user'));
            if (!this.user || !this.user.id) {
                return this.$router.push('/login');
            }
        }
    }

}
</script>

<style scoped>

</style>
