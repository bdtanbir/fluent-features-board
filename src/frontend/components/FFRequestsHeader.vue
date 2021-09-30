<template>
    <div class="ff-requests-header">
        <div class="d-flex">
            <button class="ff-addnewrequest" @click="handleFFRequestForm">
                New Feature Request
            </button>
            <div class="ff-requests-search">
                <input type="search" name="s" placeholder="Search feature requests">
            </div>
        </div>

        <div :class=" isFeatureRequestForm ? 'active ff-requests-form-wrap' : 'ff-requests-form-wrap'">
            <form class="ff-requests-form">
                <h1>Suggest new feature</h1>
                <div class="input-group">
                    <input type="text" placeholder="Title">
                </div>
                <div class="input-group">
                    <textarea name="description" id="description" placeholder="Why do you want this"></textarea>
                </div>
                <div class="input-group">
                    <button class="ff-request-submit">
                        Suggest Feature
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isFeatureRequestForm: false
        }
    },
    methods: {
        handleFFRequestForm() {
            this.isFeatureRequestForm  = !this.isFeatureRequestForm;
        }
    },
}
</script>

<style>
    .ff-requests-header .d-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ff-requests-header .ff-addnewrequest {
        background: #a8adb9 !important;
        color: #fff !important;
        padding: 8px 16px;
        display: inline-block;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 400;
        border: none;
        transition: .3s;
    }
    .ff-requests-header .ff-addnewrequest:active,
    .ff-requests-header .ff-addnewrequest:hover {
        background: #828897 !important;
    }
    .ff-requests-header .ff-requests-search input {
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
        background: #ba42ec !important;
        color: #fff !important;
        border: none;
        padding: 8px 18px;
        font-size: 15px;
        border-radius: 4px;
    }
    .ff-requests-form-wrap {
        max-height: 0;
        transition: .5s;
        overflow: hidden;
    }
    .active.ff-requests-form-wrap {
        max-height: 400px;
    }
</style>