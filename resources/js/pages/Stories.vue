<template>
    <div class="stories-wrapper fill-height">
        <Story :slides="story" :profile="profile"/>
    </div>
</template>

<script>
    import Story from '../components/Story.vue';

    export default {
        components: {
            Story
        },
        data() {
            return {
                story: [
                    {
                        url: 'storage/stories/8VF2PMNwjK7yA7k2TjL3ydFKJjXhUIlJAEfb3TRp.mp4',
                        type: 'video', duration: 32000
                    }, {
                        url: 'https://i.picsum.photos/id/1026/1080/1920.jpg?hmac=XQFfEG-QjNNv3JBpMV7P8B9NV7hhZBcPl_r3wRvSVA4',
                        type: 'image'
                    }, {url: 'https://picsum.photos/1080/1920', type: 'image'}
                ],
                profile: {
                    "id": 1,
                    "username": "test",
                    "title": "VOVA  KODER",
                    "description": "Пишу код, ебу телок",
                    "url": "www.koder.com",
                    "avatar": "/storage/profiles/I6CUOVz8wyxYwMT2GxxrTDdI9GEuvFtqNUIu59bQ.jpeg",
                    "lastActivity": "2020-09-05 16:59:09"
                }
            };
        },
    }
</script>

<style scoped>
</style>
