<template>
    <div class="ff-request-list">
        <div class="ff-request-vote">
            <span class="ff-request-vote-btn"></span>
            <span class="ff-request-vote-count">10</span>
        </div>
        <div class="ff-request-content">
            <h3>Fluent feature request</h3>
            <p>{{item.description.substr(0,100)}}</p>
        </div>
        <div class="ff-request-comment-count">
            <span class="comment-icon"></span>
            <span class="comment-number">10</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['item'],
    data() {
        return {
            shortDesc: '',
        }
    }    
}
</script>

<style>
    .ff-requests-list .ff-request-list {
        display: flex;
        align-items: flex-start;
        border: 1px solid #e1eaea;
        padding: 15px;
        border-radius: 4px;
    }
    .ff-requests-list .ff-request-list + .ff-request-list {
        margin-top: 20px;
    }
    .ff-requests-list .ff-request-list .ff-request-vote {
        border: 1px solid #e1eaea;
        border-radius: 4px;
        min-width: 45px;
        text-align: center;
        padding: 10px 0 8px 0;
        color: #828897;
        font-size: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .ff-requests-list .ff-request-list .ff-request-vote .ff-request-vote-btn {
        width: 10px;
        height: 10px;
        display: inline-block;
        border-right: 6px solid #a8adb9;
        border-top: 6px solid #a8adb9;
        border-bottom: 6px solid transparent;
        border-left: 6px solid transparent;
        transform: rotate(-45deg);
    }
    .ff-requests-list .ff-request-list .ff-request-vote .ff-request-vote-count {
        line-height: 14px;
    }
    .ff-requests-list .ff-request-list .ff-request-content {
        flex: 1;
        margin: 0 15px;
    }
    .ff-requests-list .ff-request-list .ff-request-content h3 {
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 5px 0;
    }
    .ff-requests-list .ff-request-list .ff-request-content h3 a {
        text-decoration: none;
        color: #ba42ec;
    }
    .ff-requests-list .ff-request-list .ff-request-content h3 a:hover {
        color: #8f42ec;
    }
    .ff-requests-list .ff-request-list .ff-request-content p {
        font-size: 15px;
        font-weight: 400;
        color: #878787;
        margin: 0;
    }
    .ff-requests-list .ff-request-list .ff-request-comment-count {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .ff-requests-list .ff-request-list .ff-request-comment-count .comment-icon {
        display: inline-block;
        width: 16px;
        height: 12px;
        border-radius: 2px;
        background: #e3e3e3;
        position: relative;
    }
    .ff-requests-list .ff-request-list .ff-request-comment-count .comment-icon:before {
        content: '';
        position: absolute;
        width: 6px;
        height: 6px;
        background: #e3e3e3;
        bottom: -2px;
        left: 3px;
        transform: skew(0deg, -43deg);
    }
    .ff-requests-list .ff-request-list .ff-request-comment-count .comment-number {
        font-size: 15px;
        display: inline-block;
        margin-left: 5px;
        color: #828897;
    }
    
</style>