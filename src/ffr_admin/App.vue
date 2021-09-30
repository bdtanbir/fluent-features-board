<template>
  <div id="fluent-features-requests-app">
    <header>
      <h1>Fluent Features Requests</h1>
      <!-- <nav>
        <ul><li><router-link to="/">All Items</router-link></li></ul>
      </nav> -->
    </header>
    <button class="addnew-feature-request" @click="handleShowAddnewFFRModal">
      New Feature Request
    </button>
    <router-view />

    <AddFFRequestForm v-if="isAddnewFFRModal" @hideAddNewFFRForm="hideAddNewFFRForm" />
  </div>
</template>

<script>
import AddFFRequestForm from './components/AddFFRequestForm.vue';

export default {
  name: "App",
  components: {
    AddFFRequestForm
  },
  data() {
    return {
      isAddnewFFRModal: false
    }
  },
  methods: {
    handleShowAddnewFFRModal() {
      this.isAddnewFFRModal = true;
    },
    hideAddNewFFRForm() {
      this.isAddnewFFRModal = false;
    }
      
  },
};
</script>

<style>
  *,*:before,*:after {
    box-sizing: border-box;
  }
  .ff-request-single-wrap form .ff-request-single-update-btn button,
  .addnew-feature-request {
    display: inline-block;
    background: #2771b1;
    color: #fff;
    padding: 8px 15px;
    border-radius: 4px;
    margin-top: 15px;
    cursor: pointer;
    border: none;
  }
</style>
