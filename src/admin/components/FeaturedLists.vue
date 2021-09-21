<template>
    <div class="ffb-featured-lists">
        <table class="ffb-featured-list-table">
            <thead>
                <tr>
                    <td>ID</td>
                    <th>Title</th>
                    <th>Shortcode</th>
                    <th>Tags</th>
                </tr>
            </thead>
            <tbody>
                <FeaturedList v-for="list in allLists" :key="list.id" :item="list" />
            </tbody>
        </table>
    </div>
</template>

<script>
import $ from 'jquery';
import FeaturedList from './FeaturedList.vue';

export default {
    components: {
        FeaturedList
    },
    data() {
        return {
            allLists: []
        }
    },
    mounted() {
        const that = this;
        $.ajax({
            type: "POST",
            url: ajax_url.ajaxurl,
            data: {
                action: "get_ffb_lists",
            },
            success: function(data) {
                that.allLists = data.data;
            }
        });
    },
    
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
        border-spacing: 0;
    }
</style>