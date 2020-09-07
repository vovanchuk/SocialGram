<template>
    <v-card flat class="pl-10">
        <v-card-text>
            <v-form>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Old password</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                                v-model="oldPassword"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">New Password</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                                v-model="newPassword"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Confirm password</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                                v-model="confPassword"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn dark color="#ff4e6a" class="text-none ml-7 mb-5" elevation="6">
                <v-icon class="mx-2">mdi-content-save</v-icon>Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "Password",
        data: () => ({
            oldPassword: '',
            newPassword: '',
            confPassword: ''
        })
    }
</script>

<style scoped>

</style>