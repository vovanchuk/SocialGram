const state = {
    profile: {},
    posts: [],
    stories: [],
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
    profileStories(state){
        return state.stories;
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
    }
}

const actions = {
    fetchProfile({state, commit}, username) {
        if (username === state.profile.username) return;
        state.error = null;
        this._vm.axios.get('profiles/' + username).then((res) => {
            commit("SET_POSTS", res.data.data.posts);
            commit("SET_STORIES", res.data.data.stories);
            commit("SET_FOLLOWERS", res.data.data.followers);
            commit("SET_FOLLOWING", res.data.data.followings);
            delete res.data.data.posts;
            delete res.data.data.stories;
            delete res.data.data.followings;
            delete res.data.data.followers;
            commit("SET_PROFILE", res.data.data);

        }).catch((error) => {
            console.log(error);
        })
    },
    follow({commit}, username) {
        if(username === this._vm.$auth.user().username || username === undefined) return;

        this._vm.axios.post(`profiles/${username}/follow`).then((res) => {
            commit("ADD_TO_FOLLOWERS", this._vm.$auth.user());
        }).catch((err) => {
            console.log(err);
        })
    },
    unfollow({commit}, username) {
        if(username === this._vm.$auth.user().username || username === undefined) return;

        this._vm.axios.delete(`profiles/${username}/follow`).then((res) => {
            commit("REMOVE_FROM_FOLLOWERS", this._vm.$auth.user());
        }).catch((err) => {
            console.log(err);
        })
    }
}

const mutations = {
    SET_PROFILE(state, data) {
        state.profile = data;
    },
    SET_STORIES(state, data) {
        state.stories = data;
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
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
