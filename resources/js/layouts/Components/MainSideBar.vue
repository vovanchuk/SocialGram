<template>
    <v-navigation-drawer
            app
            color="grey lighten-5"
            class="pa-4"
            floating
            v-model="drawer"
            :permanent="$vuetify.breakpoint.mdAndUp"
    >
        <!--      logo-->
        <v-row>
            <div class="d-flex mt-2 mx-auto">
                <span style="border-right: 1px solid black;" class="pr-3"><strong>BuhoGram</strong></span>
                <img :src="require('@/assets/icon.svg')" class="w-100 ml-2"
                     style="max-height: 20px; max-width: 25px">
            </div>
        </v-row>

        <!--            user header-->
        <UserHeader/>

        <!--            main navigation-->
        <MainNav/>

    </v-navigation-drawer>
</template>

<script>
    import UserHeader from "@/layouts/Components/UserHeader";
    import MainNav from "@/layouts/Components/MainNav";

    export default {
        name: "MainSideBar",
        components: {
            MainNav,
            UserHeader
        },
        data: () => ({drawer: null})
    }
</script>

<style scoped>

</style>