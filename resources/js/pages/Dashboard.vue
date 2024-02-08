<script setup>
    import { useRoute } from 'vue-router'
    import { ref,reactive, onMounted, watch } from 'vue';
    import Header from "@/layouts/Header.vue";
    import Sidebar from "@/layouts/Sidebar.vue";
    import Footer from "@/layouts/Footer.vue";
    import Loader from "@/components/Loader.vue";

    const route = useRoute()

    //define state
    const path = ref("/");
    const isLoading = ref(false);

    const setLoading = (isLoaded) => {
        isLoading.value = isLoaded;
    }

    //run hook "onMounted"
    watch(() => {
        path.value = route.path;
    });

</script>

<template>
    <Header></Header>
    <Loader v-if="isLoading"/>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-1 p-0">
                <Sidebar :currentpath="path"/>
            </div>
            <div class="col-11 p-0">
                <router-view @toggle-loading="setLoading" :loading="isLoading"></router-view>
                <Footer/>
            </div>
        </div>
        
    </div>
    
</template>

<style>
    .content-wrapper{
        min-height: 85vh;
    }
</style>