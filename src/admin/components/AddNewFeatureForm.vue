<template>
    <div class="ffb-add-new-feature-modal">
        <div :class=" isLoading ? 'adding-ffb ffb-add-new-feature-modal-content' : 'ffb-add-new-feature-modal-content'">
            <div v-show="isLoading || isDone" :class="isDone ? 'added-ffb form-loader' : 'form-loader'">
                <span></span>
                <h2 v-if="isDone" class="ffb-form-added">Done</h2>
                <a v-if="isDone" href="" class="done-btn">OK</a>
            </div>
            <h1>Add New</h1>
            <form :class="isDone ? 'hidden-form': ''" @submit.prevent="formSubmited">
                <div class="input-group">
                    <label for="feature-title">
                        Title
                    </label>
                    <input type="text" id="feature-title" required v-model="title">
                </div>
                <div class="input-group">
                    <label for="feature-description">
                        Description
                    </label>
                    <input type="text" id="feature-description" required v-model="description">
                </div>
                <div class="input-group">
                    <label for="feature-tags">
                        Tags
                    </label>
                    <input type="text" id="feature-tags" v-model="tmplTags">
                    <span class="description">
                        Add tags with <strong>comma</strong>
                    </span>
                </div>
                <!-- <div class="input-group">
                    <label for="feature-privacy">
                        Make it private
                    </label>
                    <input type="checkbox" id="feature-privacy">
                </div> -->
                <div class="input-group">
                    <button class="ffb-addnewfeature-submit">
                        Add New
                    </button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import $ from 'jquery';


export default {
    data() {
        return {
            title: '',
            description: '',
            tmplTags: '',
            isDone: false,
            isLoading: false
        }
    },
    methods: {
        formSubmited: function() {
            if (this.title && this.description && this.tags) {
                const that = this;
                this.isLoading = true;
                setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: ajax_url.ajaxurl,
                        data: {
                            action: "action_ffb_callback",
                            title: this.title,
                            description: this.description,
                            tags: this.tmplTags,
                        },
                        success: function() {
                            that.title = '';
                            that.description = '';
                            that.tmplTags = '';
                            that.isDone = true
                            that.isLoading = false;
                        }
                    });
                },3000);
            }
        },
    },
}
</script>

<style lang="css">
    .ffb-add-new-feature-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        background: rgba(0,0,0,0.5);
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content {
        background: #fff;
        margin-top: 100px;
        border-radius: 4px;
        width: 100%;
        max-width: 500px;
        padding: 20px 30px 30px 30px;
        position: relative;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content h1 {
        padding: 0;
        font-size: 22px;
        margin-bottom: 20px;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .input-group + .input-group {
        margin-top: 15px;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .input-group input {
        display: block;
        width: 100%;
        border: 1px solid #eee;
        padding: 3px 13px;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .input-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: inline-block;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .input-group .ffb-addnewfeature-submit {
        background: #2771b1;
        border: none;
        color: #fff;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .description {
        font-weight: 300;
        display: block;
        color: #aaa;
        font-size: 12px;
        font-style: italic;
        margin: 3px 0 0 0;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .description strong {
        color: #000;
    }
    .form-loader {
        position: absolute;
        background: rgb(255 255 255 / 80%);
        z-index: 99;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .added-ffb.form-loader {
        background: #fff;
    }
    .form-loader span {
        display: inline-block;
        width: 80px;
        height: 80px;
        border: 3px solid #eee;
        border-radius: 100%;
        border-top: 2px solid #2771b1;
        position: relative;
        transition: .3s;
    }
    .added-ffb.form-loader span {
        border-color: #2771b1;
    }
    .adding-ffb .form-loader span {
        animation: rotating 1s infinite linear;
    }
    .form-loader h2 {
        margin: 15px 0 15px 0;
        font-size: 20px;
    }
    .form-loader span:before {
        content: '';
        width: 16px;
        height: 35px;
        border-bottom: 2px solid #2771b1;
        position: absolute;
        border-right: 2px solid #2771b1;
        transform: rotate(45deg) scale(0);
        left: 33px;
        top: 16px;
        transition: .3s;
    }
    .added-ffb.form-loader span:before {
        transform: rotate(45deg) scale(1);
    }
    .form-loader .done-btn {
        background: #2771b1;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        padding: 5px 13px;
        display: inline-block;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .tags {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .tags span {
        background: #eee;
        border-radius: 30px;
        margin-right: 5px;
        padding: 1px 8px 3px 8px;
        display: inline-block;
        cursor: pointer;
        transition: .2s;
    }
    .ffb-add-new-feature-modal .ffb-add-new-feature-modal-content form .tags span:hover {
        opacity: 0.5;
    }

    @keyframes rotating {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>