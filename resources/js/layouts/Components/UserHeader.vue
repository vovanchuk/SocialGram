<template>
    <v-row class="mt-10">
        <v-col align="center">
            <div style="cursor: pointer" @click="$router.push({name: 'profile'}).catch(err => {})">
                <v-avatar class="outlined" size="80">
                    <v-avatar size="70">
                        <v-img
                               :src="$auth.user().avatar"
                        />
                    </v-avatar>
                </v-avatar>


                <div class="mt-4 title">{{ getTitle }}</div>
                <div class="mt-1 subtitle-2 grey--text">{{ $auth.user().url }}</div>
            </div>
            <div class="mt-5">
                <v-row>
                    <v-col>
                        <div class="subtitle-2">Post</div>
                        <div class="subtitle-2 grey--text">{{ $auth.user().posts.length }}</div>
                    </v-col>
                    <v-col>
                        <div class="subtitle-2">Followers</div>
                        <div class="subtitle-2 grey--text">{{$auth.user().followers.length}}</div>
                    </v-col>
                    <v-col>
                        <div class="subtitle-2">Following</div>
                        <div class="subtitle-2 grey--text">{{$auth.user().followings.length}}</div>
                    </v-col>
                </v-row>
            </div>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        computed: {
            getTitle() {
                return this.$auth.user() ? this.$auth.user().title ? this.$auth.user().title : this.$auth.user().username : 'default'
            }
        }
    }
</script>

<style scoped>
    .v-avatar.outlined {
        border: 2px solid #e7596f;
        background-color: transparent;
        border-radius: 50%;
        height: 100px;
        width: 100px
    }
</style>
