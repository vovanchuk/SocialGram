<template>
    <v-card elevation="12" width="800px">
        <v-row align="center" class="mx-0">
            <v-col cols="auto pr-0">
                <v-avatar class="outlined" size="50">
                    <v-avatar rounded="50" size="40">
                        <v-img :src="profile.avatar" />
                    </v-avatar>
                </v-avatar>
            </v-col>
            <v-col cols="4">
                <strong class="link-black" @click="$router.push(`/profile/${profile.username}`)">{{ profile.username }}</strong>
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="1" class="mr-2">
                <v-btn icon>
                    <v-icon>
                        mdi-dots-horizontal
                    </v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-row class="mx-0">
            <v-col cols="12" class="pa-0">
                <v-img
                        :src="post.image_path"
                        style="width: 100%;"
                        contain
                        min-width="100%"
                ></v-img>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        props: ['profile', 'post']
    }
</script>

<style scoped>
    .link-black {
        color: black;
        font-weight: bold;
        cursor: pointer;
    }
    .v-avatar.outlined {
        border: 2px solid #e7596f;
        background-color: transparent;
        border-radius: 50%;
        height: 100px;
        width: 100px
    }
</style>
