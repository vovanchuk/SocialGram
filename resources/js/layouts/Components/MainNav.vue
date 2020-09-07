<!--E7596F-->
<template>
    <v-list nav dense>
        <v-list-item-group v-model="selected" active-class="red--text" >
            <v-list-item to="/feed" >
                <v-list-item-icon>
                    <v-icon>mdi-home-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Feed</v-list-item-title>
            </v-list-item>
            <v-list-item to="/explore">
                <v-list-item-icon>
                    <v-icon>mdi-compass-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Explore</v-list-item-title>
            </v-list-item>
            <v-list-item to="/profile">
                <v-list-item-icon>
                    <v-icon>mdi-pound</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Trending</v-list-item-title>
            </v-list-item>
            <v-list-item to="/">
                <v-list-item-icon>
                    <v-icon>mdi-check-decagram</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Top Post (/)</v-list-item-title>
            </v-list-item>
            <v-list-item to="/welcome">
                <v-list-item-icon>
                    <v-icon>mdi-account-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>People (welcome)</v-list-item-title>
            </v-list-item>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-bell-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Notification</v-list-item-title>
            </v-list-item>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-send-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Direct</v-list-item-title>
            </v-list-item>
            <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-chart-pie</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Status</v-list-item-title>
            </v-list-item>
            <v-list-item to="/settings">
                <v-list-item-icon>
                    <v-icon>mdi-cog-outline</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Settings</v-list-item-title>
            </v-list-item>
        </v-list-item-group>
    </v-list>
</template>

<script>
    export default {
        name: "MainNav",
        data: () => ({
            selected: null,
        })
    }
</script>

<style scoped>

</style>