<template>
    <v-row>
        <v-col cols="12">
            <v-text-field
                v-model="message"
                append-outer-icon="mdi-send"
                hide-details="auto"
                label="Add comment"
                solo
                flat
                clear-icon="mdi-close-circle"
                clearable
                type="text"
                @click:append-outer="sendComment"
                @keydown.enter="sendComment"
            ></v-text-field>
        </v-col>
    </v-row>
</template>

<script>
    import HttpRequests from "../services/HttpRequests";

    export default {
        props: ['post'],
        data() {
            return {
                message: "",
            };
        },
        methods: {
            sendComment() {
                let formData = new FormData();
                formData.append('text', this.message);
                formData.append('post_id', this.post.id);

                HttpRequests.sendComment(formData).then(res => {
                    this.$store.commit('profile/APPEND_NEW_COMMENT', res.data.comment);
                    this.$toast.success(res.data.message);
                    this.message = ''
                }).catch(res => {
                    console.log(res);
                    this.$toast.error('Some error');
                })
            }
        },
    };
</script>

<style scoped></style>
