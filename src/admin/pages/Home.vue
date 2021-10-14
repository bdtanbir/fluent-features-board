<template>
  <div class="home">
    
    <FeaturedLists />
  </div>
</template>

<script>
import FeaturedLists from '../components/FeaturedLists.vue';

export default {
  name: "Home",
  components: {
    FeaturedLists
  }
};
</script>

<style>
  #fluent-features-board-backend-app header {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 4px;
    padding: 14px 15px;
  }
  #fluent-features-board-backend-app header > h1 {
    padding: 0;
  }
  #fluent-features-board-backend-app header nav {
    margin-left: 20px;
  }
  #fluent-features-board-backend-app header nav ul li,
  #fluent-features-board-backend-app header nav ul {
    margin: 0;
  }
  #fluent-features-board-backend-app header nav ul li a {
    background: #eee;
    display: inline-block;
    text-decoration: none;
    padding: 7px 15px;
    border-radius: 4px;
    font-weight: 600;
    color: #000;
    border-bottom: 2px solid;
    transition: .3s;
  }
  #fluent-features-board-backend-app header nav ul li a:focus {
    outline: none;
    box-shadow: none;
  }
  #fluent-features-board-backend-app header nav ul li a:hover,
  #fluent-features-board-backend-app header nav ul li a.router-link-exact-active {
    background: #ba42ec;
    color: #ffffff;
    border-bottom: 2px solid #8f42ec;
  }
</style>