<template>
    <div>Dashboard {{ company }}</div>
    {{ user }}
</template>
<script>
import axios from 'axios';
import { mapGetters } from 'vuex';
export default{
    data(){
        return{
           //'user':[],
           'company':'',
        }        
    },
    computed:{
        ...mapGetters([
            'user'
        ])
    },
    mounted(){
        //this.user = this.$store.state.user;
        this.company = this.$store.state.company;
        /*
        axios.get('/api/user')
        .then(res=>{
            console.log(res.data);
            this.user=res.data;
        })
        */
    }

    
}
</script>