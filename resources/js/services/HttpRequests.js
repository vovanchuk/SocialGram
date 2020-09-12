import Vue from 'vue'


export default {
    changePassword(data) {
        return Vue.axios.post("/users/" + Vue.auth.user().username, data);
    },
    changeProfileInfo(data) {
        return Vue.axios.post("/users/"+ Vue.auth.user().username, data);
    },
    uploadFilee(fileObject) {
        return apiClient.post("/messenger/" +
            "", fileObject);
    },
    getPostse(page) {
        return apiClient.get("/api/v1/posts?page=" + page);
    },
};
