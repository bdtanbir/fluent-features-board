<template>
    <div class="ffr-confirm-delete-table-pop" @click.self="cancelDeleteHandle">
        <div class="ffr-confirm-delete-table-inner">
            <h1>Are you sure?</h1>
            <p>Do you want to delete this row?</p>
            <div :class="isDeleting ? 'disabled-btn ffb-confirm-delete-btns': 'ffb-confirm-delete-btns'">
                <button @click="cancelDeleteHandle" class="ffb-delete-btn no-btn" :disabled="isDeleting">NO</button>
                <button @click="deleteFeatureRequestRow" class="ffb-delete-btn yes-btn" :disabled="isDeleting">
                    {{isDeleting ? 'Deleting...' : 'Yes'}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import $ from 'jquery';

export default {
    props: ['id'],
    data() {
        return {
            isDeleting: false
        }
    },
    methods: {
        cancelDeleteHandle: function() {
            this.$emit('cancelDelete');
        },
        deleteFeatureRequestRow: function(e) {
            const that = this;
            this.isDeleting = true;
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: ajax_url.ajaxurl,
                    dataType: 'json',
                    data: {
                        action: 'action_deleteFeatureRequestRow',
                        id: that.id
                    }
                });
                that.isDeleting = false;
                window.location.reload();
            }, 2000)
        },
    },
}
</script>

<style>
    
    .ffr-confirm-delete-table-pop {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgb(0 0 0 / 60%);
        padding-top: 50px;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner {
        background: #fff;
        max-width: 300px;
        padding: 20px 30px 30px 30px;
        box-sizing: border-box;
        text-align: center;
        margin: 20px auto auto auto;
        border-radius: 4px;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner h1 {
        padding: 0;
        margin: 0 0 10px 0;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner p {
        margin: 0 0 15px 0;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns button {
        background: #d21414;
        border: none;
        color: #fff;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 4px;
        box-shadow: 2px 2px 0px rgb(0 0 0 / 10%);
        transition: .2s;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns.disabled-btn button {
        opacity: 0.3;
        cursor: no-drop;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns button:hover {
        background: #ad0d0d;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns .yes-btn {
        background: #07d007;
    }
    .ffr-confirm-delete-table-pop .ffr-confirm-delete-table-inner .ffb-confirm-delete-btns .yes-btn:hover {
        background: #08b308;
    }
</style>