<template>
    <div class="flex flex-col h-screen justify-between">
        <AppHeader></AppHeader>
        <main class="flex-grow bg-blue-100">
            <router-view></router-view>
        </main>
        <AppFooter></AppFooter>
    </div>
</template>

<script>
import AppHeader from './partials/Header.vue'
import AppFooter from './partials/Footer.vue'
export default{
    components:{
        AppHeader,
        AppFooter
    }
}
</script>