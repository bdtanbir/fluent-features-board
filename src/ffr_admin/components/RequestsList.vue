<template>
    <div class="ff-requests-lists">
        <div class="ff-requests-list-sort-option">
            Sort by
            <select @change="sortRequestsCallback" name="ff-requests-list-sort" id="ff-requests-list-sort" v-model="sortRequestsList">
                <option value="all">All</option>
                <option v-for="item in boards" :key="item.id" :value="item.id">
                    {{item.title}}
                </option>
            </select>
            Board(s)
        </div>
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

                <tbody v-if="sortRequestsList == 'all'">
                    <RequestList @delete="deleteTableRow(list.id)" :item="list" v-for="list in lists" :key="list.id" />
                </tbody>
                <tbody v-if="isSorting">
                    <p v-if="listsByBoard.length == 0">No Request Found!</p>
                    <RequestList @delete="deleteTableRow(list.id)" :item="list" v-for="list in listsByBoard" :key="list.id" />
                </tbody>
            </table>
            
        </div>
        <p class="ff-requests-total-rows">({{ sortRequestsList == 'all' ? lists.length : listsByBoard.length}}) Row</p>
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
            isDeleteModal: false,
            boards: [],
            sortRequestsList: 'all',
            isSorting: false,
            listsByBoard: []
        }
    },
    methods: {
        deleteTableRow(id) {
            this.isDeleteModal = true;
            this.currentId = id;
        },
        cancelDeleteTableRow: function() {
            this.isDeleteModal = false;
        },
        sortRequestsCallback: function() {
            const that = this;
            this.sortRequestsList == 'all' ? this.isSorting = false : this.isSorting = true
            $.ajax({
                type: 'POST',
                url: ajax_url.ajaxurl,
                dataType: 'json',
                data: {
                    action: 'sortFeaturesRequests',
                    sort_by: that.sortRequestsList
                },
                success: function(res) {
                    that.listsByBoard = res.data
                }
            })
        }
    },
    mounted() {
        const that = this;
        $.ajax({
            type: "POST",
            url: ajax_url.ajaxurl,
            dataType: 'json',
            data: {
                action: 'getAllFeatureRequests'
            },
            success: function(res) {
                that.lists = res.data;
            }
        });
        // Get All Boards List
        $.ajax({
            type: 'POST',
            url: ajax_url.ajaxurl,
            dataType: 'json',
            data: {
                action: 'getAllBoardsList'
            },
            success: function(res) {
                that.boards = res.data;
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
    .ff-requests-list-sort-option {
        margin-bottom: 10px;
        font-size: 14px;
        color: #828897;
    }
    .ff-requests-list-sort-option select {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 2px 25px 2px 15px;
        color: #828897;
        transition: .3s;
        -webkit-transition: .3s;
        -ms-transition: .3s;
        -moz-transition: .3s;
        -o-transition: .3s;
    }
    .ff-requests-list-sort-option select:hover,
    .ff-requests-list-sort-option select:focus {
        outline: none;
        box-shadow: none;
        border: 1px solid #ba42ec;
        color: #ba42ec;
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