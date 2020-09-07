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
    // import RightBar from "@/layouts/Components/RightBar";
    import AppBar from "@/layouts/Components/AppBar";
    import MainSideBar from "@/layouts/Components/MainSideBar";

    export default {
        name: 'DefaultLayout',
        components: {
            MainSideBar,
            AppBar,
            // RightBar
        },
    };
</script>

<style scoped>

</style>
