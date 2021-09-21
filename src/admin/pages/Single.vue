<template>
    <div class="ffb-single-wrap">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        <h1>I am From Single = {{tableInfos.id}}</h1>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tableInfos: this.$route.params.item ? this.$route.params.item : {}
        }
    }
}
</script>

<style>
    
</style>