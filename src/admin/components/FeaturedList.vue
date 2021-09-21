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
            <input id="ffb-shortcode" :value="'[fluent_features_board id=\''+item.id+'\']'" title="Click to Copy" readonly>
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
        }
    },
    methods: {
        deleteHandle: function() {
            this.$emit('delete')
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
    .ffb-featured-lists table tbody tr:hover th,
    .ffb-featured-lists table tbody tr:hover td {
        background: #f6f9ff;
    }
    .ffb-featured-list-table thead tr th, .ffb-featured-list-table thead tr td {
        border-bottom: 1px solid #eee;
        padding: 8px 0 8px 8px;
        background: #000;
        color: #fff;
        border: none;
        border-width: 0;
    }
    .ffb-featured-lists table tbody td #ffb-shortcode {
        border: none;
        background: #eee;
        padding: 5px 5px 6px 7px;
        display: inline-block;
        cursor: pointer;
        font-weight: 300;
        font-size: 12px;
        width: 190px;
    }
    .ffb-featured-lists table tbody td #ffb-shortcode:focus {
        outline: none;
        box-shadow: none;
    }
</style>