<template>
    <div class="ffb-single-wrap">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        <div v-if="updateDone" class="ffb-updated-table">
            Updated! <span @click="closeUpdateDone" class="close-ffb-updated-table">+</span>
        </div>

        <form @submit.prevent="updateRequestList">
            <div class="input-group">
                <label for="upd_title">Title</label>
                <input @change="changeTitle" type="text" id="upd_title" ref="upd_title" placeholder="Title" :value="details.title">
            </div>
            <div class="input-group">
                <label for="upd_description">Description</label>
                <textarea @change="changeDetails" name="upd_description" id="upd_description" placeholder="Why do you want this" ref="upd_description" :value="details.description"></textarea>
            </div>
            <div class="input-group">
                <label for="status">Status</label>
                <select @change="changeStatus" name="status" id="status" ref="upd_status" :value="details.status">
                    <option value="planned">Planned</option>
                    <option value="inprogress">In Progress</option>
                    <option value="shipped">Shipped</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="input-group">
                <label for="ffr-tags">
                    Tags
                </label>
                <input type="text" id="ffr-tags" ref="tempTag" @keyup.188="addTag">
                <span class="description">
                    Add tags with <strong>commas</strong>
                </span>
                <div class="ffr-tags-list">
                    <span v-for="tag in tags" :key="tag.id" v-tooltip.top-center="'Click To Remove'" @click="deleteTag(tag)">{{tag.name}}</span>
                </div>
                <pre>
                    {{tags}}
                </pre>
            </div>
            <div class="input-group">
                <label for="is_public">
                    Is Public
                </label>
                <select @change="changeIsPublic" name="is_public" id="is_public" ref="is_public" :value="details.is_public">
                    <option value="true">Public</option>
                    <option value="false">Private</option>
                </select>
            </div>
            <div :class="isUpdating ? 'updating-table input-group ffr-single-update-btn' : 'input-group ffr-single-update-btn'">
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
            details: this.$route.params.item ? this.$route.params.item : {},
            tempTag: '',
            tags: [],
            isUpdating: false,
            updateDone: false,
        }
    },
    methods: {
        addTag(e) {
            const obj = {};
            this.$refs.tempTag.value = this.$refs.tempTag.value.replace(',', '')
            if (e.key === "," && this.$refs.tempTag.value) {
                if (!this.tags.includes(this.$refs.tempTag.value)) {
                    const tagSlug = this.$refs.tempTag.value.replace(' ', '-');
                    obj['id']       = '';
                    obj['name']     = this.$refs.tempTag.value;
                    obj['slug']     = tagSlug.toLowerCase();
                    obj['board_id'] = this.details.id;

                    this.tags.push(obj);
                }
                this.$refs.tempTag.value = "";
            }
        },
        deleteTag(tag) {
            this.tags = this.tags.filter((item) => {
                return tag !== item;
            });
        },
        updateRequestList() {
            const that = this;
            this.isUpdating = true
            setTimeout(() => {
                $.ajax({
                    type: 'POST',
                    url: ajax_url.ajaxurl,
                    dataType: 'json',
                    data: {
                        action: 'updateFeatureRequestList',
                        title: that.$refs.upd_title.value,
                        description: that.$refs.upd_description.value,
                        is_public: that.$refs.is_public.value,
                        status: that.$refs.upd_status.value,
                        tags: that.tags,
                        parent_id: that.details.parent_id,
                        id: that.details.id
                    }
                });
                that.isUpdating = false;
                that.updateDone = true;
                setTimeout(() => {
                    that.updateDone = false;
                }, 100000);
            }, 2500);
        },
        changeTitle() {
            this.details.title = this.$refs.upd_title.value
        },
        changeStatus() {
            this.details.status = this.$refs.upd_status.value
        },
        changeIsPublic() {
            this.details.is_public = this.$refs.is_public.value
        },
        changeDetails() {
            this.details.description = this.$refs.upd_description.value
        },
        closeUpdateDone() {
            this.updateDone = false
        }
    },
    mounted() {
        const that = this;
        $.ajax({
            type: 'POST',
            url: ajax_url.ajaxurl,
            dataType: 'json',
            data: {
                action: 'getTagsByCurrentRequest',
                id: that.details.id
            },
            success: function(res) {
                that.tags = res.data;
            }
        })
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
        padding: 6px 15px;
        border: 1px solid #e1eaea;
        border-radius: 4px;
        font-size: 14px;
        margin: 0;
        transition: .2s;
        max-width: 100%;
        min-height: auto;
    }
    .ffb-single-wrap form textarea {
        height: 100px;
        display: block;
    }
    .ffb-single-wrap form select:focus,
    .ffb-single-wrap form textarea:focus,
    .ffb-single-wrap form input:focus {
        box-shadow: none;
        outline: none;
        box-shadow: none;
        border-color: #2771b1;
    }
    .ffb-single-wrap form .description {
        font-weight: 300;
        color: #aaa;
        font-style: italic;
        margin-top: 2px;
        display: block;
    }
    .ffb-single-wrap form .description strong {
        color: #000;
    }
    .ffb-single-wrap form .ffr-single-update-btn button {
        border: none;
        margin-top: 0;
        background: #33cc0d;
        color: #fff;
        padding: 8px 15px;
        box-shadow: 2px 2px 0 rgba(0,0,0,0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 4px;
    }
    .ffb-single-wrap form .ffr-single-update-btn.updating-table button {
        opacity: 0.7;
        cursor: no-drop;
    }
    .ffb-single-wrap form .ffr-single-update-btn button .update-loader {
        width: 10px;
        height: 10px;
        border-radius: 100%;
        border: 2px solid #fff;
        border-top: 2px solid transparent;
        border-bottom: 2px solid transparent;
        margin-right: 5px;
    }
    .ffb-single-wrap form .ffr-single-update-btn.updating-table button .update-loader {
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
    .ffb-single-wrap form .input-group.input-checkbox {
        display: flex;
        align-items: center;
    }
    .ffb-single-wrap form .input-group.input-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        box-shadow: none;
        border: 1px solid #eee;
        background: #eee;
        border-radius: 2px;
        margin: 0;
        position: relative;
        transition: .3s;
    }
    .ffb-single-wrap form .input-group.input-checkbox input[type="checkbox"]:before {
        content: '';
        position: absolute;
        left: 6px;
        top: 3px;
        width: 6px;
        height: 10px;
        border-bottom: 2px solid #fff;
        border-right: 2px solid #fff;
        transform: rotate(33deg) scale(0);
        transition: .2s;
    }
    .ffb-single-wrap form .input-group.input-checkbox input[type="checkbox"]:checked:before {
        left: 10px;
        top: 6px;
        transform: rotate(33deg) scale(1);
    }
    .ffb-single-wrap form .input-group.input-checkbox input[type="checkbox"]:checked {
        background: #ba42ec;
    }
    .ffb-single-wrap form .input-group.input-checkbox input[type="checkbox"]:checked {
        border-color: #ba42ec;
    }
    .ffb-single-wrap form .input-group.input-checkbox label {
        margin: 0 0 0 5px;
    }
    .ffb-single-wrap .input-group .ffr-tags-list {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 5px;
    }
    .ffb-single-wrap .input-group .ffr-tags-list span {
        margin-right: 5px;
        background: #f1f1f1;
        border-radius: 40px;
        padding: 3px 10px;
        cursor: pointer;
        display: inline-block;
        transition: .3s;
        -webkit-transition: .3s;
        -moz-transition: .3s;
        -ms-transition: .3s;
        -o-transition: .3s;
    }
    .ffb-single-wrap .input-group .ffr-tags-list span:hover {
        background: #ba42ec;
        color: #ffffff;
    }
    @keyframes rotating {
        0% {
            transform: rotate(0);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>