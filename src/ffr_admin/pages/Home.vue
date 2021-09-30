<template>
  <div class="ffr-home">
    <RequestsList />
  </div>
</template>

<script>
import RequestsList from '../components/RequestsList.vue';

export default {
  name: "Home",
  components: {
    RequestsList
  }
};
</script>

<style>

  #fluent-features-requests-app header {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 4px;
    padding: 8px 15px;
  }
  #fluent-features-requests-app header nav {
    margin-left: 20px;
  }
  #fluent-features-requests-app header nav ul li,
  #fluent-features-requests-app header nav ul {
    margin: 0;
  }
  #fluent-features-requests-app header nav ul li a {
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
  #fluent-features-requests-app header nav ul li a:focus {
    outline: none;
    box-shadow: none;
  }
  #fluent-features-requests-app header nav ul li a:hover,
  #fluent-features-requests-app header nav ul li a.router-link-exact-active {
    background: #2771b1;
    color: #ffffff;
    border-bottom: 2px solid #13395a;
  }
</style>