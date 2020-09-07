<template>
    <v-container class="pa-10">
        <feed-section>
            <template v-slot:title>
                Latest Posts
            </template>
        </feed-section>
    </v-container>
</template>

<script>
    import FeedSection from "../components/FeedSection";

    export default {
        name: "Explore",
        components: {
            FeedSection
        }
    }
</script>

<style scoped>

</style>