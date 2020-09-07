<template>
    <v-card max-width="70%" class="mx-auto mt-10">
        <v-row>
            <v-col cols="3" style="border-right: 1px solid lightgray">
                <v-list nav dense>
                    <v-list-item-group v-model="selected" active-class="red--text" >
                        <v-list-item to="/settings/profile" >
                            <v-list-item-icon>
                                <v-icon>mdi-account-circle</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Edit Profile</v-list-item-title>
                        </v-list-item>
                        <v-list-item to="/settings/password">
                            <v-list-item-icon>
                                <v-icon>mdi-key</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Change Password</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon>mdi-pound</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Coming Soon</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-col>
            <v-col cols="9">
                <router-view></router-view>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        data: () => ({
            selected: null,
        })
    }
</script>

<style scoped>

</style>
