<template>
  <tr>
        <td>{{ project.id }}</td>
        <td>{{ project.name }}</td>
        <td>{{ project.tasks_count }}</td>
        <td>
            <router-link :to="{name:'project-detail', params:{id:project.id}}">
                <button class="bg-gray-500 rounded text-white px-2 py-1 mr-1 hover:bg-gray-700" >View</button>
            </router-link>
            <button class="bg-gray-500 rounded text-white px-2 py-1 hover:bg-red-700" >Delete</button>
        </td>
    </tr>
</template>

<script>
export default {
    props:['project']
}
</script>

<style>

</style>