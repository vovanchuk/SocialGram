<template>
    <v-dialog
        v-model="modalStatus"
        max-width="1000"
        content-class="v-dialog--custom"
    >
        <v-container class="pa-0">
            <v-row>
                <v-col cols="8" class="pa-0">
                    <v-img ref="post_img" :src="post.image_path"
                           max-height="90vh" width="100%" @load="setCommentStyle"
                    ></v-img>
                </v-col>
                <v-col cols="4" class="pt-4 pb-0 px-4 d-flex flex-column" :style="styleObj">
                        <div class="align-items-center">
                            <a :href="profile.username" class="text-decoration-none"
                            >
                                <v-avatar class="outlined" size="50">
                                    <v-avatar rounded="50" size="40">
                                        <v-img :src="profile.avatar"/>
                                    </v-avatar>
                                </v-avatar>
                                <strong class="ml-3" @click="$router.push(`/profile/${profile.username}`)">{{profile.username
                                    }}</strong>
                            </a
                            >
                        </div>
                        <div class="my-3 mx-2">
                            {{ post.description }}
                        </div>
                        <div style="overflow-y: scroll">
                            <PostComments :comments="post.comments"/>
                        </div>
                        <div class="pt-0 pl-0 pb-0 mt-auto">
                            <CommentComposer :post="post"/>
                        </div>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script>
    import PostComments from "./PostComments";
    import CommentComposer from "./CommentComposer";

    export default {
        components: {PostComments, CommentComposer},
        props: ['profile', 'post', 'showModal'],
        data: () => ({
            styleObj: {}
        }),
        computed: {
            modalStatus: {
                get() {
                    return this.showModal;
                },
                set() {
                    this.$emit('closeModal');
                }
            }
        },
        methods: {
            setCommentStyle() {
                setTimeout(()=>{
                    this.styleObj = {height: this.$refs.post_img.$el.clientHeight + "px"};
                }, 100)

            },

        }
    }
</script>

<style scoped>
    strong {
        text-decoration: none;
        color: black;
    }

    .v-avatar.outlined {
        border: 2px solid #e7596f;
        background-color: transparent;
        border-radius: 50%;
        height: 100px;
        width: 100px
    }
</style>
