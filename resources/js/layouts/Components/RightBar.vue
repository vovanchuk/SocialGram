<template>
    <v-navigation-drawer class="pa-4 mt-6" app clipped floating permanent right width="300">
        <v-row>
            <v-card width="100%">
                <v-img
                        height="300"
                        width="100%"
                        :src="profileInfo.avatar"
                ></v-img>
            </v-card>
        </v-row>
        <v-row class="mt-6 ml-0">
            <div class="title">{{ getTitle }}</div>
            <div v-if="!isSelfProfile" class="ml-2">
                <v-btn v-if="!isFollowing()" small depressed color="#ff4e6a" dark @click="follow($route.params.username)">Follow</v-btn>
                <v-btn v-if="isFollowing()" small depressed outlined color="#3949AB" @click="unfollow($route.params.username)">Unfollow
                </v-btn>
            </div>
        </v-row>
        <v-row class="d-flex flex-column pl-3 pt-3">
            <div class="d-flex">
                <div class="subtitle-2">{{ postsCount }}</div>
                <div class="subtitle-2 ml-1 grey--text">Photos</div>
            </div>
            <div class="d-flex cursor-pointer" @click="toggleFollowersModal('followers')">
                <div class="subtitle-2">{{ followersCount }}</div>
                <div class="subtitle-2 ml-1 grey--text">Followers</div>
            </div>
            <div class="d-flex cursor-pointer" @click="toggleFollowersModal('followings')">
                <div class="subtitle-2">{{ followingsCount }}</div>
                <div class="subtitle-2 ml-1 grey--text">Following</div>
            </div>
        </v-row>
        <v-row class="mx-0 mt-4 subtitle-2 grey--text">
            {{ profileInfo.description }}
        </v-row>
<!--        <v-row class="mt-5">-->
<!--            <v-col>-->
<!--                <div class="subtitle-2">Locations</div>-->
<!--                <div class="subtitle-2 grey&#45;&#45;text">Based in Cedar Rapids, IA.</div>-->
<!--            </v-col>-->
<!--        </v-row>-->
        <v-row class="mt-2">
            <v-col>
                <div class="subtitle-2">Website</div>
                <div class="subtitle-2 grey--text"><a :href="profileInfo.url">{{ profileInfo.url }}</a></div>
            </v-col>
        </v-row>
        <FollowersModal :users="followersList" :showModal="followersModal" @closeModal="followersModal = false"/>
    </v-navigation-drawer>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import FollowersModal from "../../components/FollowersModal";

    export default {
        components: {FollowersModal},
        data: () => ({
            followersModal: false,
            followersList: [],
        }),
        computed: {
            ...mapGetters('profile', ['profileInfo', 'postsCount', 'profileFollowers', 'profileFollowings', 'followersCount', 'followingsCount']),
            getTitle() {
                return this.profileInfo.title ? this.profileInfo.title : this.profileInfo.username;
            },
            isSelfProfile(){
                return this.$auth.user().username === this.$route.params.username;
            },
        },
        methods: {
            ...mapActions('profile', ['follow', 'unfollow']),
            isFollowing(){
                if(!this.profileFollowers || this.profileFollowers.length === 0) return false;

                const index = this.profileFollowers.findIndex((user) => {
                    return user.username === this.$auth.user().username;
                });

                return index !== -1;
            },
            setFollowersList(type){
                if(type === 'followings') this.followersList = this.profileFollowings;
                else if(type === 'followers') this.followersList = this.profileFollowers;
            },
            toggleFollowersModal(type) {
                this.setFollowersList(type);
                this.followersModal = true;
            }
        }
    }
</script>

<style scoped>

</style>
