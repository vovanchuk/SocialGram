<template>
    <div>
        <MainSideBar />
        <AppBar />
        <RightBar/>
        <v-main>
            <router-view />
        </v-main>
    </div>
</template>

<script>
    import RightBar from "@/layouts/Components/RightBar";
    import MainSideBar from "@/layouts/Components/MainSideBar";
    import AppBar from "@/layouts/Components/AppBar";

    export default {
        components: {
            MainSideBar,
            AppBar,
            RightBar
        },
        data: () => ({
            // drawer: null
        }),
    }
</script>

<style scoped>

</style>
