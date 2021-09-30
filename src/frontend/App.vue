<template>
  <div id="ff-requests-frontend-app">
    <!-- <router-link to="/Home">Home</router-link> -->
    <Header />

    <router-view />
    <Footer />
  </div>
</template>

<script>
import Header from '../frontend/components/Header.vue';
import Footer from '../frontend/components/Footer.vue';

export default {
  name: 'App',
  components: {
    Header,
    Footer
  }
}
</script>

<style>

</style>
