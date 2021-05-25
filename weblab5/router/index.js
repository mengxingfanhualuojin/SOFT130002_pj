import Vue from 'vue'
import Router from 'vue-router'
import HomePage from "@/components/HomePage";
import ArtworkDisplay from "@/components/ArtworkDisplay";
import PersonalCollection from "@/components/PersonalCollection";
import Search from "@/components/Search";
import Register from "@/components/Register";
import LogIn from "@/components/LogIn";

Vue.use(Router);
export const router = new Router({
    routes: [
        {
            path:'/',
            name:'HomePage',
            component:HomePage
        },
        {
            path:'/ArtworkDisplay',
            name:'ArtworkDisplay',
            component:ArtworkDisplay
        },
        {
            path:'/PersonalCollection',
            name:'PersonalCollection',
            component:PersonalCollection
        },
        {
            path:'/Search',
            name:'Search',
            component:Search
        },
        {
            path:'/Register',
            name:'Register',
            component:Register
        },
        {
            path:'/LogIn',
            name:'LogIn',
            component:LogIn
        },
    ]
})