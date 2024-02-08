<script setup>

</script>

<template>
    <div id="loader">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center ">
            <div>
                <div class="spinner-grow spinner-grow-sm text-primary mx-3" style="width: 2rem; height: 2rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow spinner-grow-sm text-warning" mx-3 style="width: 2rem; height: 2rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow spinner-grow-sm text-success mx-3" style="width: 2rem; height: 2rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="text-white">
                <small>Loading...</small>
            </div>
        </div>
    </div>
</template>

<style>
#loader{
    min-width: 100vw;
    width: 100%;
    min-height: 100vh;
    height: 100%;
    position: fixed;
    z-index: 1025;
    top: 0;
    bottom: 0;
    background-color: #ffffff8c;
}
</style>