import axios from "axios";
import Vue from 'vue'

const apiClient = axios.create({
    baseURL: `http://social.test/api`,
    withCredentials: false, // This is the default
    headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Authorization: Vue.$auth.token()
    },
});

export default {
    uploadPost(data) {
        return apiClient.post("/posts", data);
    },
    uploadFilee(fileObject) {
        return apiClient.post("/messenger/" +
            "", fileObject);
    },
    getPostse(page) {
        return apiClient.get("/api/v1/posts?page=" + page);
    },
};
