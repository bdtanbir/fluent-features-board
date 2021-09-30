<template>
    <div class="ff-requests-lists">
        <div class="ff-requests-lists-inner">

            <table class="ff-request-list-table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <th>Title</th>
                        <th>Shortcode</th>
                        <th>Tags</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <RequestList />
                </tbody>
            </table>
            
        </div>
        <p class="ff-requests-total-rows">(1) Row</p>
    </div>
</template>

<script>
import RequestList from './RequestList.vue';

export default {
    components: {
        RequestList
    }
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