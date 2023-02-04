<template>
    <div>Dashboard</div>
    {{ user }}
</template>
<script>
import axios from 'axios';

export default{
    data(){
        user:[]
    },
    methods:{

    },
    mounted(){
        axios.get('/api/user')
        .then(res=>{
            this.user=res.data;
        })
    }
}
</script>