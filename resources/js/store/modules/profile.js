import Vue from 'vue';
import HttpRequests from "../../services/HttpRequests";

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
    storiesFavorited(state) {
        return state.favoritedStories;
    },
    storyFeed(state, getters){
        return [].concat(getters.activeUnviewed, state.favoritedStories).concat(getters.activeViewed);
    }
}

const actions = {
    fetchProfile({state, commit}, username) {
        if (username === state.profile.username) return;
        state.error = null;
        HttpRequests.fetchProfile(username).then(res => {
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

        HttpRequests.followProfile(username).then(res => {
            commit("ADD_TO_FOLLOWERS", Vue.auth.user());
        }).catch(err => {
            console.log(err);
        })
    },
    unfollow({commit}, username) {
        if(username === Vue.auth.user().username || username === undefined) return;

        HttpRequests.unfollowProfile(username).then(res => {
            commit("REMOVE_FROM_FOLLOWERS", Vue.auth.user());
        }).catch((err) => {
            console.log(err);
        })
    },
    uploadStory({commit}, data) {
        HttpRequests.uploadStory(data).then((res) => {
            commit("ADD_TO_ACTIVE_STORIES", res.data.data);
        }).catch((err) => {
            console.log(err);
        })
    },
    markStoryViewed({commit, getters}, array_ids){
        if(!Vue.auth.check()) return;

        let unique = [...new Set(array_ids)];
        HttpRequests.markStoryViewed({ids: unique}).then((res) => {
            commit("MARK_VIEWED", unique);
        }).catch((err) => {
            console.log(err)
        })
    },
    likePost({commit}, post_id) {
        HttpRequests.likePost(post_id).then(res => {
            commit("ADD_LIKE", post_id);
        }).catch(error => {
            console.log(error)
        });
    },
    unlikePost({commit}, post_id) {
        HttpRequests.unlikePost(post_id).then(res => {
            commit("REMOVE_LIKE", post_id);
        }).catch(error => {
            console.log(error)
        });
    },
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
        let filtered = data.filter(story => !_.some(state.activeStories, story)); //remove dublicates in stories array's
        filtered.forEach((story) => {
            story.favorited = true;
        });
        state.favoritedStories = filtered;
    },
    ADD_TO_ACTIVE_STORIES(state, story) {
        state.activeStories.unshift(story)
    },
    MARK_VIEWED(state, ids) {
        ids.forEach(id => {
            state.activeStories.find(story => story.id === id).viewers.push(Vue.auth.user());
        });
    },
    APPEND_NEW_COMMENT(state, comment) {
        state.posts.find(post => post.id === comment.post_id).comments.push(comment);
    },
    ADD_LIKE(state, post_id) {
        state.posts.find(post => post.id === post_id).likes.push(Vue.auth.user());
    },
    REMOVE_LIKE(state, post_id) {
        let likes = state.posts.find(post => post.id === post_id).likes;
        likes.splice(likes.findIndex(user => user.id === Vue.auth.user().id), 1);
    },
    ADD_POST(state, post) {
        state.posts.unshift(post);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
