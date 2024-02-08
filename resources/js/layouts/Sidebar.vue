<template>
    <div class="d-flex flex-column flex-shrink-0 bg-dark min-vh-100 h-100 w-100 ">
        <router-link to="/" class="d-block nav-link text-center text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only">
            <i class="bi bi-bootstrap-fill fs-2 text-white text-center active"></i>
            <span class="visually-hidden">Icon-only</span>
        </router-link>
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
            <li v-for="(nav, index) in navs" class="nav-item" :key="index">
                <router-link :to="nav.path" class="nav-link p-3 border-bottom rounded-0" :class="[ currentpath == nav.path ? 'active' : '' ]" >
                    <i class="fs-4" :class="nav.icon"></i>
                </router-link>
            </li>
        </ul>
        
    </div>
</template>

<script setup>
    import {onMounted, toRef, ref, watch} from 'vue';

    const props = defineProps({
        currentpath: String,
    });

    const currentpath = ref();

    const navs = ref([
        {
            'title': 'Permintaan',
            'path': '/permintaans',
            'icon': 'bi bi-table fs-4',
        },
        {
            'title': 'Data',
            'path': '/datas',
            'icon': 'bi bi-stickies fs-4',
        },
    ])

    watch(() => {
        currentpath.value = props.currentpath;
    })
</script>