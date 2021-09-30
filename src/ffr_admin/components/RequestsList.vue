<template>
    <div class="ff-requests-lists">
        <div class="ff-requests-lists-inner">

            <table class="ff-request-list-table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <th>Title</th>
                        <th>Shortcode</th>
                        <th>Tags</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <RequestList />
                </tbody>
            </table>
            
        </div>
        <p class="ff-requests-total-rows">(1) Row</p>
    </div>
</template>

<script>
import RequestList from './RequestList.vue';

export default {
    components: {
        RequestList
    }
}
</script>

<style>
</style>