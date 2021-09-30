<template>
  <div id="fluent-features-requests-app">
    <header>
      <h1>Fluent Features Requests</h1>
      <!-- <nav>
        <ul><li><router-link to="/">All Items</router-link></li></ul>
      </nav> -->
    </header>
    <button class="addnew-feature-request">
      Add New Request
    </button>
    <router-view />

    <AddFFRequestForm />
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
    }
  },
  methods: {
      
  },
};
</script>

<style>
  *,*:before,*:after {
    box-sizing: border-box;
  }
  .ff-request-single-wrap form .ff-request-single-update-btn button,
  .addnew-features-list {
    display: inline-block;
    background: #2771b1;
    color: #fff;
    padding: 6px 15px;
    border-radius: 4px;
    margin-top: 15px;
    cursor: pointer;
  }
</style>
