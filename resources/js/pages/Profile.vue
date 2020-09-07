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
        mounted() {
            // if (!this.$route.params.username) this.$route.params.username = this.$auth.user().username;
            // if (!this.$route.params.username){
            //     this.$router.push({name: 'userProfile', params: {
            //         username: this.$auth.user().username
            //         }})
            // }
            // if(!this.$route.params.username) return;
            // console.log('Dispatch: ' + this.$route.params.username);
            // this.$store.dispatch("profile/fetchProfile", this.$route.params.username);
        },
        beforeRouteEnter (to, from, next) {
            // TODO: FIX DOUBLE REQUEST
            next(vm => {
                if(to.path === '/profile') {
                    vm.$store.dispatch("profile/fetchProfile", vm.$auth.user().username);
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
