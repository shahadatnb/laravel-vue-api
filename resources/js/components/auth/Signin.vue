<template>
    <div class="relative flex min-h-screen text-gray-800 antialiased flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
        <form @submit.prevent="handleLogin" class="relative py-3 sm:w-96 mx-auto text-center">
            <span class="text-2xl font-light ">Login to your account</span> <br>
            <span v-if="errorMsg.length" class="color-red-600 font-light ">{{ errorMsg }}</span>
            <div class="mt-4 bg-white shadow-md rounded-lg text-left">
                <div class="h-2 bg-purple-400 rounded-t-md"></div>
                <div class="px-8 py-6 ">
                    <label class="block font-semibold"> Username or Email </label>
                    <input v-model="email" type="text" placeholder="Email" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">
                    <label class="block mt-3 font-semibold"> Username or Email </label>
                    <input v-model="password" type="password" placeholder="Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">
                    <div class="flex justify-between items-baseline">
                        <button type="submit" class="mt-4 bg-purple-500 text-white py-2 px-6 rounded-md hover:bg-purple-600 ">Login</button>
                        <a href="#" class="text-sm hover:underline">Forgot password?</a>
                    </div>
                </div>        
            </div>
        </form>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default{
    data(){
        return {
            'email':'',
            'password':'',
            'errorMsg': ''
        }
    },
    computed:{
        ...mapGetters([
            'authenticated'
        ])
    },
    methods:{
        async handleLogin(){
            //alert(this.email)
            this.errorMsg = '';

            try{
                await this.$store.dispatch('signIn', {email:this.email, password:this.password});
                this.$router.push({name:'dashboard'});
            } catch(e){
                this.errorMsg = e;
            }            
        }
    },
    mounted(){
        if( this.authenticated ){
            //this.$router.push({name:'dashboard'});
        }
    }
}

</script>