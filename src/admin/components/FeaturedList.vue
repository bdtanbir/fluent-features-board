<template>
    <td>
        <h1><span>1.</span> <a href="">Title</a></h1>
        <div class="actions">
            <a href="" class="edit">Edit</a>
        </div>
    </td>
    
</template>

<script>
export default {
    
}
</script>

<style>
    .ffb-features-list h1 a {
        text-decoration: none;
        color: #000;
        display: inline-block;
    }
    .ffb-features-list h1 {
        font-size: 20px;
        font-weight: 500;
        padding: 0;
        margin: 0 0 2px 0;
        display: inline-block;
    }
    .ffb-features-list .actions {
        opacity: 0;
        visibility: hidden;
    }
    .ffb-featured-lists table tbody > tr:hover .actions {
        opacity: 1;
        visibility: visible;
    }
    .ffb-featured-lists table tbody td {
        border-bottom: 1px solid #eee;
        padding-bottom: 4px;
    }
</style>