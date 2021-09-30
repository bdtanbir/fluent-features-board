<template>
    <div class="ff-requests-list-box">
        <p>1 feature requests</p>
        <div class="ff-requests-list-body">
            <FFRequestList />
        </div>
    </div>
</template>

<script>
import FFRequestList from './FFRequestList.vue';

export default {
    components: {
        FFRequestList
    }
}
</script>

<style>
    .ff-requests-list-box {
        margin-top: 20px;
    }
    .ff-requests-list-box .ff-requests-list-body {
        border: 1px solid #e1eaea;
        padding: 15px;
        border-radius: 4px;
    }
    .ff-requests-list-box > p {
        font-size: 15px;
        color: #828897;
        margin: 0 0 5px 0;
    }
</style>