<template>
    <v-container fill-height>
        <v-row align="center" justify="center" no-gutters>
            <v-col cols="12" sm="8" md="8">
                <v-card elevation="12">
                    <v-window v-model="step" @change="resetFields()">
                        <!--SignIn-->
                        <v-window-item :value="1">
                            <v-row class="mx-0">
                                <v-col cols="12" md="8" class="pt-6 pb-6">
                                    <v-card-text>
                                        <v-form class="form-wrapper" @submit.prevent="signin">
                                            <h1
                                                class="text-center display-1 mb-10"
                                                :class="`${bgColor}--text`"
                                            >
                                                Sign in
                                            </h1>
                                            <v-text-field
                                                id="username"
                                                v-model="username"
                                                label="Username"
                                                name="username"
                                                append-icon="mdi-account"
                                                type="text"
                                                :color="bgColor"
                                            />
                                            <v-text-field
                                                id="password"
                                                v-model="password"
                                                label="Password"
                                                name="password"
                                                append-icon="mdi-lock"
                                                type="password"
                                                :color="bgColor"
                                                autocomplete="on"
                                            />
                                            <div class="text-center">
                                                <a
                                                    href="#"
                                                    class="mt-3 overline text-decoration-none"
                                                    :class="`${bgColor}--text`"
                                                    @click="step = 3"
                                                >
                                                    Forgot your password?
                                                </a>
                                            </div>
                                            <div class="text-center mt-6">
                                                <v-btn type="submit" large :color="bgColor" dark
                                                >Sign In
                                                </v-btn
                                                >
                                            </div>
                                        </v-form>
                                    </v-card-text>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4"
                                    class="darken-2 vcenter"
                                    :class="`${bgColor}`"
                                >
                                    <div>
                                        <v-card-text :class="`${fgColor}--text`">
                                            <h1 class="text-center headline mb-3">Not User?</h1>
                                            <h5 class="text-center overline mb-3">
                                                Please Sign Up to continue
                                            </h5>
                                        </v-card-text>
                                        <div class="text-center mb-6">
                                            <v-btn dark outlined @click="step = 2">Sign Up</v-btn>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-window-item>
                        <!--SignUp-->
                        <v-window-item :value="2">
                            <v-row class="fill-height mx-0">
                                <v-col
                                    cols="12"
                                    md="4"
                                    class="darken-2 vcenter"
                                    :class="`${bgColor}`"
                                >
                                    <div>
                                        <v-card-text :class="`${fgColor}--text`">
                                            <h1 class="text-center headline mb-3">Already a user?</h1>
                                            <h5 class="text-center overline mb-3">Please Sign In</h5>
                                        </v-card-text>
                                        <div class="text-center mb-6">
                                            <v-btn dark outlined @click="step = 1">Sign In</v-btn>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="12" md="8" class="pt-6 pb-6">
                                    <v-card-text>
                                        <h1
                                            class="text-center display-1 mb-10"
                                            :class="`${bgColor}--text`"
                                        >
                                            Sign Up
                                        </h1>
                                        <v-form class="form-wrapper" @submit.prevent="signup">
                                            <v-text-field
                                                id="username"
                                                v-model="username"
                                                label="Username"
                                                name="username"
                                                append-icon="mdi-account"
                                                type="text"
                                                autocomplete="on"
                                            />
                                            <v-text-field
                                                id="email"
                                                v-model="email"
                                                label="Email"
                                                name="email"
                                                append-icon="mdi-email"
                                                type="email"
                                                autocomplete="on"
                                            />
                                            <v-text-field
                                                id="password"
                                                v-model="password"
                                                label="Password"
                                                name="password"
                                                append-icon="mdi-lock"
                                                type="password"
                                                autocomplete="on"
                                            />
                                            <v-text-field
                                                id="password-confirmation"
                                                v-model="password_confirmation"
                                                label="Confirm Password"
                                                name="password-confirmation"
                                                append-icon="mdi-lock"
                                                type="password"
                                                autocomplete="on"
                                            />
                                            <div class="text-center mt-6">
                                                <v-btn type="submit" large :color="bgColor" dark>
                                                    Sign Up
                                                </v-btn
                                                >
                                            </div>
                                        </v-form>
                                    </v-card-text>
                                </v-col>
                            </v-row>
                        </v-window-item>
                        <!--PW Rest-->
                        <v-window-item :value="3">
                            <v-row class="fill-height mx-0">
                                <v-col
                                    cols="12"
                                    md="4"
                                    class="darken-2 vcenter"
                                    :class="`${bgColor}`"
                                >
                                    <div>
                                        <v-card-text :class="`${fgColor}--text`">
                                            <h1 class="text-center headline mb-3">Already a user?</h1>
                                            <h5 class="text-center overline mb-3">Please Sign In</h5>
                                        </v-card-text>
                                        <div class="text-center mb-6">
                                            <v-btn dark outlined @click="step = 1">Sign In</v-btn>
                                        </div>
                                    </div>
                                </v-col>
                                <v-col cols="12" md="8" class="pt-6 pb-6">
                                    <v-card-text>
                                        <v-form class="form-wrapper">
                                            <h1
                                                class="text-center display-1 mb-10"
                                                :class="`${bgColor}--text`"
                                            >
                                                Reset Password
                                            </h1>
                                            <v-text-field
                                                id="login"
                                                v-model="login"
                                                label="Username / Email"
                                                name="login"
                                                append-icon="mdi-account"
                                                type="text"
                                                :color="bgColor"
                                                class="v-input__icon--double"
                                            />
                                            <div class="text-center mt-6">
                                                <v-btn large :color="bgColor" dark
                                                >Reset Password (inactive)
                                                </v-btn
                                                >
                                            </div>
                                        </v-form>
                                    </v-card-text>
                                </v-col>
                            </v-row>
                        </v-window-item>
                    </v-window>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        props: {
            source: {
                type: String,
                default: ''
            }
        },
        data: () => ({
            step: 1,
            username: '',
            email: '',
            password: '',
            password_confirmation: '',
            login: '',
            fgColor: 'white',
            bgColor: 'red',
            has_error: false,
        }),
        methods: {
            signup() {
                const app = this;
                this.$auth
                    .register({
                        data: {
                            username: app.username,
                            email: app.email,
                            password: app.password,
                            password_confirmation: app.password_confirmation,
                        },
                    })
                    .then(
                        () => {
                            this.$toast.success('Success!')
                            app.success = true;
                            this.step = 1;
                        },
                        (res) => {
                            this.$toast.error('Error!');
                            console.log(res.response.data.errors);
                            // app.has_error = true;
                            // app.error = res.response.data.error;
                            // app.errors = res.response.data.errors || {};
                        }
                    );
            },
            signin() {
                const redirect = this.$auth.redirect();
                const app = this;
                this.$auth.login({
                    data: {
                        username: app.username,
                        password: app.password
                    },
                    staySignedIn: true,
                    fetchUser: true
                }).then((res) => {
                    console.log(res)
                    // handle redirection
                    // let redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 2 ? 'settings.profile' : 'feed'
                    // this.$router.push({name: redirectTo})
                }, () => {
                    this.$toast.error('Error!');
                    app.has_error = true;
                });
            },
            resetFields() {
                this.email = ''
                this.username = ''
                this.password = ''
                this.password_confirmation = ''
                this.login = ''
                this.has_error = false
            }
        },
        watch: {
            step: function () {
                this.resetFields()
            }
        }
    }
</script>

<style scoped lang="scss">
    .form-wrapper {
        width: 50%;
        margin: 0 auto;
    }
</style>

<style>
    .vcenter {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
