import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from '../pages/Login'
import Explore from '../pages/Explore'
import Feed from '../pages/Feed'
import Profile from '../pages/Profile'
import Settings from '../pages/Settings/Settings'
import SettingsProfile from '../pages/Settings/Profile'
import SettingsPassword from '../pages/Settings/Password'
import PostsCreate from '../pages/Posts/Create'
import NotFound from '../pages/404'

// NON-LOGGED ROUTES (auth: false)
// PUBLIC ROUTES (auth: undefined)
// ADMIN ROUTES (auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/405'})
// USER ROUTES (auth: true)
const routes = [
    {
        path: '/',
        name: 'home',
        redirect: { name: 'feed'},
        meta: {
            auth: true,
        }
    },
    {
        path: '/profile',
        component: Profile,
        name: 'profile',
        meta: {
            layout: 'profile',
            auth: true
        }
    },
    {
        path: '/profile/:username',
        component: Profile,
        name: 'userProfile',
        meta: {
            layout: 'profile',
            auth: true
        }
    },
    {
        path: '/explore',
        name: 'explore',
        component: Explore,
        meta: {
            auth: true,
        }
    },
    {
        path: '/feed',
        name: 'feed',
        component: Feed,
        meta: {
            auth: true
        }
    },
    {
        path: '/settings',
        redirect: { name: 'settings.profile'},
        name: 'settings',
        component: Settings,
        meta: {
            auth: true
        },
        children: [
            {
                name: 'settings.profile',
                path: 'profile',
                component: SettingsProfile,
            },
            {
                name: 'settings.password',
                path: 'password',
                component: SettingsPassword
            }
        ]
    },
    {
        path: '/post/create',
        name: 'posts.create',
        component: PostsCreate,
        meta: {
            auth: true
        },
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            layout: 'empty',
            auth: false
        }
    },
    {
        // catch all 404, define at end!
        path: '*',
        name: 'notFound',
        component: NotFound,
        meta: {
            layout: 'empty',
            auth: undefined
        }
    }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
