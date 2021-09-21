<template>
    <div class="ffb-confirm-delete-table-pop">
        <div class="ffb-confirm-delete-table-inner">
            <h1>Are you sure?</h1>
            <p>Do you want to delete this row?</p>
            <div class="ffb-confirm-delete-btns">
                <button @click="cancelDeleteHandle" class="ffb-delete-btn no-btn">NO</button>
                <button @click="deleteTableColumn" class="ffb-delete-btn yes-btn">
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
        deleteTableColumn: function(e) {
            e.preventDefault();
            const that = this;
            this.isDeleting = true;
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: ajax_url.ajaxurl,
                    data: {
                        action: "delete_ffb_table_column",
                        id: this.id
                    },
                    success: function(data) {
                        this.isDeleting = false;
                        // window.location.reload();
                        setTimeout(() => {
                            console.log('i am working');
                        })
                    }
                });
            }, 2000)
        },
    },
    
}
</script>

<style scoped>
    .ffb-confirm-delete-table-pop {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgb(0 0 0 / 60%);
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner {
        background: #fff;
        max-width: 300px;
        padding: 20px 30px 30px 30px;
        box-sizing: border-box;
        text-align: center;
        margin: 20px auto auto auto;
        border-radius: 4px;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner h1 {
        padding: 0;
        margin: 0 0 10px 0;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner p {
        margin: 0 0 15px 0;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner .ffb-confirm-delete-btns {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner .ffb-confirm-delete-btns button {
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
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner .ffb-confirm-delete-btns button:hover {
        background: #ad0d0d;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner .ffb-confirm-delete-btns .yes-btn {
        background: #07d007;
    }
    .ffb-confirm-delete-table-pop .ffb-confirm-delete-table-inner .ffb-confirm-delete-btns .yes-btn:hover {
        background: #08b308;
    }
</style>