<template>
    <v-dialog
        v-model="modalStatus"
        max-width="900"
        content-class="v-dialog--custom"
    >
        <v-container class="pa-0">
            <v-row>
                <v-col cols="8" class="pa-0">
                    <v-img :src="post.image_path"
                           max-height="90vh" width="100%"
                    ></v-img>
                </v-col>
                <v-col cols="4" class="pt-1">
                    <v-row class="d-flex flex-column">
                        <v-col
                            cols="auto"
                            class="pl-3 align-items-center"
                        >
                            <a :href="profile.username" class="text-decoration-none"
                            >
                                <v-avatar class="outlined" size="50">
                                    <v-avatar rounded="50" size="40">
                                        <v-img :src="profile.avatar"/>
                                    </v-avatar>
                                </v-avatar>
                                <strong class="ml-3" @click="$router.push(`/profile/${profile.username}`)">{{profile.username }}</strong>
                            </a
                            >
                        </v-col>
                        <v-col cols="auto">
                            {{ post.description }}
                        </v-col>
                        <v-spacer></v-spacer>
                        <v-col cols="auto">
                            Comments will become here
                        </v-col>
                        <v-col cols="auto">
                            comment composer will become here
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script>
    export default {
        props: ['profile', 'post', 'showModal'],
        data: () => ({}),
        computed: {
            modalStatus: {
                get() {
                    return this.showModal;
                },
                set() {
                    this.$emit('closeModal');
                }
            }
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
