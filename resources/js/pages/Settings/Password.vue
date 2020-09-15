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
                                v-model="newPassword_confirmation"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn dark color="#ff4e6a" class="text-none ml-7 mb-5" elevation="6" @click="changePassword">
                <v-icon class="mx-2">mdi-content-save</v-icon>Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import HttpRequests from "../../services/HttpRequests";

    export default {
        name: "Password",
        data: () => ({
            oldPassword: '',
            newPassword: '',
            newPassword_confirmation: '',
        }),
        methods: {
            changePassword() {
                if(this.newPassword !== this.newPassword_confirmation){
                    this.$toast.error('Passwords must match!', {timeout: 1000})
                } else {
                    const data = new FormData();
                    data.append('oldPassword', this.oldPassword);
                    data.append('newPassword', this.newPassword);
                    data.append('newPassword_confirmation', this.newPassword_confirmation);
                    HttpRequests.changePassword(data).then((res) => {
                        if(res.data.status === 'success') this.$toast.success('Password changed!');
                        this.oldPassword = '';
                        this.newPassword = '';
                        this.newPassword_confirmation = '';
                    }).catch((err) => {
                        console.log(err.response.data);
                        this.$toast.error(err.response.data.message);
                    })

                }

            }
        }
    }
</script>

<style scoped>

</style>
