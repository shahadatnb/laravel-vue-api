<template>
    <header class="min-h-10 bg-blue-600 flex justify-between items-center">
        <h1 class="text-4xl ml-6 text-white">Asiancoder</h1>
    <ul class="flex">
        <li class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/dashboard">Dashboard</router-link>
        </li>
        <li class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/projects">Project</router-link>
        </li>
        <li class="mr-6">
            <router-link class="text-blue-400 hover:text-white" to="/login">Login</router-link>
        </li>
        <li class="mr-6">
            <a class="text-blue-400 hover:text-white" href="#">Logout</a>
        </li>
    </ul>
    </header>
</template>