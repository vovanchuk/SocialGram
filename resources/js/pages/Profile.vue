<template>
    <v-container class="pa-10">
        <stories-section />
        <feed-section>
            <template v-slot:title>
                Latest Feed
            </template>
        </feed-section>
    </v-container>
</template>

<script>
    import StoriesSection from "../components/StoriesSection";
    import FeedSection from "../components/FeedSection";

    export default {
        beforeRouteEnter (to, from, next) {
            next(vm => {
                if(to.path === '/profile') {
                    next( { path: '/profile/'+ vm.$auth.user().username } );
                }
                else {
                    vm.$store.dispatch("profile/fetchProfile", to.params.username);
                    next();
                }
            })
        },
        beforeRouteUpdate (to, from, next) {
            this.$store.dispatch("profile/fetchProfile", to.params.username);
            next();
        },
        components: {
            StoriesSection,
            FeedSection
        },
    };
</script>

<style>
</style>
