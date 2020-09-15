<template>
    <v-card flat max-width="50%" class="pt-5 mx-auto">
        <v-card-title>Add New Post</v-card-title>
        <v-card-text>
            <v-form>
                <v-row align="center">
                    <v-col align="end" cols="2">
                        <span class="subtitle-1">Description</span>
                    </v-col>
                    <v-col cols="8">
                        <v-textarea
                            auto-grow
                            row-height="6"
                            hide-details
                            dense
                            v-model="description"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col align="end" cols="2" class="pt-7">
                        <span class="subtitle-1">Image</span>
                    </v-col>
                    <v-col cols="8">
                        <v-file-input
                            accept="image/*"
                            label="Choose image"
                            prepend-icon="mdi-camera"
                            @change="fileAdded"
                        ></v-file-input>
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-btn dark color="#ff4e6a" class="text-none mx-auto mt-6" elevation="6" @click="upload">
                <v-icon class="mx-2">mdi-content-save</v-icon>
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import HttpRequests from "../../services/HttpRequests";
    export default {
        data: () => ({
                currentFile: undefined,
                description: ''
            }
        ),
        methods: {
            fileAdded(file){
                this.currentFile = file;
            },
            upload() {
                if (!this.currentFile) {
                    return;
                }

                let formData = new FormData();
                formData.append("image", this.currentFile);
                formData.append("description", this.description);

                HttpRequests.uploadPost(formData).then(res => {
                    this.$toast.success('Success');
                    this.$store.commit('profile/ADD_POST', res.data.post);
                    this.$router.push({name: 'feed'});
                }).catch(error => {
                    this.$toast.err('Some error');
                    console.log(error)
                })
            },
        }
    }
</script>

<style scoped>

</style>
