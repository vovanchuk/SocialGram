<template>
    <v-row justify="center">
        <v-dialog v-model="followersModal" scrollable max-width="400px">
            <v-card class="mx-auto">
                <v-list
                    two-line
                    avatar
                    flat
                >
                    <v-subheader>Users</v-subheader>
                    <div v-for="(user, i) in users" :key="i">
                        <v-divider
                            :key="i"
                        ></v-divider>
                        <v-list-item-group color="primary">
                            <v-list-item :key="user.id"
                                         @click="redirect(user.username)"
                            >
                                <v-list-item-avatar>
                                    <v-img :src="user.avatar"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="font-weight-bold">{{ user.username }}</v-list-item-title>
                                    <v-list-item-subtitle v-html="user.title"></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </div>
                </v-list>
            </v-card>
        </v-dialog>
    </v-row>
</template>


<script>
    export default {
        props: ['users', 'showModal'],
        computed: {
            followersModal: {
                get() {
                    return this.showModal;
                },
                set() {
                    this.$emit('closeModal');
                }
            }
        },
        methods: {
            redirect(username) {
                this.$emit('closeModal');
                this.$router.push(`/profile/${username}`);
            }
        }
    }
</script>

<style scoped>

</style>
