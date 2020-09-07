<template>
    <v-container class="pa-10">
        <feed-section>
            <template v-slot:title>
                Your Feed
            </template>
        </feed-section>
    </v-container>
</template>

<script>
    import FeedSection from "../components/FeedSection";

    export default {
        name: "Feed",
        components: {
            FeedSection
        },
    }
</script>

<style scoped>

</style>
