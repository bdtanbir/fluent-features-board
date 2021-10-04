<template>
    <div class="ff-requests-lists">
        <div class="ff-requests-lists-inner">
            <FFRDeletePopup v-if="isDeleteModal" :id="currentId" @cancelDelete="cancelDeleteTableRow" />

            <table class="ff-request-list-table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Public</th>
                    </tr>
                </thead>

                <tbody>
                    <RequestList @delete="deleteTableRow(list.id)" :item="list" v-for="list in lists" :key="list.id" />
                </tbody>
            </table>
            
        </div>
        <p class="ff-requests-total-rows">({{lists.length}}) Row</p>
    </div>
</template>

<script>
import $ from 'jquery';
import RequestList from './RequestList.vue';
import FFRDeletePopup from './FFRDeletePopup.vue'

export default {
    components: {
        RequestList,
        FFRDeletePopup
    },
    data() {
        return {
            lists: [],
            currentId: '',
            isDeleteModal: false
        }
    },
    methods: {
        deleteTableRow(id) {
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
            data: {
                action: 'getAllFeatureRequests'
            },
            success: function(res) {
                that.lists = res.data;
            }
        })
    },
}
</script>

<style>
    .ff-requests-lists {
        margin-top: 30px;
        background: #fff;
        border-radius: 4px;
        padding: 10px 15px;
    }
    .ff-requests-lists .ff-requests-lists-inner {
        max-height: 650px;
        overflow-x: hidden;
    }
    .ff-requests-lists table {
        width: 100%;
        text-align: left;
        border-spacing: 0;
    }
    .ff-requests-lists::-webkit-scrollbar {
        width: 6px;
        border-radius: 30px;
    }
    .ff-requests-lists::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 30px;
    }
    .ff-requests-lists .ff-requests-total-rows {
        text-align: right;
        font-weight: 400;
        margin: 15px 0 5px 0;
    }
</style>