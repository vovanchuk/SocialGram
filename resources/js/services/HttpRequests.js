import Vue from 'vue'


export default {
    changePassword(data) {
        return Vue.axios.post("/users/" + Vue.auth.user().username, data);
    },
    changeProfileInfo(data) {
        return Vue.axios.post("/users/"+ Vue.auth.user().username, data);
    },
    sendComment(data) {
        return Vue.axios.post("/comments", data);
    },
    likePost(post_id) {
        return Vue.axios.post(`/posts/${post_id}/like`);
    },
    unlikePost(post_id) {
        return Vue.axios.delete(`/posts/${post_id}/like`);
    },
    uploadPost(post) {
        return Vue.axios.post('/posts', post);
    },
    changeAvatar(data) {
        return Vue.axios.post('/users/' + Vue.auth.user().username, data);
    },
    fetchProfile(username) {
        return Vue.axios.get('profiles/' + username);
    },
    followProfile(username) {
        return Vue.axios.post(`profiles/${username}/follow`);
    },
    unfollowProfile(username) {
        return Vue.axios.delete(`profiles/${username}/follow`);
    },
    uploadStory(data) {
        return Vue.axios.post('stories', data);
    },
    markStoryViewed(data) {
        return Vue.axios.post('stories/markViewed', data);
    }
};
