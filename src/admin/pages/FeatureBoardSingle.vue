<template>
    <div class="ffb-single-wrap ffr-feature-board-single">
        <router-link to="/" class="back-to-home-btn">Back</router-link>
        
        <div class="ffr-feature-board-single-header">
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
                        <label for="ffr-tags">
                            Tags
                        </label>
                        <input type="text" id="ffr-tags" v-model="tempSkill" @keyup.188="addSkill">
                        <span class="description">
                            Separate tags with <strong>commas</strong>
                        </span>
                        <div class="ffr-tags-list">
                            {{skills}}
                            <span v-for="skill in skills" :key="skill" v-tooltip.top-center="'Click To Remove'" @click="deleteSkill(skill)">{{skill}}</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <button :class="isSubmitting ? 'submitting-request ff-request-submit' : 'ff-request-submit'">
                            <span v-if="isSubmitting" class="update-loader"></span> {{submitBtnText}}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            isFeatureRequestForm: false,
            tempSkill: '',
            skills: [],
            isEmptyTitle: false,
            isEmptyDesc: false,
            title: '',
            description: '',
            isSubmitting: false,
            submitBtnText: 'Suggest Feature'
        }
    },    
    methods: {
        addSkill(e) {
            this.tempSkill = this.tempSkill.replace(',', '')
            if (e.key === "," && this.tempSkill) {
                if (!this.skills.includes(this.tempSkill)) {
                this.skills.push(this.tempSkill);
                }
                this.tempSkill = "";
            }
        },
        deleteSkill(skill) {
            this.skills = this.skills.filter((item) => {
                return skill !== item;
            });
        },
        handleFFRequestForm() {
            this.isFeatureRequestForm  = !this.isFeatureRequestForm;
        },
        submitFeatureRequest() {
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
            this.submitBtnText = 'Submitting...'
            setTimeout(() => {
                this.isSubmitting = false
                this.submitBtnText = 'Submitted'
                console.log('Title: '+this.title);
                console.log('Description: '+this.description);
                console.log('Tags: '+this.skills);
                console.log('Submited');
                setTimeout(() => {
                    this.submitBtnText = 'Suggest Feature';
                }, 1500);
            }, 3000);

        }
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
        font-size: 16px;
        font-weight: 400;
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
</style>