<template>
    <div class="ffb-single-wrap">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        <div v-if="isUpdated" class="ffb-updated-table">
            Updated! <span class="close-ffb-updated-table">+</span>
        </div>
        <form @submit.prevent="updateTable">
            <div class="input-group">
                <label for="upd_title">
                    Title
                </label>
                <input type="text" id="upd_title" ref="upd_title" :value="tableInfos.title">
            </div>
            <div class="input-group">
                <label for="upd_tags">
                    Tags
                </label>
                <input type="text" id="upd_tags" ref="upd_tags" :value="tableInfos.tags">
            </div>
            <div class="input-group">
                <label for="upd_description">
                    Description
                </label>
                <textarea name="upd_description" id="upd_description" :value="tableInfos.description"></textarea>
            </div>
            <div class="input-group ffb-single-update-btn">
                <button>Update</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Single',
    data() {
        return {
            upd_title: '',
            tableInfos: this.$route.params.item ? this.$route.params.item : {},
            isUpdated: false,
        }
    },
    methods: {
        updateTable() {
            const title = this.$refs.upd_title
            console.log('updated: '+title.value);
        }
    },
}
</script>

<style>
    .ffb-single-wrap {
        margin-top: 15px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 0 30px rgb(0 0 0 / 2%);
        padding: 20px 20px 20px 20px;
    }
    .ffb-single-wrap .back-to-home-btn {
        display: inline-block;
        background: #fff;
        text-decoration: none;
        color: #000;
        padding: 4px 10px;
        border-radius: 4px;
        transition: .3s;
        box-shadow: 2px 2px 0px rgb(0 0 0 / 15%);
        border: 1px solid #eee;
    }
    .ffb-single-wrap form {
        margin-top: 20px;
        max-width: 400px;
    }
    .ffb-single-wrap form .input-group + .input-group {
        margin-top: 15px;
    }
    .ffb-single-wrap form label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    .ffb-single-wrap form textarea,
    .ffb-single-wrap form input {
        display: block;
        width: 100%;
        border: 1px solid #eee;
        padding: 3px 13px;
        transition: .3s;
    }
    .ffb-single-wrap form textarea {
        height: 60px;
    }
    .ffb-single-wrap form textarea:focus,
    .ffb-single-wrap form input:focus {
        box-shadow: none;
        outline: none;
        border-color: #2771b1;
    }
    .ffb-single-wrap form .ffb-single-update-btn button {
        border: none;
        margin-top: 0;
        background: #33cc0d;
        padding: 8px 15px;
        box-shadow: 2px 2px 0 rgba(0,0,0,0.1);
    }
    .ffb-updated-table {
        border-left: 3px solid #00a32a;
        padding: 10px 15px 10px 15px;
        font-size: 14px;
        box-shadow: 0 0 2px rgb(0 0 0 / 30%);
        margin-top: 20px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ffb-updated-table .close-ffb-updated-table {
        background: #e4e4e4;
        display: inline-block;
        width: 18px;
        height: 18px;
        line-height: 16px;
        text-align: center;
        border-radius: 50%;
        cursor: pointer;
        color: #000;
        transform: rotate(45deg);
        transition: .3s;
    }
</style>