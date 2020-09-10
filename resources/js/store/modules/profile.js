import Vue from 'vue';

const state = {
    profile: {},
    posts: [],
    activeStories: [],
    favoritedStories: [],
    error: null,
    followers: [],
    followings: []
}

const getters = {
    getErrors(state) {
        return state.error;
    },
    profilePosts(state){
        return state.posts;
    },
    profileInfo(state){
        return state.profile;
    },
    postsCount(state){
        return state.posts.length;
    },
    profileFollowers(state){
        return state.followers;
    },
    profileFollowings(state){
        return state.followings;
    },
    followersCount(state){
        return state.followers.length;
    },
    followingsCount(state){
        return state.followings.length;
    },
    activeUnviewed(state) {
        return state.activeStories.filter(story => story.viewers.findIndex(user => user.id === Vue.auth.user().id) === -1);
    },
    activeViewed(state, getters){
        let activeViewed = state.activeStories.filter(story => !getters.activeUnviewed.includes(story));
        activeViewed.forEach(story => story.isViewed = true);
        return activeViewed;
    },
    storyFeed(state, getters){
        return [].concat(getters.activeUnviewed, state.favoritedStories).concat(getters.activeViewed);
    }
}

const actions = {
    fetchProfile({state, commit}, username) {
        if (username === state.profile.username) return;
        state.error = null;
        Vue.axios.get('profiles/' + username).then((res) => {
            commit("SET_POSTS", res.data.data.posts);
            commit("SET_FOLLOWERS", res.data.data.followers);
            commit("SET_FOLLOWING", res.data.data.followings);
            commit("SET_PROFILE", res.data.data.profile);
            commit("SET_ACTIVE_STORIES", res.data.data.active_stories);
            commit("SET_FAVORITED_STORIES", res.data.data.favorited_stories);
        }).catch((error) => {
            console.log(error);
        })
    },
    follow({commit}, username) {
        if(username === Vue.auth.user().username || username === undefined) return;

        Vue.axios.post(`profiles/${username}/follow`).then((res) => {
            commit("ADD_TO_FOLLOWERS", Vue.auth.user());
        }).catch((err) => {
            console.log(err);
        })
    },
    unfollow({commit}, username) {
        if(username === Vue.auth.user().username || username === undefined) return;

        Vue.axios.delete(`profiles/${username}/follow`).then((res) => {
            commit("REMOVE_FROM_FOLLOWERS", Vue.auth.user());
        }).catch((err) => {
            console.log(err);
        })
    },
    uploadStory({commit}, data) {
        Vue.axios.post(`stories`, data).then((res) => {
            commit("ADD_TO_ACTIVE_STORIES", res.data.data);
        }).catch((err) => {
            console.log(err);
        })
    }
}

const mutations = {
    SET_PROFILE(state, data) {
        state.profile = data;
    },
    SET_POSTS(state, data) {
        state.posts = data;
    },
    SET_FOLLOWERS(state, data) {
        state.followers = data;
    },
    SET_FOLLOWING(state, data) {
        state.followings = data;
    },
    ADD_TO_FOLLOWERS(state, data) {
        state.followers.push(data);
    },
    REMOVE_FROM_FOLLOWERS(state, data) {
        let index = state.followers.find((user) => {
            return user.username === data.username;
        });
        state.followers.splice(index, 1);
    },
    SET_ACTIVE_STORIES(state, data) {
        state.activeStories = data;
    },
    SET_FAVORITED_STORIES(state, data) {
        state.favoritedStories = data.filter(story => !_.some(state.activeStories, story)); //remove dublicates in stories array's
        // state.favoritedStories = data;
    },
    ADD_TO_ACTIVE_STORIES(state, story) {
        state.activeStories.unshift(story)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
