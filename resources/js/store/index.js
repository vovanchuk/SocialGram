import Vue from 'vue'
import Vuex from 'vuex'
import profile from "./modules/profile";
import stories from "./modules/stories";

Vue.use(Vuex)

export default new Vuex.Store({
    state: {},
    mutations: {},
    actions: {},
    modules: {
        profile,
        stories
    }
})
