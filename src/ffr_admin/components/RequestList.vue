<template>
    <tr class="ff-request-list">
        <th>
            <div class="ffr-id">1</div>
        </th>
        <td>
            <h1>1st Title</h1>
            <div class="actions">
                <a href="" class="edit-column">Edit</a> | 
                <a href="#" class="delete-column">Delete</a>
            </div>
        </td>
        <td>
            <input ref="ffr_copy" id="ffr-shortcode" v-tooltip.top-center="copyTooltip" value="[fluent_features_request id='1']" @click="copyURL" readonly>
        </td>
        <td>
            <div class="ffr-tags">
                <span>HTML</span>
            </div>
        </td>
        <td>
            <span class="ffr-post-status">
                Publish
            </span>
        </td>
    </tr>
</template>

<script>
export default {
    data() {
        return {
            copyTooltip: 'Click to Copy Shortcode'
        }
    },
    methods: {
        copyURL() {
            var Url = this.$refs.ffr_copy;
            Url.select();
            document.execCommand("copy");
            this.copyTooltip = 'Copied Shortcode';
            setTimeout(() => {
                this.copyTooltip = 'Click to Copy Shortcode';
            }, 3000)
        }
    }
}
</script>

<style>
    .ff-request-list-table .actions {
        opacity: 0;
        visibility: hidden;
    }
    .ff-request-list-table .actions .delete-column {
        color: red;
    }
    .ff-request-list-table table tbody > tr:hover .actions {
        opacity: 1;
        visibility: visible;
    }
    .ff-request-list-table table tbody th,
    .ff-request-list-table table tbody td {
        border-bottom: 1px solid #f3f3f3;
        padding: 8px 0 8px 8px;
        transition: .3s;
    }
    .ff-request-list-table table tbody th {
        vertical-align: top;
    }
    .ff-request-list-table table tbody tr:hover th,
    .ff-request-list-table table tbody tr:hover td {
        background: #f6f9ff;
    }
    .ff-request-list-table thead tr th, .ff-request-list-table thead tr td {
        border-bottom: 1px solid #eee;
        padding: 8px 0 8px 8px;
        color: #fff;
        border: none;
        border-width: 0;
    }
    .ff-request-list-table thead {
        background: linear-gradient(90deg, #ba42ec, #8f42ec);
    }
    .ff-request-list-table tbody td #ffr-shortcode {
        border: none;
        background: #eee;
        padding: 5px 5px 6px 7px;
        display: inline-block;
        cursor: context-menu;
        font-weight: 400;
        font-size: 13px;
        width: 210px;
        text-align: center;
        margin: 0;
        border-radius: 2px;
    }
    .ff-request-list-table tbody td #ffr-shortcode:focus {
        outline: none;
        box-shadow: none;
    }
    
</style>