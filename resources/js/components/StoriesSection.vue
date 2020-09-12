<template>
    <div class="ml-5">
        <v-row>
            <v-col class="pa-0 align-self-center">
                <div class="title">Featured Stories</div>
            </v-col>
            <v-col class="d-flex justify-end py-0 pr-10">
                <v-btn outlined class="text-none" color="#ff4e6a" @click="$refs.storyUpload.click()">
                    <v-icon>mdi-plus-circle-outline</v-icon>
                    <span class="ml-2">Upload Story</span>
                    <input
                        type="file"
                        ref="storyUpload"
                        v-show="false"
                        @change="onStoryChange"
                    >
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify-start class="mt-7">
            <v-slide-group
                class="pa-4"
                show-arrows
            >
                <v-slide-item
                    v-for="(story, index) in storyFeed" :key="story.id"
                >
                    <v-card elevation="12" height="230" width="170" color="blue" class="mr-4 story-viewed" @click="toggleStoriesModal(story)">
                        <v-img
                            height="230"
                            :src="story.type === 'video' ? story.preview_url : story.url"
                            :gradient="story.isViewed ? 'to top right, rgba(51, 54, 71, 0.65), rgba(25,32,72,.7)' : ''"
                        ></v-img>
                    </v-card>
                </v-slide-item>
            </v-slide-group>
        </v-row>
        <StoriesModal v-if="showModal" :profile="profileInfo" :slides="storiesSlides" :showModal="showModal" @closeModal="showModal = false"/>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import StoriesModal from "./StoriesModal";

    export default {
        data:() => ({
            clickedStory: {},
            showModal: false,
        }),
        components: {StoriesModal},
        computed: {
            ...mapGetters("profile", ["storyFeed", "activeViewed", "activeUnviewed", "profileInfo", "storiesFavorited"]),
            storiesSlides(){
                let stories = [];
                stories = this.clickedStory.favorited ? [...this.storiesFavorited] : (this.clickedStory.isViewed ? [...this.activeViewed] : [...this.activeUnviewed]);
                let currentIndex = stories.findIndex(story => story.id === this.clickedStory.id);
                if (currentIndex === -1) return [];
                this.$swap(stories, 0, currentIndex);
                return stories;
                // if(this.clickedStory.isViewed) {
                //     let viewed = [...this.activeViewed];
                //     let currentIndex = viewed.findIndex(story => story.id === this.clickedStory.id);
                //     if (currentIndex === -1) return;
                //     this.swap(viewed, 0, currentIndex);
                //     return viewed;
                // } else {
                //     let unviewed = [...this.activeUnviewed];
                //     let currentIndex = unviewed.findIndex(story => story.id === this.clickedStory.id);
                //     if (currentIndex === -1) return;
                //     this.swap(unviewed, 0, currentIndex);
                //     return unviewed;
                // }
            }
        },
        methods: {
            onStoryChange(e) {
                if (e.target.files[0] === undefined) return;
                let formData = new FormData();
                formData.append("file", e.target.files[0]);
                this.$store.dispatch("profile/uploadStory", formData);
            },
            toggleStoriesModal(story) {
                console.log(story)
                this.clickedStory = story;
                this.showModal = true;
            }
        }
    }
</script>

<style scoped>
</style>
