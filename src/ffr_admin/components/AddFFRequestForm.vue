<template>
    <div class="ff-request-form-modal" @click.self="handleHideAddNewFFRForm">
        <div :class="isLoading ? 'adding-ffb ff-request-form-modal-content' : 'ff-request-form-modal-content'">
            <span @click="handleHideAddNewFFRForm" class="close-ffb-add-new-modal">+</span>
            <div v-show="isLoading || isDone" :class="isDone ? 'added-ffb form-loader' : 'form-loader'">
                <span></span>
                <h2 v-if="isDone" class="ffb-form-added">Done</h2>
                <a v-if="isDone" href="" class="done-btn">OK</a>
            </div>
            <h1>New Feature Request</h1>
            <form class="hidden-form" @submit.prevent="ffrequest_submit">
                <div class="input-group">
                    <label for="ffr-title">
                        Title
                    </label>
                    <input type="text" id="ffr-title" required v-model="title">
                </div>
                <div class="input-group">
                    <label for="ffr-description">
                        Description
                    </label>
                    <textarea name="description" id="ffr-description" required  v-model="description"></textarea>
                </div>
                <div class="input-group">
                    <label for="ffr-tags">
                        Tags
                    </label>
                    <input type="text" id="ffr-tags" v-model="tempSkill" @keyup.188="addSkill">
                    <!-- <input type="hidden" id="ffr-alltags"  :value="skills"> -->
                    <span class="description">
                        Separate tags with <strong>commas</strong>
                    </span>
                    <div class="ffr-tags-list">
                        <span v-for="skill in skills" :key="skill" @click="deleteSkill(skill)">{{skill}}</span>
                    </div>
                </div>
                <div class="input-group input-checkbox">
                    <input type="checkbox" id="ffr-status" v-model="status">
                    <label for="ffr-status">
                        Make it Private
                    </label>
                </div>
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
// import $ from 'jquery';

export default {
    data() {
        return {
            title: '',
            tempSkill: '',
            skills: [],
            description: '',
            status: false,
            isDone: false,
            isLoading: false
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
        handleHideAddNewFFRForm() {
            this.$emit('hideAddNewFFRForm')
        },
        ffrequest_submit() {
            this.isLoading = true;
            setTimeout(() => {
                console.log('submited');
                console.log('Title: '+this.title);
                console.log('Description: '+this.description);
                console.log('Skills: '+this.skills);
                console.log('Status: '+this.status); 
                this.isDone = true  
                this.isLoading = false; 
            }, 3000);
        }
    },
}
</script>
<style>
    .ff-request-form-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        background: rgba(0,0,0,0.5);
        z-index: 99;
    }
    .ff-request-form-modal .ff-request-form-modal-content {
        background: #fff;
        margin-top: 100px;
        border-radius: 4px;
        width: 100%;
        max-width: 500px;
        padding: 20px 30px 30px 30px;
        position: relative;
    }
    .ff-request-form-modal .ff-request-form-modal-content h1 {
        padding: 0;
        font-size: 22px;
        margin-bottom: 20px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group + .input-group {
        margin-top: 15px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group .ffr-tags-list {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 7px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group .ffr-tags-list span {
        margin-right: 5px;
        background: #f1f1f1;
        padding: 2px 7px;
        border-radius: 30px;
        cursor: pointer;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group textarea,
    .ff-request-form-modal .ff-request-form-modal-content form .input-group input {
        display: block;
        width: 100%;
        border: 1px solid #eee;
        padding: 3px 13px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: inline-block;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group input[type="checkbox"] {
        width: auto;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox {
        display: flex;
        align-items: center;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        box-shadow: none;
        border: 1px solid #eee;
        border-radius: 2px;
        margin: 0;
        position: relative;
        transition: .3s;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox input[type="checkbox"]:before {
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
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox input[type="checkbox"]:checked:before {
        left: 10px;
        top: 6px;
        transform: rotate(33deg) scale(1);
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox input[type="checkbox"]:checked {
        background: #ba42ec;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox input[type="checkbox"]:checked {
        border-color: #ba42ec;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-checkbox label {
        margin: 0 0 0 8px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .input-group .ffb-addnewfeature-submit {
        background: #2771b1;
        border: none;
        color: #fff;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .description {
        font-weight: 300;
        display: block;
        color: #aaa;
        font-size: 12px;
        font-style: italic;
        margin: 3px 0 0 0;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .description strong {
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
    .ff-request-form-modal .ff-request-form-modal-content form .tags {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 8px;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .tags span {
        background: #eee;
        border-radius: 30px;
        margin-right: 5px;
        padding: 1px 8px 3px 8px;
        display: inline-block;
        cursor: pointer;
        transition: .2s;
    }
    .ff-request-form-modal .ff-request-form-modal-content form .tags span:hover {
        opacity: 0.5;
    }
    .ff-request-form-modal .ff-request-form-modal-content .close-ffb-add-new-modal {
        position: absolute;
        right: -10px;
        top: -10px;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background: #fff;
        border-radius: 50%;
        transform: rotate(45deg);
        font-size: 20px;
        cursor: pointer;
        box-shadow: 0 0 20px rgb(0 0 0 / 15%);
        z-index: 999;
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