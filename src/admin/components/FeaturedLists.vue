<template>
    <div class="ffb-featured-lists">
        <table class="ffb-featured-list-table">
            <thead>
                <tr>
                    <td>ID</td>
                    <th>Title</th>
                    <th>Shortcode</th>
                </tr>
            </thead>
            <tbody>
                <FeaturedList />
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
        text-align: left;
    }
</style>