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
                    'https://picsum.photos/1080/1920', 'https://i.picsum.photos/id/1026/1080/1920.jpg?hmac=XQFfEG-QjNNv3JBpMV7P8B9NV7hhZBcPl_r3wRvSVA4', 'https://picsum.photos/1080/1920'
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
