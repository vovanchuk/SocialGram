<template>
    <div class="mt-8">
        <v-row>
            <v-col>
                <div class="title"><slot name="title"></slot></div>
            </v-col>
            <v-col class="text-right">
                <v-btn :color="getColorAttr('listView')" icon @click="isGridView = false" >
                    <v-icon>mdi-menu</v-icon>
                </v-btn>
                <v-btn :color="getColorAttr('gridView')" icon @click="isGridView = true">
                    <v-icon>mdi-view-grid-outline</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <v-row v-if="isGridView">
            <v-col cols="3" v-for="(post, i) in profilePosts" :key="i"  @click="togglePostModal(post)" class="mb-4">
                <PostCard :image="post.image_path" />
            </v-col>
        </v-row>
        <div v-else-if="!isGridView" class="list-wrapper">
            <div class="list-item mb-10" v-for="(post, i) in profilePosts" :key="i">
                <PostFull :profile="profileInfo" :post="post" />
            </div>

        </div>
        <PostModal v-if="showModal" :profile="profileInfo" :post="this.currentModalPost" :showModal="showModal" @closeModal="showModal = false"/>
    </div>
</template>

<script>
    import PostModal from "./PostModal";
    import PostCard from "./PostCard";
    import PostFull from "./PostFull";
    import { mapGetters } from "vuex";

    export default {
        data: () => ({
            isGridView: true,
            currentModalPost: {},
            showModal: false,
        }),
        methods: {
            setModalPost(post) {
                this.currentModalPost = post;
            },
            togglePostModal(post) {
                this.setModalPost(post);
                this.showModal = true;
            },
            getColorAttr(button) {
                let color;
                if (button === 'listView') {
                    color = this.isGridView ? '' : '#E7596F';
                }
                else if (button === 'gridView') {
                    color = this.isGridView ? '#E7596F' : '';
                }
                return color;
            }
        },
        computed: {
            ...mapGetters("profile", [
                "profileInfo",
                "profilePosts",
            ]),
        },
        components: {
            PostModal,
            PostCard,
            PostFull
        }
    };
</script>

<style>
    .v-dialog--custom {
        background-color: white;
        max-height: 100vh;
        overflow-x: hidden;
        /*overflow-y: hidden;*/
    }
    .list-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>
