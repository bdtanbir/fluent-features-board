<template>
    <tr class="ffb-features-list">
        <th>
            <div class="ffb-id">{{item.id}}</div>
        </th>
        <td>
            <h1>{{item.title}}</h1>
            <div class="actions">
                <router-link :to="{name: 'Single', params:{item: item, id: item.id}}" class="edit-column">Edit</router-link> | 
                <a href="#" @click="deleteHandle" class="delete-column">Delete</a>
            </div>
        </td>
        <td>
            <input ref="ffb_copy" id="ffb-shortcode" :value="'[fluent_features_board id=\''+item.id+'\']'"  v-tooltip.top-center="copyTooltip" @click="copyURL" readonly>
        </td>
        <td>
            <div class="ffb-tags">
                <span>{{item.tags}}</span>
            </div>
        </td>
    </tr>
</template>

<script>


export default {
    props: ['item'],
    data() {
        return {
            copyTooltip: 'Click to Copy Shortcode'
        }
    },
    methods: {
        deleteHandle: function() {
            this.$emit('delete')
        },
        copyURL() {
            var Url = this.$refs.ffb_copy;
            Url.select();
            document.execCommand("copy");
        }
    },
    
}
</script>

<style>
    .ffb-features-list h1 {
        color: #000;
        font-size: 16px;
        font-weight: 400;
        padding: 0;
        margin: 0 0 2px 0;
        display: inline-block;
    }
    .ffb-features-list .actions {
        opacity: 0;
        visibility: hidden;
    }
    .ffb-features-list .actions .delete-column {
        color: red;
    }
    .ffb-featured-lists table tbody > tr:hover .actions {
        opacity: 1;
        visibility: visible;
    }
    .ffb-featured-lists table tbody th,
    .ffb-featured-lists table tbody td {
        border-bottom: 1px solid #eee;
        padding: 8px 0 8px 8px;
        transition: .3s;
    }
    .ffb-featured-lists table tbody th {
        vertical-align: top;
    }
    .ffb-featured-lists table tbody tr:hover th,
    .ffb-featured-lists table tbody tr:hover td {
        background: #f6f9ff;
    }
    .ffb-featured-list-table thead tr th, .ffb-featured-list-table thead tr td {
        border-bottom: 1px solid #eee;
        padding: 8px 0 8px 8px;
        color: #fff;
        border: none;
        border-width: 0;
    }
    .ffb-featured-list-table thead {
        background: linear-gradient(90deg, #ba42ec, #8f42ec);
    }
    .ffb-featured-lists table tbody td #ffb-shortcode {
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
    .ffb-featured-lists table tbody td #ffb-shortcode:focus {
        outline: none;
        box-shadow: none;
    }

    /* Tooltip */
    .tooltip {
        z-index: 10000;
        top: -8px !important;
    }
    .tooltip .tooltip-inner {
        background: #555;
        color: #fff;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 12px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .tooltip .tooltip-arrow  {
        position: absolute;
        width: 10px;
        height: 10px;
        background: #555;
        transform: rotate(45deg);
        left: 50%;
        bottom: -5px;
        margin-left: -5px;
    }
</style>