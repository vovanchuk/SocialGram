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
        <v-row>
            <v-col cols="12" class="pt-0 pb-0 px-4">
                <div>
                    <v-btn x-large icon @click="likeClicked">
                        <v-icon :color="isLiked? 'red' : ''">
                            {{ isLiked ? 'mdi-heart' : 'mdi-heart-outline' }}
                        </v-icon>
                    </v-btn>
                </div>
                <div class="ml-2" style="max-height: 150px; overflow-y: scroll">
                    <PostComments :comments="post.comments"/>
                </div>
                <div class="pt-0 pl-0 pb-0 mt-auto">
                    <CommentComposer :post="post"/>
                </div>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    import PostComments from "./PostComments";
    import CommentComposer from "./CommentComposer";
    // TODO: ADD DESCRIPTION TO POST
    export default {
        props: ['profile', 'post'],
        components: {PostComments, CommentComposer},
        methods: {
            likeClicked() {
                this.isLiked ? this.$store.dispatch('profile/unlikePost', this.post.id) : this.$store.dispatch('profile/likePost', this.post.id);
            }
        },
        computed: {
            isLiked() {
                return this.post.likes.findIndex(user => user.id === this.$auth.user().id) !== -1;
            }
        }
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
