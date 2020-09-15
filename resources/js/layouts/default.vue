<template>
    <div>
        <MainSideBar />
        <AppBar />
        <v-main>
            <router-view />
        </v-main>
    </div>
</template>

<script>
    import AppBar from "@/layouts/Components/AppBar";
    import MainSideBar from "@/layouts/Components/MainSideBar";

    export default {
        components: {
            MainSideBar,
            AppBar,
        },
    };
</script>

<style scoped>

</style>
