<template>
    <title>Dashboard | ChallengeTaskApp</title>
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="#"><b>ChallengeTask</b>App</a>
        </div>

        <div class="lockscreen-name text-center text-bold"> Welcome {{ appdata.username }} ({{ appdata.email }})!</div>


        <div class="help-block text-center">
            <button v-if="appdata.userlevel  == 2" class="btn btn-danger btn-sm mr-2">Unsubscribe</button>
            <router-link to="/portal/records" v-else-if="appdata.userlevel  == 1" class="btn btn-primary btn-sm mr-2">View Records</router-link>
            <button class="btn btn-primary btn-sm" @click="Logout()">Logout</button>
        </div>
        <div class="lockscreen-footer text-center mt-5">
            Copyright &copy; 2023 <b><a href="#" class="text-black">Growmodo Challenge Task</a></b><br>
            All rights reserved
        </div>
    </div>
</template>


<script>


import store from '../../../store/index.js'

export default {
    data() {
        return {
            appdata: {
                username: store.state.username,
                email: store.state.email,
                userlevel: store.state.userlevel,
            },
            errors: []
        }
    },
    methods: {
        Logout() {
            store.commit("logout");
            console.log("Logging you out ...")
            this.$router.push('/');
        }
    },
    mounted() {
        console.log(store.state)

    }
}
</script>