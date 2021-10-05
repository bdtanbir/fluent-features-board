<template>
    <div class="ffb-single-wrap ffr-feature-board-single">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        
        <div class="ffr-feature-board-single-header">
            <div v-if="isSubmitted" class="ffr-submitted-table">
                Submitted! <span @click="closeSubmittedAlert" class="close-ffr-submitted-table">+</span>
            </div>
            <div class="d-flex">
                <button class="ff-addnewrequest" @click="handleFFRequestForm">
                    New Feature Request
                </button>
                <div class="ff-requests-search">
                    <input type="search" name="s" placeholder="Search feature requests">
                </div>
            </div>

            <div :class=" isFeatureRequestForm ? 'active ff-requests-form-wrap' : 'ff-requests-form-wrap'">
                <form class="ff-requests-form" @submit.prevent="submitFeatureRequest">
                    <h1>Suggest new feature</h1>
                    <div class="input-group">
                        <input type="text" placeholder="Title" v-model="title">
                        <p v-if="isEmptyTitle" class="error-text">You forgot to enter the title</p>
                    </div>
                    <div class="input-group">
                        <textarea name="description" id="description" placeholder="Why do you want this" v-model="description"></textarea>
                        <p class="error-text" v-if="isEmptyDesc">You forgot to enter the description</p>
                    </div>
                    <div class="input-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" v-model="status">
                            <option value="planned">Planned</option>
                            <option value="inprogress">In Progress</option>
                            <option value="shipped">Shipped</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <!-- <div class="input-group">
                        <label for="ffr-tags">
                            Tags
                        </label>
                        <input type="text" id="ffr-tags" v-model="tempTag" @keyup.188="addTag">
                        <span class="description">
                            Separate tags with <strong>commas</strong>
                        </span>
                        <div class="ffr-tags-list">
                            <span v-for="tag in tags" :key="tag" v-tooltip.top-center="'Click To Remove'" @click="deleteTag(tag)">{{tag}}</span>
                        </div>
                    </div> -->
                    <div class="input-group">
                        <label for="is_public">
                            Is Public
                        </label>
                        <select name="is_public" id="is_public" v-model="is_public">
                            <option value="true">Public</option>
                            <option value="false">Private</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <button :class="isSubmitting ? 'submitting-request ff-request-submit' : 'ff-request-submit'">
                            <span v-if="isSubmitting" class="update-loader"></span> {{submitBtnText}}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Feature Requests List -->
        <FFRequestsList :items="requestsList" />

    </div>
</template>

<script>
import $ from 'jquery';
import FFRequestsList from '../components/FFRequestsList.vue'
export default {
    components: {
        FFRequestsList
    },
    data() {
        return {
            FRBsingle: this.$route.params.board ? this.$route.params.board : {},
            isFeatureRequestForm: false,
            // tempTag: '',
            // tags: [],
            status: 'planned',
            is_public: 'true',
            isEmptyTitle: false,
            isEmptyDesc: false,
            title: '',
            description: '',
            isSubmitting: false,
            isSubmitted: false,
            submitBtnText: 'Suggest Feature',
            requestsList: []
        }
    },    
    methods: {
        // addTag(e) {
        //     this.tempTag = this.tempTag.replace(',', '')
        //     if (e.key === "," && this.tempTag) {
        //         if (!this.tags.includes(this.tempTag)) {
        //         this.tags.push(this.tempTag);
        //         }
        //         this.tempTag = "";
        //     }
        // },
        // deleteTag(tag) {
        //     this.tags = this.tags.filter((item) => {
        //         return tag !== item;
        //     });
        // },
        handleFFRequestForm() {
            this.isFeatureRequestForm  = !this.isFeatureRequestForm;
        },
        submitFeatureRequest() {
            const that = this;
            if(!this.title) {
                this.isEmptyTitle = true;
                return false;
            } else {
                this.isEmptyTitle = false;
            }
            if(!this.description) {
                this.isEmptyDesc = true;
                return false;
            } else {
                this.isEmptyDesc = false;
            }
            this.isSubmitting = true;
            this.submitBtnText = 'Submitting...';
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: ajax_url.ajaxurl,
                    dataType: 'json',
                    data: {
                        action: 'submit_feature_request',
                        title: that.title,
                        description: that.description,
                        // tags: that.tags,
                        status: that.status,
                        is_public: that.is_public,
                        id: that.FRBsingle.id
                    },
                    success: function() {
                        that.isSubmitting = false
                        that.submitBtnText = 'Suggest Feature';
                        that.isSubmitted = true;
                        that.title = '';
                        that.description = '';
                        // that.tags = [];
                        setTimeout(() => {
                            that.isSubmitted = false;
                        }, 100000);
                    }
                });
            }, 3000);

        },
        closeSubmittedAlert() {
            this.isSubmitted = false;
        }
    },
    mounted() {
        const that = this;
        $.ajax({
            type: 'POST',
            url: ajax_url.ajaxurl,
            dataType: 'json',
            data: {
                action: 'get_feature_requests_list',
                sort_by: that.FRBsingle.sort_by,
                id: that.FRBsingle.id
            },
            success: function(res) {
                that.requestsList = res.data;
            }
        })
    },
}
</script>


