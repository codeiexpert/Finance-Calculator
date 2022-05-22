<template>
    <div class="d-flex flex-column flex-root">
        <Navigation />
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <!-- <HeaderTop /> -->
            <router-view />     
        </div>
    </div>
</template>
<script>
    import Navigation from "../components/Navigation.vue";
    export default {
        components: {
            Navigation,
        }
    };
</script>

