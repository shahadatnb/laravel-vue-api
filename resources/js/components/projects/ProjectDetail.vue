<template>
  <div>
    <h1>Project Detail</h1>

    <div v-if="project.id > 0">
        <div class="flex">
            <div class="w-1/6 p-2">
                <div class="bg-gray-400 text-gray-700 p-2 text-left">Project Name</div>
            </div>
            <div class="w-1/2 p-2">
                <div class="bg-gray-400 text-gray-700 p-2 text-left">{{ project.name }}</div>
            </div>
        </div>
        <div v-if="project.tasks.length > 0">
            <task-item v-for="task in project.tasks" :key="task.id"></task-item>
        </div>
    </div>
    

</div>
</template>

<script>
import TaskItem from './TaskItem.vue';
import axios from 'axios'
export default {
    props:['id'],
    components:{
        TaskItem
    },
    data(){
        return{
            project:[]
        }
    },
    mounted(){
        axios.get('api/projects/'+ this.id).then( (res) => {
            this.project = res.data.data;
        });
    }
}
</script>

<style>

</style>