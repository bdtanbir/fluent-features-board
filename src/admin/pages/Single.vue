<template>
    <div class="ffb-single-wrap">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        <div v-if="isUpdated" class="ffb-updated-table">
            Updated! <span @click="closeUpdatedAlert" class="close-ffb-updated-table">+</span>
        </div>
        <form @submit.prevent="updateTable">
            <div class="input-group">
                <label for="upd_title">
                    Title
                </label>
                <input type="text" id="upd_title" ref="upd_title" :value="tableInfos.title" @change="upd_title">
            </div>
            <div class="input-group">
                <label for="logourl">
                    Logo
                </label>
                <div class="logowrap">
                    <div v-if="tableInfos.logo" class="logo-preview">
                        <img ref="upd_logo" :src="tableInfos.logo" class="logo" alt="">
                        <span class="remove-preview-logo" @click="removePreviewLogo">
                            +
                        </span>
                    </div>
                    <span @click="selectLogo">
                        {{tableInfos.logo ? 'Change Logo' : 'Upload Logo'}}
                    </span>
                    <input ref="logourl" class="logourlinput" type="file" @input="pickLogo">
                </div>
            </div>
            <div class="input-group">
                <label for="sort_requests_by">
                    Sort requests by
                </label>
                <select name="sort_requests_by" ref="upd_sort_by" id="sort_requests_by" v-model="tableInfos.sort_by">
                    <option value="alphabetical">Alphabetical</option>
                    <option value="random">Random</option>
                    <option value="upvotes">Number of Upvotes</option>
                    <option value="comments">Number of Comments</option>
                </select>
            </div>
            <div class="input-group">
                <label for="show_upvotes">
                    Show upvotes
                </label>
                <select name="show_upvotes" ref="upd_show_upvotes" id="show_upvotes" v-model="tableInfos.show_upvotes">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="input-group">
                <label for="visibility">
                    Visibility
                </label>
                <select name="visibility" id="visibility" ref="upd_visibility" v-model="tableInfos.visibility">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div :class="isUpdating ? 'updating-table input-group ffb-single-update-btn' : 'input-group ffb-single-update-btn'">
                <button :disabled="isUpdating">
                    <span v-if="isUpdating" class="update-loader"></span> {{isUpdating ? 'Updating...' : 'Update'}}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import $ from 'jquery';

export default {
    name: 'Single',
    data() {
        return {
            // upd_title: '',
            tableInfos: this.$route.params.item ? this.$route.params.item : {},
            isUpdated: false,
            isUpdating: false,
        }
    },
    methods: {
        selectLogo () {
          this.$refs.logourl.click()
        },
        pickLogo () {
            let input = this.$refs.logourl
            let file = input.files
            if (file && file[0]) {
                let reader = new FileReader
                reader.onload = e => {
                    this.tableInfos.logo = e.target.result
                }
                reader.readAsDataURL(file[0])
                this.$emit('input', file[0])
            }
        },
        removePreviewLogo() {
            this.tableInfos.logo = null
        },
        upd_title() {
            this.tableInfos.title = this.$refs.upd_title.value;
        },
        updateTable() {
            const title = this.$refs.upd_title.value;
            const logo = this.$refs.upd_logo.src;
            const sort_by = this.$refs.upd_sort_by.value;
            const show_upvotes = this.$refs.upd_show_upvotes.value;
            const visibility = this.$refs.upd_visibility.value;
            const that = this;
            that.isUpdating = true;
            that.tableInfos.title = title;
            that.tableInfos.logo = logo;
            that.tableInfos.sort_by = sort_by;
            that.tableInfos.show_upvotes = show_upvotes;
            that.tableInfos.visibility = visibility;
            
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: ajax_url.ajaxurl,
                    dataType: 'json',
                    data: {
                        action: "update_fluent_features_board",
                        title: title,
                        logo: logo,
                        sort_by: sort_by,
                        show_upvotes: show_upvotes,
                        visibility: visibility,
                        id: that.tableInfos.id
                    },
                });
                that.isUpdating = false;
                that.isUpdated  = true;
                setTimeout(() => {
                    that.isUpdated = false;
                }, 20000)
            }, 2000)
        },
        closeUpdatedAlert() {
            this.isUpdated = false;
        }
    },
}
</script>

<style>
    .logowrap .logo-preview {
        width: 100px;
        height: 100px;
        position: relative;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .logowrap .logo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }
    .logowrap .logo-preview .remove-preview-logo {
        position: absolute;
        right: -5px;
        top: -5px;
        display: inline-block;
        width: 15px;
        height: 15px;
        line-height: 13px;
        text-align: center;
        border-radius: 50%;
        background: #878787;
        color: #fff;
        transform: rotate(45deg);
        cursor: pointer;
        box-shadow: 0 0 0 2px #fff;
        transition: .3s;
    }
    .logowrap .logo-preview .remove-preview-logo:hover {
        background: #ff0000;
    }

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
    .ffb-single-wrap .back-to-home-btn:focus {
        outline: none;
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
    .ffb-single-wrap form select,
    .ffb-single-wrap form textarea,
    .ffb-single-wrap form input {
        display: block;
        width: 100%;
        border: 1px solid #eee;
        padding: 3px 13px;
        transition: .3s;
        max-width: 100%;
        min-height: auto;
    }
    .ffb-single-wrap form textarea {
        height: 60px;
        resize: none;
    }
    .ffb-single-wrap form select:focus,
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .ffb-single-wrap form .ffb-single-update-btn.updating-table button {
        opacity: 0.7;
        cursor: no-drop;
    }
    .ffb-single-wrap form .ffb-single-update-btn button .update-loader {
        width: 10px;
        height: 10px;
        border-radius: 100%;
        border: 2px solid #fff;
        border-top: 2px solid transparent;
        border-bottom: 2px solid transparent;
        margin-right: 5px;
    }
    .ffb-single-wrap form .ffb-single-update-btn.updating-table button .update-loader {
        animation: rotating 1s infinite linear;
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
    .ffb-single-wrap form .logowrap > span {
        width: 100%;
        display: block;
        border: 1px solid #eee;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        background: #f1f1f1;
        text-align: center;
    }
    .ffb-single-wrap form .logowrap .logourlinput {
        width: 0;
        height: 0;
        opacity: 0;
        padding: 0;
        margin: 0;
    }
</style>