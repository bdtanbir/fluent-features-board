<template>
    <div class="ffb-featured-lists">
        <table class="ffb-featured-list-table">
            <tbody>
                <tr class="ffb-features-list">
                    <FeaturedList />
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import FeaturedList from './FeaturedList.vue';

export default {
    components: {
        FeaturedList
    }
    
}
</script>

<style scoped>
    .ffb-featured-lists {
        margin-top: 30px;
        background: #fff;
        border-radius: 4px;
        padding: 10px 15px;
    }
    .ffb-featured-lists table {
        width: 100%;
    }
</style>