<template>
    <div class="ff-requests-list">
        <h1>({{items.length}}) Feature Requests</h1>
        <div v-if="items.length" class="ff-requests-list-inner">
            <FFRequestList v-for="item in items" :key="item.id" :item="item" />
        </div>
        <div v-else>
            <h1 class="no-feature-request">
                No Feature Requests
            </h1>
        </div>
    </div>
</template>

<script>
import FFRequestList from './FFRequestList.vue'
export default {
    props: ['items'],
    components: {
        FFRequestList
    }
    
}
</script>

<style>
    .ff-requests-list-inner {
        max-height: 550px;
        overflow-x: hidden;
    }
    .ff-requests-list {
        margin-top: 30px;
    }
    .ff-requests-list > h1 {
        font-size: 15px;
        font-weight: 300;
        color: #666;
        padding: 0;
        margin-bottom: 10px;
    }
    .ff-requests-list .no-feature-request {
        background: #eee;
        padding: 10px 13px;
        border-left: 3px solid #aaa;
        font-size: 18px;
        font-weight: 300;
    }
</style>