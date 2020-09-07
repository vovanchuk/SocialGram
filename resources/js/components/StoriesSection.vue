<template>
    <div class="ml-5">
        <v-row>
            <v-col class="pa-0 align-self-center">
                <div class="title">Featured Stories</div>
            </v-col>
            <v-col class="d-flex justify-end py-0 pr-10">
                <v-btn depressed class="text-none" color="grey lighten-4" @click="$refs.storyUpload.click()">
                    <v-icon style="color: #9E9E9E;">mdi-plus-circle-outline</v-icon>
                    <span class="grey--text ml-2">Upload Story</span>
                    <input
                        type="file"
                        ref="storyUpload"
                        v-show="false"
                        @change="onStoryChange"
                        >
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify-start class="mt-7">
            <v-card elevation="12" height="230" width="170" color="blue" class="mr-4">
                <v-img
                        height="230"
                        src="https://images.unsplash.com/photo-1525138079-9424be9df411?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=675&q=80"
                ></v-img>
            </v-card>
            <v-card elevation="12" height="230" width="170" color="blue" class="mr-4">
                <v-img
                        height="230"
                        src="https://images.unsplash.com/photo-1523224949444-170258978eef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=564&q=80"
                ></v-img>
            </v-card>
            <v-card elevation="12" height="230" width="170" color="blue" class="mr-4">
                <v-img
                        height="230"
                        src="https://images.unsplash.com/photo-1551818633-579bccc6210c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1267&q=80"
                ></v-img>
            </v-card>
            <v-card elevation="12" height="230" width="170" color="blue" class="mr-4">
                <v-img
                        height="230"
                        src="https://images.unsplash.com/photo-1478296046035-d4fc77bec472?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80"
                ></v-img>
            </v-card>
        </v-row>
    </div>
</template>

<script>
    export default {
        methods: {
            onStoryChange(e) {
                if (e.target.files[0] === undefined) {
                    return;
                }

                let formData = new FormData();
                formData.append("file", e.target.files[0]);

                this.axios.post('/stories', formData).then((res) => {
                    console.log(res);
                })
            }
        }
    }
</script>

<style scoped>

</style>
