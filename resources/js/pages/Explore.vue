<template>
    <v-container class="pa-10">
        <div class="mt-8">
            <v-row>
                <v-col>
                    <div class="title">Latest Posts</div>
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
                <v-col cols="3" v-for="(post, i) in posts" :key="i"  @click="togglePostModal(post)" class="mb-4">
                    <PostCard :image="post.image_path" />
                </v-col>
            </v-row>
            <div v-else-if="!isGridView" class="list-wrapper">
                <div class="list-item mb-10" v-for="(post, i) in posts" :key="i">
                    <PostFull :profile="post.author" :post="post" />
                </div>

            </div>
            <PostModal v-if="showModal" :profile="currentModalPost.author" :post="this.currentModalPost" :showModal="showModal" @closeModal="showModal = false"/>
        </div>
    </v-container>
</template>

<script>
    import PostModal from "../components/PostModal";
    import PostCard from "../components/PostCard";
    import PostFull from "../components/PostFull";

    export default {
        data: () => ({
            isGridView: true,
            currentModalPost: {},
            showModal: false,
            posts: [],
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
            },
            fetchData() {
                this.axios.get('/feed').then(res => {
                    this.posts = res.data.posts;
                }).catch(error => {
                    console.log('error');
                })
            }
        },
        mounted() {
            this.fetchData();
        },
        components: {
            PostModal,
            PostCard,
            PostFull
        },
    }
</script>

<style scoped>

</style>
