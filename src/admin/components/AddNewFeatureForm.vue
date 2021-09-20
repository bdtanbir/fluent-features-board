<template>
    <div class="ffb-add-new-feature-modal">
        <div class="ffb-add-new-feature-modal-content">
            <h1>Add New</h1>
            <form @submit.prevent="formSubmited">
                <div class="input-group">
                    <label for="feature-title">
                        Title
                    </label>
                    <input type="text" id="feature-title" v-model="title">
                </div>
                <div class="input-group">
                    <label for="feature-description">
                        Description
                    </label>
                    <input type="text" id="feature-description" v-model="description">
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
export default {
    data() {
        return {
            title: '',
            description: '',
            tmplTags: ''
        }
    },
    methods: {
        formSubmited: function() {
            if (this.title && this.description && this.tmplTags) {
                console.log('Submited');
            }
        }
    },
    mounted() {

    }
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
</style>