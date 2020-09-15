<template>
    <div class="pr-2 h-100">
        <v-row v-for="comment in comments" :key="comment.id" class="mr-2">
            <v-col cols="auto" class="pr-0">
                <a
                    :href="'/profile/' + comment.author.username"
                    class="link-black"
                >{{ comment.author.username }}</a>
            </v-col>
            <v-col cols="auto">
                {{ comment.text }}
            </v-col>
            <v-spacer></v-spacer>
            <v-col cols="1" class="px-0">
                <v-btn icon color="grey" x-small @click="showCommentActions(comment)">
                    <v-icon>mdi-dots-horizontal</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <CommentActions :comment="comment" :actionsModal="actionsModal" @actions-close="actionsModal = false" />
    </div>
</template>

<script>
    import CommentActions from "./CommentActions";

    export default {
        components: {CommentActions},
        props: {
            comments: {
                required: true,
            },
        },
        data() {
            return {
                actionsModal: false,
                comment: {}
            }
        },
        methods: {
            showCommentActions(data) {
                this.comment = data
                this.actionsModal = true
            },
        },
    };
</script>

<style scoped>
    .link-black {
        color: black;
        font-weight: bold;
    }
</style>
