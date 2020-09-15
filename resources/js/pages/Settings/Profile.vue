<template>
    <v-card flat class="pl-10 pt-5">
        <v-card-text>
            <v-row align="center">
                <v-col cols="auto">
                    <v-avatar rounded="50" size="60">
                        <v-img :src="$auth.user().avatar"/>
                    </v-avatar>
                </v-col>
                <v-col cols="auto">
                    <div class="text-h6">{{ this.username }}</div>
                    <a @click="$refs.avatarUpload.click()">Change Profile Photo</a>
                    <input
                        type="file"
                        ref="avatarUpload"
                        v-show="false"
                        @change="onAvatarChange"
                        accept="image/*">
                </v-col>
            </v-row>
            <v-form class="mt-5">
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Title</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                            v-model="title"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Username</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                            v-model="username"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Website</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field
                            v-model="url"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Bio</span>
                    </v-col>
                    <v-col cols="8">
                        <v-textarea
                            auto-grow
                            row-height="6"
                            hide-details
                            dense
                            v-model="bio"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row align="center" class="mt-4">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Email</span>
                    </v-col>
                    <v-col cols="8">
                        <v-text-field disabled flat
                                      v-model="email"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn dark color="#ff4e6a" class="text-none ml-7 mb-5" elevation="6" @click="changeProfileInfo">
                <v-icon class="mx-2">mdi-content-save</v-icon>
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import HttpRequests from "../../services/HttpRequests";
    export default {
        data: () => ({
            title:      '',
            username:   '',
            url:        '',
            bio:        '',
            email:      '',
        }),
        mounted() {
            this.title      = this.$auth.user().title;
            this.username   = this.$auth.user().username;
            this.url        = this.$auth.user().url;
            this.bio        = this.$auth.user().description;
            this.email      = this.$auth.user().email;
        },
        methods: {
            changeProfileInfo() {
                let formData = new FormData();
                formData.append('username', this.username);
                formData.append('title', this.title);
                formData.append('url', this.url);
                formData.append('description', this.bio);

                HttpRequests.changeProfileInfo(formData).then((res) => {
                    this.$toast.success(res.data.message);
                    this.$auth.fetch();
                }).catch((err) => {
                    Object.entries(err.response.data.errors).forEach(([key, val]) => this.$toast.error(val[0]));
                })
            },
            onAvatarChange(e) {
                if (e.target.files[0] === undefined) {
                    return;
                }

                let formData = new FormData();
                formData.append('image', e.target.files[0]);

                HttpRequests.changeAvatar(formData).then((res) => {
                    this.$toast.success('Avatar changed!');
                    // this.$auth.user({avatar: res.data.avatar})
                    this.$auth.fetch();
                })
            }
        }
    }
</script>

<style scoped>
    .col {
        padding-top: 0;
        padding-bottom: 0;
    }
</style>
