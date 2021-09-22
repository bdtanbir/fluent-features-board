<template>
  <div id="fluent-features-board-backend-app">
    <header>
      <h1>Fluent Features Board</h1>
      <nav>
        <ul><li><router-link to="/">All Items</router-link></li></ul>
      </nav>
    </header>
    <div class="addnew-features-list" @click="handleAddNewFeature">
      Add New
    </div>
    <router-view />

    <AddNewFeatureForm v-if="isAddnewModal" @hideAddNewForm="hideAddNewFormClb" />
  </div>
</template>

<script>
import AddNewFeatureForm from './components/AddNewFeatureForm.vue';

export default {
  name: "App",
  components: {
    AddNewFeatureForm
  },
  data() {
    return {
      isAddnewModal: false
    }
  },
  methods: {
    handleAddNewFeature: function() {
      this.isAddnewModal = true
    },
    hideAddNewFormClb() {
      this.isAddnewModal = false;
    }
  },
};
</script>

<style>
  .ffb-single-wrap form .ffb-single-update-btn button,
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
