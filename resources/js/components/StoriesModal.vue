<template>
    <v-dialog
        v-model="modalStatus"
        v-if="currentSlide"
        content-class="stories-dialog"
        max-width="56vh"
    >
        <v-card height="100%"
                width="56vh"
                style="border: 1px solid black;"
                class="mx-auto story"
                :img="currentSlide.type === 'image' ? currentSlide.url : ''"
        >
            <video ref="videoStory" v-if="currentSlide.type === 'video'" :src="currentSlide.url" autoplay playsinline
                   muted @click="slideClicked"
                   @mousedown="mouseDown"></video>
            <!--                <v-img v-if="currentSlide.type === 'image'" :src="currentSlide.url" @click="slideClicked" @mousedown="mouseDown" class="story-image"></v-img>-->
            <div class="timeline">
                <div class="slice" v-for="(slide, i) in slides" :key="i">
                    <div class="progress">&nbsp;</div>
                </div>
            </div>
            <div class="user-info ml-4 mt-1">
                <div @click="$router.push(`/profile/${profile.username}`)" class="white--text">
                    <v-avatar rounded="50" size="40">
                        <v-img :src="profile.avatar"/>
                    </v-avatar>
                    <strong class="ml-2 stroke">{{ profile.username }}</strong>
                </div>
            </div>
            <div class="slide" @click="slideClicked" @mousedown="mouseDown">

            </div>
            <v-btn x-large icon v-if="currentSlide.type === 'video'" class="text-none stroke"
                   @click="$refs.videoStory.muted = !$refs.videoStory.muted">
                <v-icon color="white" class="stroke">mdi-volume-high</v-icon>
            </v-btn>
        </v-card>
    </v-dialog>
</template>

<script>
    import anime from "animejs";

    const IMAGE_DURATION = 3000;

    export default {
        props: {
            slides: Array,
            profile: Object,
            showModal: Boolean,

        },
        data: () => ({
            timeline: anime.timeline({
                autoplay: false,
                easing: 'linear'
            }),
            currentSlideIndex: 0,
            pressDetect: false,
            pressFunc: null,
            watchedStories: [],
        }),
        mounted() {
            let $timeline = document.getElementsByClassName('timeline')[0];

            // Add progress bars to the timeline animation group
            this.slides.forEach((slide, index) => {
                this.timeline.add({
                    targets: $timeline.getElementsByClassName('slice')[index].getElementsByClassName('progress'),
                    width: '100%',
                    duration: slide.type === 'video' ? slide.duration * 1000 : IMAGE_DURATION,
                    changeBegin: () => {
                        this.currentSlideIndex = index;
                        this.watchedStories.push(slide.id);
                    },
                    complete: () => {
                        if (index === this.slides.length - 1) {
                            // this.nextStory();
                            this.closeModal();
                        }
                    }
                });
            });
            this.timeline.play();
        },
        methods: {
            mouseDown(e) {
                if (this.pressDetect === false) {
                    this.pressFunc = setTimeout(() => {
                        this.pressDetect = true;
                        this.timeline.pause();
                        if (e.target.tagName === 'VIDEO') this.$refs.videoStory.pause();
                    }, 150)
                }
            },
            preloadNext() {
                if (this.currentSlideIndex === this.slides.length - 1) return;
                let img = new Image();

                img.onload = () => {
                    console.log('img preloaded');
                }
                img.src = this.slides[this.currentSlideIndex + 1].url;
            },
            slideClicked(e) {
                clearTimeout(this.pressFunc);
                this.pressFunc = null;
                if (this.pressDetect) {
                    this.pressDetect = false;
                    this.timeline.play();
                    if (e.target.tagName === 'VIDEO') this.$refs.videoStory.play();
                    return;
                }
                e.offsetX > e.target.clientWidth / 2 ? this.nextSlide() : this.prevSlide();
            },
            nextSlide() {
                if (this.currentSlideIndex < this.slides.length - 1) {
                    this.currentSlideIndex++;
                    this.resetSlide();
                } else {
                    console.log('close stories');
                    this.closeModal();
                }
            },
            prevSlide() {
                if (this.currentSlideIndex > 0) {
                    this.currentSlideIndex = this.currentSlideIndex - 1;
                    this.resetSlide();
                } else {
                    // this.previousStory();
                    console.log('prev story');
                }
            },
            resetSlide() { // Jump to beginning of the slide
                this.timeline.pause();
                let seek = 0;
                for (let i = 0; i < this.currentSlideIndex; i++)
                    seek += this.timeline.children[i].duration;
                this.timeline.seek(seek + 1);
                this.timeline.play();
            },
            closeModal() {
                this.timeline.pause();
                this.$store.dispatch("profile/markStoryViewed", this.watchedStories);
                this.$emit('closeModal');
            }
        },
        computed: {
            currentSlide() {
                // this.preloadNext();
                return this.slides[this.currentSlideIndex];
            },
            modalStatus: {
                get() {
                    return this.showModal;
                },
                set() {
                    this.closeModal();
                }
            }
        },
    }
</script>

<style>
    .stories-dialog {
        height: 98vh;
        overflow-x: hidden;
        /*overflow-y: hidden;*/
    }
</style>

<style scoped>
    video {
        object-fit: scale-down;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    .story-image {
        object-fit: scale-down;
        width: 100%;
        height: 100%;
        position: absolute;
    }

    .story {
        display: flex;
        flex-direction: column;
        background-color: black;
    }

    .timeline {
        display: flex;
        width: 100%;
    }

    .timeline > .slice {
        background: rgba(0, 0, 0, 0.3);
        height: 6px;
        margin: 8px 4px;
        width: 100%;
    }

    .timeline > .slice > .progress {
        background: rgba(170, 180, 199, 0.9);
        height: 6px;
        width: 0%;
    }

    .slide {
        /* Take the rest of the page */
        flex-grow: 1;
    }

    .stroke {
        color: white;
        text-shadow: -1px -1px 0 #000,
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
    }
</style>