<style>
    .ffr-feature-board-single-header {
        margin-top: 10px;
    }
    .ffr-feature-board-single-header .d-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ffr-feature-board-single-header .ff-addnewrequest {
        background: #a8adb9;
        color: #fff;
        padding: 8px 16px;
        display: inline-block;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 300;
        border: none;
        transition: .3s;
        cursor: pointer;
    }
    .ffr-feature-board-single-header .ff-addnewrequest:active,
    .ffr-feature-board-single-header .ff-addnewrequest:hover {
        background: #828897 !important;
    }
    .ffr-feature-board-single-header .ff-requests-search input {
        border: 1px solid #eee;
        border-radius: 4px;
        padding: 7px 15px;
        font-size: 14px;
        width: 300px;
    }
    .ff-requests-form {
        border: 1px solid #e1eaea;
        border-radius: 4px;
        margin-top: 30px;
        padding: 15px 20px 20px 20px;
    }
    .ff-requests-form h1 {
        font-size: 20px;
        font-weight: 600;
        margin: 0 0 15px 0;
    }
    .ff-requests-form .input-group textarea,
    .ff-requests-form .input-group input {
        width: 100%;
        padding: 6px 15px;
        border: 1px solid #e1eaea;
        border-radius: 4px;
        font-size: 14px;
        margin: 0;
        transition: .2s;
    }
    .ff-requests-form .input-group + .input-group {
        margin-top: 15px;
    }
    .ff-requests-form .input-group textarea {
        height: 100px;
        display: block;
    }
    .ff-requests-form .ff-request-submit {
        background: #ba42ec;
        color: #fff;
        border: none;
        padding: 10px 18px;
        font-size: 15px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .ff-requests-form .ff-request-submit.submitting-request {
        opacity: 0.3;
    }
    .ff-requests-form .ff-request-submit .update-loader {
        width: 10px;
        height: 10px;
        border-radius: 100%;
        border: 2px solid #fff;
        border-top: 2px solid transparent;
        border-bottom: 2px solid transparent;
        margin-right: 5px;
    }
    .ff-requests-form .ff-request-submit.submitting-request .update-loader {
        animation: rotating 1s infinite linear;
    }
    .ff-requests-form .input-group .description {
        color: #aaa;
        font-weight: 300;
        margin-top: 3px;
        display: block;
    }
    .ff-requests-form .input-group .description strong {
        color: #000;
    }
    .ff-requests-form-wrap {
        max-height: 0;
        transition: .5s;
        overflow: hidden;
    }
    .active.ff-requests-form-wrap {
        max-height: 1000px;
    }
    .ff-requests-form .input-group .ffr-tags-list {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 5px;
    }
    .ff-requests-form .input-group .ffr-tags-list span {
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
    .ff-requests-form .input-group .ffr-tags-list span:hover {
        background: #ba42ec;
        color: #ffffff;
    }
    .error-text {
        color: red;
        font-size: 13px;
        font-weight: 300;
        margin: 2px 0 0 0;
        font-style: italic;
    }



    .ff-requests-form .input-group.input-checkbox {
        display: flex;
        align-items: center;
    }
    .ff-requests-form .input-group.input-checkbox input[type="checkbox"] {
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
    .ff-requests-form .input-group.input-checkbox input[type="checkbox"]:before {
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
    .ff-requests-form .input-group.input-checkbox input[type="checkbox"]:checked:before {
        left: 10px;
        top: 6px;
        transform: rotate(33deg) scale(1);
    }
    .ff-requests-form .input-group.input-checkbox input[type="checkbox"]:checked {
        background: #ba42ec;
    }
    .ff-requests-form .input-group.input-checkbox input[type="checkbox"]:checked {
        border-color: #ba42ec;
    }
    .ff-requests-form .input-group.input-checkbox label {
        margin: 0 0 0 5px;
    }
    .ffr-submitted-table {
        border-left: 3px solid #00a32a;
        padding: 10px 15px 10px 15px;
        font-size: 14px;
        box-shadow: 0 0 2px rgb(0 0 0 / 30%);
        margin-top: 20px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .ffr-submitted-table .close-ffr-submitted-table {
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