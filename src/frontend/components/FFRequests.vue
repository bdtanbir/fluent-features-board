<template>
    <div class="ff-requests-wrapper">
        <div class="ffr-wrap">
            <FFRequestsHeader />

            <FFRequestsList />
        </div>
    </div>
</template>

<script>
import FFRequestsHeader from './FFRequestsHeader.vue';
import FFRequestsList from './FFRequestsList.vue';

export default {
    components: {
        FFRequestsHeader,
        FFRequestsList
    },
    data() {
        return {

        }
    }
}
</script>

<style>
    .ff-requests-wrapper .ffr-wrap {
        padding: 30px 0;
    }
</style>