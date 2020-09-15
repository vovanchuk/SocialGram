<template>
    <v-dialog persistent v-model="actionsModal" max-width="600px">
        <v-card>
            <v-col class="text-center px-0 py-2" cols="12">
                <div v-for="action in actions" :key="action.id">
                    <v-btn
                        height="50"
                        tile
                        block
                        text
                        color="error"
                        @click="action.payload()"
                    >{{ action.text }}
                    </v-btn>
                    <hr />
                </div>
            </v-col>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: ["actionsModal", "comment"],
        computed: {
            actions() {
                if (!this.notEmptyObject(this.comment)) return [];

                let actionList = [
                    {
                        id: 0,
                        text: "Report",
                        payload: () => {
                            this.sendCommentReport();
                            this.$emit('actions-close');
                        },
                        condition: () => {
                            return true;
                        },
                    },
                    {
                        id: 1,
                        text: "Remove",
                        payload: () => {
                            this.removeComment();
                            this.$emit("actions-close");
                        },
                        condition: () => {
                            return this.$auth.user().id === this.comment.author.id;
                        },
                    },
                    {
                        id: 2,
                        text: "Cancel",
                        payload: () => {
                            this.$emit("actions-close");
                        },
                        condition: () => {
                            return true;
                        },
                    },
                ];
                let final_actions = [];
                for (let i = 0; i < actionList.length; i++) {
                    if (actionList[i].condition()) {
                        final_actions.push(actionList[i]);
                    }
                }
                return final_actions;
            },
        },
        methods: {
            sendCommentReport() {
                console.log('Report: ' + this.comment)
            },
            removeComment() {
                console.log('Remove: ' + this.comment)
            }
        }
    };
</script>

<style scoped>
    hr {
        margin: 0;
    }
</style>
