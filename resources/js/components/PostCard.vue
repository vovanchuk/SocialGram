<template>
    <v-card elevation="12" color="blue">
        <v-img height="250" :src="image" style="background-color: white;"></v-img>
    </v-card>
</template>

<script>
    export default {
        props: ["image"]
    }
</script>

<style scoped>

</style>
