<template>
    <div>
        <NavBar :is-logged-in="false"></NavBar>
        Home
    </div>
</template>

<script>
import NavBar from "../components/NavBar";

export default {
    name: "Home",
    components: {NavBar}
}
</script>

<style scoped>

</style>
