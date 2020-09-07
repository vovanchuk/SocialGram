<template>
    <v-app-bar
        app
        color="white"
        flat
        clipped-right
    >
        <v-app-bar-nav-icon
            class="hidden-md-and-up"
        ></v-app-bar-nav-icon>
        <v-text-field
            label="Search..."
            solo
            flat
            dense
            prepend-inner-icon="mdi-magnify"
            clearable
            background-color="grey lighten-5"
            hide-details
            filled
            style="max-width: 300px;"
        ></v-text-field>


        <v-spacer></v-spacer>

        <v-btn dark color="#ff4e6a" class="text-none mr-5" elevation="6" to="/post/create"
               style="text-decoration: none;">
            <v-icon class="mr-4">mdi-plus</v-icon>
            Create New Post
        </v-btn>
        <v-btn icon class="mr-2">
            <v-icon>mdi-email-outline</v-icon>
        </v-btn>
        <v-btn icon class="mr-5">
            <v-icon>mdi-heart-outline</v-icon>
        </v-btn>
        <div>
            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <div v-bind="attrs"
                         v-on="on">
                        <v-avatar size="30">
                            <img
                                :src="$auth.user().avatar"
                            />
                        </v-avatar>
                        <v-icon>mdi-menu-down</v-icon>
                    </div>
                </template>
                <v-list>
                    <v-list-item
                        @click="logout()"
                    >
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>
    </v-app-bar>
</template>

<script>
    export default {
        methods: {
            logout() {
                this.$auth.logout()
            }
        }
    }
</script>

<style scoped>

</style>
