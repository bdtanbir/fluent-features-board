<template>
    <div class="ff-requests-header">
        <div class="d-flex">
            <button class="ff-addnewrequest">
                New Feature Request
            </button>
            <div class="ff-requests-search">
                <input type="search" name="s" placeholder="Search feature requests">
            </div>
        </div>

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
</template>

<script>
export default {
    
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
    }
</style>