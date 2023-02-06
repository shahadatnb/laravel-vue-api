<template>
    <header class="min-h-10 bg-blue-600 flex justify-between items-center">
        <h1 class="text-4xl ml-6 text-white">Asiancoder</h1>
    <ul class="flex">
        <li v-if="authenticated" class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/dashboard">Dashboard</router-link>
        </li>
        <li v-if="authenticated" class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/projects">Project</router-link>
        </li>
        <li v-if="!authenticated" class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/login">Login</router-link>
        </li>
        <li v-if="authenticated" class="mr-6">
            <a class="text-blue-400 hover:text-white" @click="handleLogout()" href="#">Logout</a>
        </li>
    </ul>
    </header>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
    computed:{
        ...mapGetters([
            'authenticated'
        ])
        // authenticated(){
        //     return this.$store.state.authenticated;
        // }
    },
    methods:{
        async handleLogout(){
            await this.$store.dispatch('logout');
            this.$router.push({name:'login'});
        }
    }
}
</script>