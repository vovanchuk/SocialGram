<template>
    <v-card height="100%"
            width="56vh"
            style="border: 1px solid black;"
            class="mx-auto story"
            :img="currentSlide"
    >
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
    </v-card>
</template>

<script>
    import anime from "animejs";

    const SLIDE_DURATION = 2000;

    export default {
        props: {
            slides: Array,
            profile: Object,
        },
        data: () => ({
            timeline: anime.timeline({
                autoplay: false,
                easing: 'linear'
            }),
            currentSlideIndex: 0,
            pressDetect: false,
            pressFunc: null
        }),
        mounted() {
            let $timeline = this.$el.getElementsByClassName('timeline')[0];

            // Add progress bars to the timeline animation group
            this.slides.forEach((color, index) => {
                this.timeline.add({
                    targets: $timeline.getElementsByClassName('slice')[index].getElementsByClassName('progress'),
                    width: '100%',
                    duration: SLIDE_DURATION,
                    changeBegin: () => {
                        // console.log('before: ' + this.currentSlideIndex);
                        this.currentSlideIndex = index;
                        // console.log('index: ' + index)
                        // console.log('after: ' + this.currentSlideIndex);
                    },
                    complete: () => {
                        if (index === this.slides.length - 1) {
                            // this.nextStory();
                            console.log('next Story');
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
                    }, 150)
                }
            },
            preloadNext() {
                // if (this.currentSlideIndex === this.slides.length - 1) return;

                let img = new Image();

                img.onload = () => {
                    console.log('img preloaded');
                }

                img.src = this.slides[this.currentSlideIndex + 1];
            },
            slideClicked(e) {
                clearTimeout(this.pressFunc);
                this.pressFunc = null;
                if (this.pressDetect) {
                    this.pressDetect = false;
                    this.timeline.play();
                    return;
                }
                e.offsetX > e.target.clientWidth / 2 ? this.nextSlide() : this.prevSlide();
            },
            nextSlide: function () {
                if (this.currentSlideIndex < this.slides.length - 1) {
                    this.currentSlideIndex++;
                    // console.log('next slide');
                    this.resetSlide();
                } else {
                    // this.nextStory();
                    console.log('next story');
                }
            },
            prevSlide: function () {
                if (this.currentSlideIndex > 0) {
                    this.currentSlideIndex = this.currentSlideIndex - 1;
                    // console.log('prev slide--');
                    this.resetSlide();
                } else {
                    // this.previousStory();
                    console.log('prev story');
                }
            },
            resetSlide: function () { // Jump to beginning of the slide
                this.timeline.pause();
                // console.log('seek'+ this.currentSlideIndex )
                this.timeline.seek(this.currentSlideIndex * SLIDE_DURATION + 1);
                this.timeline.play();
            },
        },
        computed: {
            currentSlide() {
                this.preloadNext();
                return this.slides[this.currentSlideIndex];
            }
        }
    }
</script>

<style scoped>
    .story {
        display: flex;
        flex-direction: column;
    }

    .timeline {
        display: flex;
        width: 100%;
    }

    .timeline > .slice {
        background: rgba(0, 0, 0, 0.3);
        height: 6px;
        margin: 8px;
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
