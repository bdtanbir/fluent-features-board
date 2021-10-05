<template>
    <div class="ffb-featured-lists">
        <div class="ffb-featured-lists-inner">
            <FFBDeletePopup v-if="isDeleteModal" @cancelDelete="cancelDeleteTableRow" :id="currentId" />


            <table class="ffb-featured-list-table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <th>Title</th>
                        <th>Shortcode</th>
                        <th>Sort By</th>
                        <th>Visibility</th>
                    </tr>
                </thead>
                <tbody v-if="allLists">
                    <FeaturedList v-for="list in allLists" :key="list.id" :item="list" @delete="deleteTableRow(list.id)" />
                </tbody>
            </table>
        </div>
        <p class="ffb-features-total-row">({{allLists.length}}) Rows</p>
    </div>
</template>

<script>
import $ from 'jquery';
import FeaturedList from './FeaturedList.vue';
import FFBDeletePopup from './FFBDeletePopup.vue';

export default {
    components: {
        FeaturedList,
        FFBDeletePopup
    },
    data() {
        return {
            allLists: [],
            isDeleteModal: false,
            currentId: ''
        }
    },
    methods: {
        deleteTableRow: function(id) {
            this.isDeleteModal = true;
            this.currentId = id;
        },
        cancelDeleteTableRow: function() {
            this.isDeleteModal = false;
        }
    },
    mounted() {
        const that = this;
        $.ajax({
            type: "POST",
            url: ajax_url.ajaxurl,
            dataType: 'json',
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
    .ffb-featured-lists .ffb-featured-lists-inner {
        max-height: 650px;
        overflow-x: hidden;
    }
    .ffb-featured-lists table {
        width: 100%;
        text-align: left;
        border-spacing: 0;
    }
    .ffb-featured-lists::-webkit-scrollbar {
        width: 6px;
        border-radius: 30px;
    }
    .ffb-featured-lists::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 30px;
    }
    .ffb-featured-lists .ffb-features-total-row {
        text-align: right;
        font-weight: 400;
        margin: 15px 0 5px 0;
    }
</style>