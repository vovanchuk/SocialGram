import Vue from "vue";

Vue.prototype.$swap = function(arr, a, b) {
    let temp1 = arr[a];
    let temp2 = arr[b];

    Vue.set(arr,a,temp2);
    Vue.set(arr,b,temp1);
}
Vue.mixin({
    methods: {
        notEmptyObject(someObject){
            return Object.keys(someObject).length
        }
    }
})

// axios.interceptors.response.use(null, error => {
//     let path = '/error';
//     switch (error.response.status) {
//         case 401: path = '/login'; break;
//         case 404: path = '/404'; break;
//     }
//     router.push(path);
//     return Promise.reject(error);
// });
