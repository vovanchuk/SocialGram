import Vue from "vue";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const options = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: true,
}

Vue.use(Toast, options);
